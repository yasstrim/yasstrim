<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Orders {

    use Setter;
    use BaseFunctions;


    private $idorders;
    private $orders_summ;
    private $orders_onpay_id;
    private $orders_user_phone;
    private $orders_user_email;
    private $orders_create_date;
    private $orders_payed_date;
    private $orders_payed;
    private $orders_advert;
    private $orders_status;
    public static function describe(){
        $meta = new Meta();
        $meta->table('orders');
        $meta->field('idorders', 'integer')->primary();
        $meta->field('orders_summ', 'string');
        $meta->field('orders_onpay_id', 'string');
        $meta->field('orders_user_phone', 'string');
        $meta->field('orders_user_email', 'string');
        $meta->field('orders_create_date', 'string');
        $meta->field('orders_payed_date', 'string');
        $meta->field('orders_payed', 'string');
        $meta->field('orders_advert', 'entity')->entity(Advert::class);
        $meta->field('orders_status', 'entity')->entity(Advert_status::class);
        return $meta;
	}
}