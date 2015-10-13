<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Regions {

    use Setter;
    use BaseFunctions;


    private $idregions;
    private $idkladr;
    private $name;
    private $type;
    public static function describe(){
        $meta = new Meta();
        $meta->table('regions');
        $meta->field('idregions', 'integer')->primary();
        $meta->field('idkladr', 'string');
        $meta->field('name', 'string');
        $meta->field('type', 'string');
        return $meta;
	}
}