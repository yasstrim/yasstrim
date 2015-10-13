<?php
/**
 * Created by PhpStorm.
 * User: yasstrim
 * Date: 15.07.15
 * Time: 16:09
 */

namespace lib\core\db\ORM;


trait Setter {

    public function __get($name){
        if($this->{$name}&&($this->{$name} instanceof Field)){
            return $this->{$name};
        }
        $field = self::describe()->getFieldByName($name);
        if ($field && $field->isForeignKey()=='entity'){
            $this->{$name}=$field;
        }
        return $this->{$name};
    }

    public function __set($name,$value){
//        var_dump($value);
        $this->{$name} = $value;
    }


//    -----------------------------------------------------------

    public function __unset($name){
//        echo 'test = '.$this->name;
        unset($this->name);
    }


}