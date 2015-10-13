<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Roles {

    use Setter;
    use BaseFunctions;


    private $idroles;
    private $name_ru;
    private $name_en;
    public static function describe(){
        $meta = new Meta();
        $meta->table('roles');
        $meta->field('idroles', 'string')->primary();
        $meta->field('name_ru', 'string')->unique();
        $meta->field('name_en', 'string');
        return $meta;
	}
}