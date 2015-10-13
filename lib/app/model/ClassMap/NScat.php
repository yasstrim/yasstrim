<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class NScat {

    use Setter;
    use BaseFunctions;


    private $idNScat;
    private $NScat_name;
    private $NScat_description;
    private $NScat_date;
    private $NScat_parent;
    private $left_key;
    private $right_key;
    private $level;
    public static function describe(){
        $meta = new Meta();
        $meta->table('NScat');
        $meta->field('idNScat', 'integer')->primary();
        $meta->field('NScat_name', 'string');
        $meta->field('NScat_description', 'enum', ['notFinal','Final','value_decimal','value_int','value_varchar']);
        $meta->field('NScat_date', 'string');
        $meta->field('NScat_parent', 'integer');
        $meta->field('left_key', 'entity');
        $meta->field('right_key', 'integer');
        $meta->field('level', 'integer');
        return $meta;
	}
}