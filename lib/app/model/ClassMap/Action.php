<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Action {

    use Setter;
    use BaseFunctions;


    private $idaction;
    private $action_name;
    private $action_description;
    public static function describe(){
        $meta = new Meta();
        $meta->table('action');
        $meta->field('idaction', 'integer')->primary();
        $meta->field('action_name', 'string');
        $meta->field('action_description', 'string');
        return $meta;
	}
}