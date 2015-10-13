<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Advert_has_shipping {

    use Setter;
    use BaseFunctions;


    private $idadvert_has_shipping;
    private $shipping_idshipping;
    private $advert_idadvert;
    private $advert_has_shipping_description;
    private $advert_has_shipping_date;
    private $advert_has_shipping_show;
    public static function describe(){
        $meta = new Meta();
        $meta->table('advert_has_shipping');
        $meta->field('idadvert_has_shipping', 'integer')->primary();
        $meta->field('shipping_idshipping', 'entity')->entity(Shipping::class);
        $meta->field('advert_idadvert', 'entity')->entity(Advert::class);
        $meta->field('advert_has_shipping_description', 'string');
        $meta->field('advert_has_shipping_date', 'string');
        $meta->field('advert_has_shipping_show', 'string');
        return $meta;
	}
}