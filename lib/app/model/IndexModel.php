<?php
/**
 * Created by YASSTRIM
 * Date: 25.12.14
 * Time: 14:50
 */

namespace lib\app\model;


use lib\app\model\ClassMap\Advert;
use lib\app\model\ClassMap\User;
use lib\core\db\PdoAdapter;
use lib\core\db\ORM\Creater;

class IndexModel  {
    /**
     * @var $db singleton
     */
    private $db;
    
    public function __construct(){
//        $this->db = PdoAdapter::getInstance();

    }

    public function test(){
        $advert = new Advert();
        var_dump($advert->findById(3066));
//        $advert->findById(3066);
//        var_dump($advert);
        echo '<br><br>';
        $advert->advert_title = 'Пентхаус возле подсобки';
//        var_dump($advert->user_iduser);
        $advert->user_iduser->user_name = 'Вася Попкин';
        $advert->user_iduser->iduser = 5;
        $advert->idadvert = 3066;
//        var_dump($advert);
        echo '<br><br>';
//        return $advert;
        $advert->save();
//        echo '<br>'."\n\n";
//        var_dump($advert);
//        $user = new User();;
//        var_dump($user->findById(203));

//        $creater = new Creater('putevoditel');
//        $creater->createScheme();
//        $advert = new Advert();
//        $advert->findById(3066);
//        $sql = 'SHOW DATABASES'; // показать все базы
//        $sql = 'SHOW TABLES'; // показать все таблицы
//        $sql = 'DESCRIBE value_varchar'; // характеристики столбцов
//        $sql = 'SHOW INDEX FROM user'; // индексы
//        $sql = 'SHOW CREATE TABLE user';
//        $sql = "SELECT *
//                  FROM information_schema.KEY_COLUMN_USAGE
//                  WHERE TABLE_SCHEMA ='putevoditel' AND TABLE_NAME ='advert' AND
//                    CONSTRAINT_NAME <>'PRIMARY' AND REFERENCED_TABLE_NAME is not null"; // связи
//        $sql = "SELECT REFERENCED_TABLE_NAME
//                  FROM information_schema.KEY_COLUMN_USAGE
//                  WHERE TABLE_SCHEMA ='putevoditel' AND TABLE_NAME ='advert' AND
//                    REFERENCED_TABLE_NAME is not null AND COLUMN_NAME = 'advert_status'";
//        $sql = "SELECT *
//                  FROM information_schema.KEY_COLUMN_USAGE
//                  WHERE TABLE_SCHEMA ='putevoditel' AND TABLE_NAME ='user' ";
//        $sql = 'SHOW CREATE TABLE advert';
    }

    
    
}