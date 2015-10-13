<?php
/**
 * Created by YASSTRIM
 * Date: 02.04.15
 * Time: 10:39
 */

namespace lib\core\db\ORM;


use lib\core\db\PdoAdapter;

class Creater {

    private $dbname;
    private $db;
    private $path;
    private $pathTo;
    private $pathToClassMap;
    private $cm = "<?php\r\n\n    namespace lib\\app\\model\\ClassMap;\r\n\n    class ";
    public function __construct($dbname){
        $this->path = BASE_DIR.DS.'lib'.DS.'core'.DS.'db'.DS.'ORM'.DS;
        $this->pathToClassMap = BASE_DIR.DS.'lib'.DS.'app'.DS.'model'.DS.'ClassMap'.DS;
        $this->dbname = $dbname;
        $this->db = PdoAdapter::getInstance();
    }

    public function createScheme(){
        $sql = 'SHOW TABLES';
        $res = $this->db->selectSql($sql);
        foreach ($res as $key=>$val){
            $table = $val->{'Tables_in_'.$this->dbname};
            $sql = 'DESCRIBE '.$table;
            $res = $this->db->selectSql($sql);
            $t = file_get_contents($this->path.'TemplateScheme.php');
//            $table = ucfirst($table);
            $t = str_replace('TemplateScheme',ucfirst($table),$t);
            $t = substr($t,0,-2);
            $meta = '        $meta->table('."'".$table."'".');'."\r\n";
            foreach($res as $obj){
                $t.= '    private $'.$obj->Field.";\r\n";
                $meta.= '        $meta->field(\''.$obj->Field.'\', '.$this->type($obj).')'.$this->key($obj,$table).";\r\n";
            }
            $t.= '    public static function describe(){'."\r\n";
            $t.= '        $meta = new Meta();'."\r\n";
            $t.= $meta;
            $t.= '        return $meta;'."\r\n\t}\r\n}";
            file_put_contents($this->pathToClassMap.ucfirst($table).'.php',$t);

        }
    }


    private function key($obj,$table){
        switch($obj->Key){
            case 'PRI': return '->primary()';break;
            case 'MUL':
                $sql = "SELECT REFERENCED_TABLE_NAME
                        FROM information_schema.KEY_COLUMN_USAGE
                        WHERE TABLE_SCHEMA = '$this->dbname'
                              AND TABLE_NAME = '$table'
                              AND REFERENCED_TABLE_NAME is not null
                              AND CONSTRAINT_NAME <>'PRIMARY'
                              AND COLUMN_NAME = '$obj->Field'";
                $res = $this->db->selectSql($sql);
                if(empty($res))break;
                $class = ucfirst($res[0]->REFERENCED_TABLE_NAME);
                return '->entity('.$class.'::class)';break;
            case 'UNI': return '->unique()';break;
            default: return '';break;
        }
    }

    private function type($obj){
//        var_dump($obj);
        if ($obj->Key==='MUL'){
            return "'entity'";
        }
        else{
            $type = str_replace('(', ' (', $obj->Type);
            $type = explode(' ', $type, 2);
            switch ($type[0]) {
                case 'enum' :
                    $type[1] = strtr($type[1], ['(' => "[", ')' => "]"]);
                    return "'enum', " . $type[1];
                    break;
                case 'int' :
                    return "'integer'";
                    break;
                default:
                    return "'string'";
                    break;
            }
        }

    }



}