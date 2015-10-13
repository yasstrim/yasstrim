<?php
/**
 * Created by PhpStorm.
 * User: yasstrim
 * Date: 03.08.15
 * Time: 13:16
 */

namespace lib\core\db\ORM;


class EntityManager {



    public static function meta($class){
//        var_dump($class);
        $meta = $class::describe();
        return $meta;
    }


}