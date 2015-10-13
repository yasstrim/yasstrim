<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Advert {

    use Setter;
    use BaseFunctions;


    private $idadvert;
    private $advert_title;
    private $advert_description;
    private $advert_date;
    private $advert_price;
    private $advert_review;
    private $advert_status;
    private $NScat_idNScat;
    private $user_iduser;
    private $location_idlocation;
    private $company_idcompany;
    public static function describe(){
        $meta = new Meta();
        $meta->table('advert');
        $meta->field('idadvert', 'integer')->primary();
        $meta->field('advert_title', 'string');
        $meta->field('advert_description', 'string');
        $meta->field('advert_date', 'string');
        $meta->field('advert_price', 'string');
        $meta->field('advert_review', 'integer');
        $meta->field('advert_status', 'entity')->entity(Advert_status::class);
        $meta->field('NScat_idNScat', 'entity')->entity(NScat::class);
        $meta->field('user_iduser', 'entity')->entity(User::class);
        $meta->field('location_idlocation', 'entity')->entity(Cities::class);
        $meta->field('company_idcompany', 'entity')->entity(Company::class);
        return $meta;
	}
}