<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Cities {

    use Setter;
    use BaseFunctions;


    private $idcities;
    private $cities_name;
    private $cities_code;
    private $cities_region;
    public static function describe(){
        $meta = new Meta();
        $meta->table('cities');
        $meta->field('idcities', 'integer')->primary();
        $meta->field('cities_name', 'string');
        $meta->field('cities_code', 'string');
        $meta->field('cities_region', 'entity')->entity(Regions::class);
        return $meta;
	}
}