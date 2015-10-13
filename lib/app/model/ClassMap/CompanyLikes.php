<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class CompanyLikes {

    use Setter;
    use BaseFunctions;


    private $idcompanyLikes;
    private $company_idcompany;
    private $user_iduser;
    private $companyLikes_like;
    public static function describe(){
        $meta = new Meta();
        $meta->table('companyLikes');
        $meta->field('idcompanyLikes', 'integer')->primary();
        $meta->field('company_idcompany', 'entity')->entity(Company::class);
        $meta->field('user_iduser', 'entity')->entity(User::class);
        $meta->field('companyLikes_like', 'enum', ['like','dislike']);
        return $meta;
	}
}