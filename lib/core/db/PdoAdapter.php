<?php
/**
 * Created by YASSTRIM
. * Date: 25.12.14
 * Time: 23:27
 */

namespace lib\core\db;


class PdoAdapter
{


    private $db;
    protected static $_instance = NULL;

    protected function __construct()
    {
        try {
            $this->db = new \PDO(cfg()->db('db.conn'), cfg()->db('db.user'), cfg()->db('db.pass'));
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET NAMES 'utf8'");
        } catch (\PDOException $e) {
            echo $e->getMessage() . ' fail = ' . $e->getFile() . ' line: ' . $e->getLine();
        }
    }

    protected function __clone()
    {

    }

    /**
     * возвращает синглтон данного класса
     * @return PdoAdapter
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }



    /**
     * Возврат массива объектов
     * $param string $table
     * $param string $column,... поля таблицы
     * @return array|bool|\PDOStatement
     */
    function select_all()
    {
        if (func_num_args() > 1) {
            $arr = func_get_args();
            $table = array_shift($arr);
            $arr = implode(',', $arr);
            $sql = 'SELECT ' . $arr . ' FROM ' . $table;
        } else {
            $table = func_get_arg(0);
            $sql = 'SELECT * FROM ' . $table;
        }

        $res = $this->db->query($sql);
        if ($res) {
            $res = $res->fetchAll(\PDO::FETCH_OBJ);
            return $res;
        } else {
            return false;
        }
    }

    /**
     * @param string $sql
     * @return Array объектов - строк таблицы БД
     */
    public function selectSql($sql)
    {
        $res = $this->db->query($sql);
        if ($res) {
            $res = $res->fetchAll(\PDO::FETCH_OBJ);
            return $res;
        } else {
            return false;
        }
    }

    /**
     * @param $table
     * @param $column
     * @param $value
     * @return object
     */
    function selectRow($table, $column, $value){
//        echo "SELECT * FROM $table WHERE $column = $value";
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $column = :val");
        $stmt->execute(array(':val' => $value));
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    function select_rows($table, $column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $column = :val");
        foreach ($value as $item)
            $stmt->execute(array(':val' => $item));
        $st = $stmt->fetch(\PDO::FETCH_OBJ);
        return $st;
    }

    public function selectRowObj($table, $obj)
    {
        $obj = (array)$obj;
        $key = array_keys($obj);
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $key[0] = :val1 AND $key[1] = :val2");
        if ($stmt->execute(array(':val1' => $obj[$key[0]], ':val2' => $obj[$key[1]]))) {
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } else
            return FALSE;
    }

    function insertRow($table, $obj)
    {
        $obj = (array)$obj;
        $columns = array_keys($obj);
        $columns_s = implode(',', $columns);
        foreach ($obj as $field => $v) {
            $ins[] = ':' . $field;
        }
        $ins = implode(',', $ins);
//        echo "INSERT INTO $table ($columns_s) VALUES ($ins) ";
        $stmt = $this->db->prepare("INSERT INTO $table ($columns_s) VALUES ($ins) ");
        foreach ($obj as $f => $v) {
            $stmt->bindValue(':' . $f, $v);
        }
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return FALSE;
        }
    }

    function insert_rows($table, $object)
    {
        var_dump($object);
        $obj = (array)$object[0];
        $columns = array_keys($obj);
        $columns_s = implode(',', $columns);
        foreach ($obj as $field => $v) {
            $ins[] = ':' . $field;
        }
        $ins = implode(',', $ins);
        $stmt = $this->db->prepare("INSERT INTO $table ($columns_s) VALUES ($ins) ");
        $t = array();

        FOREACH ($object AS $key) {
            foreach ($key AS $f => $v) {

                $t[':' . $f] = $v;
            }
//            var_dump($t);
            $stmt->execute($t);
        }
    }

    function insert_rows_upd($table, $object)
    {
        var_dump($object);
        $obj = (array)$object;
        $columns = array_keys($obj);
        $columns_s = implode(',', $columns);
        foreach ($obj as $field => $v) {
            $ins[] = ':' . $field;
        }
        $ins = implode(',', $ins);
        $stmt = $this->db->prepare("INSERT INTO $table ($columns_s) VALUES ($ins) ");
        $t = array();

        FOREACH ($object AS $key) {
            foreach ($key AS $f => $v) {

                $t[':' . $f] = $v;
            }
//            var_dump($t);
            $stmt->execute($t);
        }
    }

    function update_sql($sql)
    {
        return $this->db->exec($sql);
    }

    function update_row($table, $obj, $column)
    {
        $obj = (array)$obj;
        $id = $obj[$column];
        unset($obj[$column]);
        foreach ($obj as $field => $v) {
            $ins[] = $field . ' = :' . $field;
        }
        $ins = implode(',', $ins);
        $stmt = $this->db->prepare("UPDATE $table SET $ins WHERE $column = $id");

        foreach ($obj as $f => $v) {
            $stmt->bindValue(':' . $f, $v);
        }
        if ($stmt->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_rows($table, $object, $column)
    {
        $obj = (array)$object[0];
        unset($obj[$column]);
        foreach ($obj as $field => $value) {
            $ins[] = $field . ' = :' . $field;
        }
        $ins = implode(',', $ins);
        $stmt = $this->db->prepare("UPDATE $table SET $ins WHERE $column = :idgoods");
        $t = array();

        FOREACH ($object AS $key) {
            foreach ($key AS $f => $v) {

                $t[':' . $f] = $v;
            }
            $stmt->execute($t);
        }
    }

    function delete_row($table, $column, $id)
    {
        return $this->db->exec("DELETE FROM $table WHERE $column = $id");
    }
}
