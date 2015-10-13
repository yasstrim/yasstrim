<?php

namespace lib\app\model\ClassMap;

use lib\core\db\ORM\BaseFunctions;
use lib\core\db\ORM\Meta;
use lib\core\db\ORM\Setter;
use lib\core\db\ORM\BasePdo;
use lib\core\db\ORM\EntityManager;

class Contact {

    use Setter;
    use BaseFunctions;


    private $idcontact;
    private $contact_subject;
    private $contact_name;
    private $contact_value;
    private $contact_properties;
    public static function describe(){
        $meta = new Meta();
        $meta->table('contact');
        $meta->field('idcontact', 'integer')->primary();
        $meta->field('contact_subject', 'integer');
        $meta->field('contact_name', 'entity')->entity(ContactType::class);
        $meta->field('contact_value', 'string');
        $meta->field('contact_properties', 'string');
        return $meta;
	}
}