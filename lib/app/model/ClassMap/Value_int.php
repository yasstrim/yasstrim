<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Value_int {

    use Setter;
    use BaseFunctions;


    private $idvalue_int;
    private $value_int_value;
    private $NScat_idNScat;
    private $advert_idadvert;
    public static function describe(){
        $meta = new Meta();
        $meta->table('value_int');
        $meta->field('idvalue_int', 'integer')->primary();
        $meta->field('value_int_value', 'integer');
        $meta->field('NScat_idNScat', 'integer')->primary();
        $meta->field('advert_idadvert', 'entity')->entity(Advert::class);
        return $meta;
	}
}