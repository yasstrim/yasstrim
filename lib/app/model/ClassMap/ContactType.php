<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class ContactType {

    use Setter;
    use BaseFunctions;


    private $idcontactType;
    private $contactType_name;
    private $contactType_validator;
    public static function describe(){
        $meta = new Meta();
        $meta->table('contactType');
        $meta->field('idcontactType', 'integer')->primary();
        $meta->field('contactType_name', 'string');
        $meta->field('contactType_validator', 'enum', ['checkString','checkEmail','checkTel','validateFloat','validateInt']);
        return $meta;
	}
}