<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class CompanyComments {

    use Setter;
    use BaseFunctions;


    private $idcompanyComments;
    private $companyComments_text;
    private $company_idcompany;
    private $user_iduser;
    private $companyComments_date;
    private $companyComments_type;
    public static function describe(){
        $meta = new Meta();
        $meta->table('companyComments');
        $meta->field('idcompanyComments', 'integer')->primary();
        $meta->field('companyComments_text', 'string');
        $meta->field('company_idcompany', 'entity')->entity(Company::class);
        $meta->field('user_iduser', 'entity')->entity(User::class);
        $meta->field('companyComments_date', 'string');
        $meta->field('companyComments_type', 'enum', ['positive','negative']);
        return $meta;
	}
}