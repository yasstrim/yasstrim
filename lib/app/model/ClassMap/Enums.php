<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Enums {

    use Setter;
    use BaseFunctions;


    private $idenums;
    private $enums_NScat;
    private $enums_value;
    public static function describe(){
        $meta = new Meta();
        $meta->table('enums');
        $meta->field('idenums', 'integer')->primary();
        $meta->field('enums_NScat', 'entity')->entity(NScat::class);
        $meta->field('enums_value', 'string');
        return $meta;
	}
}