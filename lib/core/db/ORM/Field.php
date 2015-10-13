<?php
/**
 * Created by YASSTRIM.
 * Date: 08.06.15
 * Time: 16:06
 */

namespace lib\core\db\ORM;


class Field {
    private $name;
    private $typeName;
    private $primary = false;
    private $unique = false;
    private $options = [];
    private $entityClass = false;

    public function __construct($name, $typeName){
        $this->name = $name;
        $this->typeName = $typeName;
    }

    public function primary(){
        $this->primary = true;
        $this->options['autoincrement'] = true;
        return $this;
    }

    public function unique(){
        $this->unique = true;
        return $this;
    }

    public function options($options){
        $this->options = $options;
        return $this;
    }

    public function entity($class){
        $this->entityClass = $class;
        $this->typeName = 'entity';
        $this->options['notnull'] = false;
        return $this;
    }

    public function isPrimary(){
        return $this->primary;
    }

    public function getName(){
        return $this->name;
    }

    public function getEntityClass(){
        return $this->entityClass;
    }

    public function isForeignKey(){
//        var_dump($this->typeName);
        return $this->typeName ;
    }

}