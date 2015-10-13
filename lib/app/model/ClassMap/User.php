<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class User {

    use Setter;
    use BaseFunctions;


    private $iduser;
    private $user_uid;
    private $user_name;
    private $user_pass;
    private $user_hash;
    private $user_role;
    private $user_date;
    private $user_status;
    private $user_email;
    private $user_surname;
    private $user_patronymic;
    private $user_tel;
    private $user_img;
    private $user_city;
    private $user_skype;
    private $user_viber;
    public static function describe(){
        $meta = new Meta();
        $meta->table('user');
        $meta->field('iduser', 'integer')->primary();
        $meta->field('user_uid', 'string')->unique();
        $meta->field('user_name', 'string');
        $meta->field('user_pass', 'string');
        $meta->field('user_hash', 'string');
        $meta->field('user_role', 'enum', ['admin','user']);
        $meta->field('user_date', 'string');
        $meta->field('user_status', 'string');
        $meta->field('user_email', 'string');
        $meta->field('user_surname', 'string');
        $meta->field('user_patronymic', 'string');
        $meta->field('user_tel', 'string');
        $meta->field('user_img', 'string');
        $meta->field('user_city', 'integer');
        $meta->field('user_skype', 'string');
        $meta->field('user_viber', 'string');
        return $meta;
	}
}