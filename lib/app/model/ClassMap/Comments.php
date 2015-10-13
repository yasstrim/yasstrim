<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Comments {

    use Setter;
    use BaseFunctions;


    private $idcomments;
    private $advert_idadvert;
    private $comments_text;
    private $comments_date;
    private $user_iduser;
    public static function describe(){
        $meta = new Meta();
        $meta->table('comments');
        $meta->field('idcomments', 'integer')->primary();
        $meta->field('advert_idadvert', 'entity')->entity(Advert::class);
        $meta->field('comments_text', 'string');
        $meta->field('comments_date', 'string');
        $meta->field('user_iduser', 'entity')->entity(User::class);
        return $meta;
	}
}