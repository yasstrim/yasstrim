<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Company {

    use Setter;
    use BaseFunctions;


    private $idcompany;
    private $company_name;
    private $company_description;
    private $company_email;
    private $company_date;
    private $company_deleted;
    private $company_phone;
    public static function describe(){
        $meta = new Meta();
        $meta->table('company');
        $meta->field('idcompany', 'integer')->primary();
        $meta->field('company_name', 'string')->unique();
        $meta->field('company_description', 'string');
        $meta->field('company_email', 'string');
        $meta->field('company_date', 'string');
        $meta->field('company_deleted', 'string');
        $meta->field('company_phone', 'string');
        return $meta;
	}
}