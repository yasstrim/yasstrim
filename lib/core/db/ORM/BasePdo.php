<?php
/**
 * Created by PhpStorm.
 * User: yasstrim
 * Date: 27.07.15
 * Time: 14:53
 */

namespace lib\core\db\ORM;


class BasePdo {
    private $db;
    protected static $_instance = NULL;

    protected function __construct(){
        try {
            $this->db = new \PDO(cfg()->db('db.conn'), cfg()->db('db.user'), cfg()->db('db.pass'));
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET NAMES 'utf8'");
        } catch (\PDOException $e) {
            echo $e->getMessage() . ' fail = ' . $e->getFile() . ' line: ' . $e->getLine();
        }
    }

    protected function __clone(){
    }

    /**
     * возвращает синглтон данного класса
     * @return BasePdo
     */
    public static function getInstance(){
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function selectRow($table, $column, $value){
//        echo '<br>class = '.$class;
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $column = :val");
        $stmt->setFetchMode(\PDO::FETCH_OBJ);
        if($stmt->execute(array(':val' => $value))){
            return $stmt->fetch();
        }
        else{
            return false;
        }
    }

    function updateRow($table, $obj, $column){
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

    /**
     * начало транзакции
     * @return bool
     */
    function beginTrans()    {
        return $this->db->beginTransaction();
    }

    /**
     * конец транзакции
     * @return bool
     */
    function commitTrans(){
        return $this->db->commit();
    }

    /**
     * откат транзакции
     * @return bool
     */
    function rollbackTrans(){
        return $this->db->rollBack();
    }

}