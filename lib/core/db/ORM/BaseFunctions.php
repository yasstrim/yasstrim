<?php
/**
 * Created by PhpStorm.
 * User: yasstrim
 * Date: 11.07.15
 * Time: 15:18
 */

namespace lib\core\db\ORM;


trait BaseFunctions {


    public function findById($id){
        $db = BasePdo::getInstance(); //соединение с БД
        $class = get_called_class();
        $meta = EntityManager::meta($class);  // мета основного класса
        $table = $meta->getTable(); // получаем имя таблицы БД
        $entityFields = $meta->getFieldsWhatHasEntities(); // поля со связями
        $primaryField = $meta->getPrimaryField(); // поле первичного ключа
        $mainObject = $db->selectRow($table,$primaryField,$id); //результат основной объект
//        $this->intoObject($mainObject,$this); // вносим данные в поля основного объекта
        if(!empty($entityFields)){
            foreach ($entityFields as $key){
                $name = $key->getName(); // поле сущности
                $entityClassName = $key->getEntityClass(); // класс сущности
                $entityClass = new $entityClassName; // объект сущности
                $meta = EntityManager::meta($entityClassName); // мета сущности
                $table = $meta->getTable(); //имя таблицы сущности
                $primaryField = $meta->getPrimaryField(); //первичный ключ сущности
                $primaryFieldValue = $mainObject->{$key->getName()}; // значение первичного ключа
                $entityObject = $db->selectRow($table,$primaryField,$primaryFieldValue); //результат выборки сущности
                $this->{$name} = $entityClass;
                $mainObject->{$name} = $entityObject;
//                $this->intoObject($entityObject,$entityClass);
            }

        }
        return $mainObject;

    }

    public function save(){
        $db = BasePdo::getInstance();
        $meta = EntityManager::meta($this);
        $table = $meta->getTable(); //имя таблицы сущности
        $primaryField = $meta->getPrimaryField(); //первичный ключ сущности
        $primaryFieldValue = $this->{$primaryField};
        if(is_null($primaryFieldValue)){
            throw new OrmException("не указан ID сущности для записи");
        }
        $baseEntity = $db->selectRow($table,$primaryField,$primaryFieldValue);
        if(!$baseEntity){
            throw new OrmException("не существует сущности - $table c первичным ключом - $primaryField равным $primaryFieldValue");
        }
        $baseObj = new \stdClass();
        $entityObj = array();
        foreach ($this as $name=>$val){
            if(!is_null($val)){
                if(!is_object($val)){
                    $baseObj->{$name}=$val;
                }
                else{
                    var_dump($val);
                    $entityClassName = $val->getEntityClass();
//                    $meta = EntityManager::meta($entityClassName);
//                    $tableName = $meta->getTable();
                    $entityObj[$entityClassName] = new \stdClass();
                    foreach ($val as $ename=>$eval){
//                        var_dump($val);
                        $entityObj[$entityClassName]->{$ename}=$eval;
                    }
                }
            }
        }
//        var_dump($baseObj);
//        var_dump($entityObj);
        if(empty($entityObj)){
            return $db->updateRow($table,$baseObj,$primaryField);
        }
        else{
            $bool = false;
            $db->beginTrans();
            if(!$db->updateRow($table,$baseObj,$primaryField)){
                return false;
            }
            foreach($entityObj as $name=>$val){
//                var_dump($name);
                $meta = EntityManager::meta($name);
                $tableName = $meta->getTable();
                $primaryField = $meta->getPrimaryField();
                var_dump($primaryField);
                if(!$db->updateRow($tableName,$val,$primaryField)){
                    $db->rollbackTrans();
                    $bool=true;
                }
            }
            if(!$bool){
                $db->commitTrans();
            }

        }

//        var_dump($this);


//        $meta = EntityManager::meta($this);
//        foreach ($this as $field=>$value){
//            if($value!=NULL){
//                $metaField = $meta->getFieldByName($field);
//                $hasEntity = $metaField->getEntityClass();
//                if(!$hasEntity){
//                    $obj->$field = $value;
//                }else{
////                    var_dump($value);
//                    foreach ($value as $key=>$v) {
////                        var_dump($v);
//                    }
//
//                }
//
//            }
//
//        }
    }

    private function intoObject($obj,$entity){
        foreach($obj as $field=>$value){
            $entity->{$field} = $value;
        }
    }



}