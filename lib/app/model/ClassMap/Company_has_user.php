<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Company_has_user {

    use Setter;
    use BaseFunctions;


    private $idcompany_has_user;
    private $company_idcompany;
    private $user_iduser;
    private $active;
    private $roles_idroles;
    private $company_has_user_date;
    public static function describe(){
        $meta = new Meta();
        $meta->table('company_has_user');
        $meta->field('idcompany_has_user', 'integer')->primary();
        $meta->field('company_idcompany', 'entity')->entity(Company::class);
        $meta->field('user_iduser', 'entity')->entity(User::class);
        $meta->field('active', 'enum', ['expects','confirmed','rejected']);
        $meta->field('roles_idroles', 'entity')->entity(Roles::class);
        $meta->field('company_has_user_date', 'string');
        return $meta;
	}
}