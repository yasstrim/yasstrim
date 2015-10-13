<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Shipping {

    use Setter;
    use BaseFunctions;


    private $idshipping;
    private $shipping_name;
    private $shipping_description;
    private $shipping_date;
    private $shipping_show;
    public static function describe(){
        $meta = new Meta();
        $meta->table('shipping');
        $meta->field('idshipping', 'integer')->primary();
        $meta->field('shipping_name', 'string');
        $meta->field('shipping_description', 'string');
        $meta->field('shipping_date', 'string');
        $meta->field('shipping_show', 'string');
        return $meta;
	}
}