<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Roles_has_action {

    use Setter;
    use BaseFunctions;


    private $idroles_has_action;
    private $roles_idroles;
    private $action_idaction;
    public static function describe(){
        $meta = new Meta();
        $meta->table('roles_has_action');
        $meta->field('idroles_has_action', 'integer')->primary();
        $meta->field('roles_idroles', 'entity')->entity(Roles::class);
        $meta->field('action_idaction', 'entity')->entity(Action::class);
        return $meta;
	}
}