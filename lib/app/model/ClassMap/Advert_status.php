<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Advert_status {

    use Setter;
    use BaseFunctions;


    private $idadvert_status;
    private $advert_status_name;
    private $advert_status_description;
    private $advert_status_date;
    private $advert_status_user;
    private $advert_status_price;
    private $advert_status_color;
    private $advert_status_prioritet;
    public static function describe(){
        $meta = new Meta();
        $meta->table('advert_status');
        $meta->field('idadvert_status', 'string')->primary();
        $meta->field('advert_status_name', 'string');
        $meta->field('advert_status_description', 'string');
        $meta->field('advert_status_date', 'string');
        $meta->field('advert_status_user', 'entity')->entity(User::class);
        $meta->field('advert_status_price', 'string');
        $meta->field('advert_status_color', 'string');
        $meta->field('advert_status_prioritet', 'string');
        return $meta;
	}
}