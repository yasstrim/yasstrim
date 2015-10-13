<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Value_varchar {

    use Setter;
    use BaseFunctions;


    private $idvalue_varchar;
    private $value_varchar_value;
    private $NScat_idNScat;
    private $advert_idadvert;
    public static function describe(){
        $meta = new Meta();
        $meta->table('value_varchar');
        $meta->field('idvalue_varchar', 'integer')->primary();
        $meta->field('value_varchar_value', 'entity');
        $meta->field('NScat_idNScat', 'entity')->entity(NScat::class);
        $meta->field('advert_idadvert', 'entity')->entity(Advert::class);
        return $meta;
	}
}