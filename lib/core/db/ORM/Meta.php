<?php
/**
 * Created by yasstrim
 * Date: 05.06.15
 * Time: 15:18
 */

namespace lib\core\db\ORM;


class Meta {

    private $table;
    private $fields = [];
    private $fieldsWhatHasEntities = [];

    public function __construct(){

    }

    public function table($table){
        $this->table = $table;

    }

    public function field($name, $type){
        $this->fields[$name] = new Field($name, $type);

        if ($type === 'entity') {
            $this->fieldsWhatHasEntities[$name] = $this->fields[$name];
        }

        return $this->fields[$name];
    }

    public function getTable(){
        return $this->table;
    }

    public function getPrimaryField(){
        foreach ($this->fields as $field) {
            if ($field->isPrimary()) {
                return $field->getName();
            }
        }

        throw new \RuntimeException('Entity does not contain primary field.');
    }

    public function getFieldsWhatHasEntities(){
        return $this->fieldsWhatHasEntities;
    }

    public function getFieldByName($fieldName)
    {
        return $this->fields[$fieldName];
    }



}