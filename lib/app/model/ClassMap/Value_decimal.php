<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Value_decimal {

    use Setter;
    use BaseFunctions;


    private $idvalue_decimal;
    private $value_decimal_value;
    private $NScat_idNScat;
    private $advert_idadvert;
    public static function describe(){
        $meta = new Meta();
        $meta->table('value_decimal');
        $meta->field('idvalue_decimal', 'integer')->primary();
        $meta->field('value_decimal_value', 'string');
        $meta->field('NScat_idNScat', 'integer')->primary();
        $meta->field('advert_idadvert', 'entity')->entity(Advert::class);
        return $meta;
	}
}