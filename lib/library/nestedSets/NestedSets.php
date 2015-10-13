<?php

/**
 * Класс для управления деревом Nested Set
 * @package nestedSets
 * @author YASSTRIM
 * @copyright 07.04.14
 * наследует базовый класс для всех модулей
 * @see baselibrary::$property
 *
 */
namespace library\nestedSets;


use lib\core\base\BaseLibrary;

class NestedSets extends BaseLibrary {

    private $_table;
    private $_columns;

    /**
     * @param $table имя таблицы
     * @param array $columns названия служебных полей
     */
    public function __construct($table,array $columns){
        $this->_table = $table;
        $this->_columns = $columns;
        parent::__construct();
    }

    /**
     * создание таблицы для дерева только основные поля
     */
    public function createTable(){
        $sql = "CREATE TABLE $this->_table (
                    $this->_columns['id'] INT(10) NOT NULL AUTO_INCREMENT,name VARCHAR(150) NOT NULL,
                    $this->_columns['left_key'] INT(10) NOT NULL DEFAULT 0,
                    $this->_columns['right_key'] INT(10) NOT NULL DEFAULT 0,
                    $this->_columns['level'] INT(10) NOT NULL DEFAULT 0,PRIMARY KEY ($this->_columns['id']
                    ),
                    INDEX $this->_columns['left_key'] ($this->_columns['left_key'], $this->_columns['right_key'], $this->_columns['level']))";
        $this->_db->update_sql($sql);
    }
    /**
     * Функция получает все дерево
     * @return array[SomeObject] строк таблицы
     */
    public function getTree(){
        $sql = "SELECT * FROM $this->_table ORDER BY ".$this->_columns['left_key'];
        return $this->_db->select_sql($sql);

    }

    /**
     * Функция выборки подчиненных узлов
     * @param int $id идентификатор узла
     * @return array[SomeObject]|false строк таблицы
     * @throws nestedSetsException
     */
    public function getAllChild($id){
        $keys = $this->selectKeys($id);
        if (!$keys){
            throw new nestedSetsException("узла с id = $id не существует");
        }
        $lk = $keys->{$this->_columns['left_key']};
        $rk = $keys->{$this->_columns['right_key']};
        $sql = "SELECT * FROM $this->_table WHERE left_key >= $lk AND right_key <= $rk ORDER BY ".$this->_columns['left_key'];
        return $this->_db->select_sql($sql);
    }

    /**
     * Функция выборки родительской ветки
     * @param int $id  идентификатор узла
     * @return array[SomeObject]|false строк таблицы
     * @throws nestedSetsException
     */
     public function getAllParents($id){
         $keys = $this->selectKeys($id);
         if (!$keys){
             throw new nestedSetsException("узла с id = $id не существует");
         }
         $lk = $keys->{$this->_columns['left_key']};
         $rk = $keys->{$this->_columns['right_key']};
         $sql = "SELECT * FROM $this->_table WHERE left_key <= $lk AND right_key >= $rk ORDER BY ".$this->_columns['left_key'];
         return $this->_db->select_sql($sql);
    }

    /**
     * Функция выборки ветки где участвует данный узел
     * @param $id integer идентификатор узла
     * @return array[SomeObject]|false строк таблицы
     * @throws nestedSetsException
     */

    public function getBranch($id){
        $keys = $this->selectKeys($id);
        if (!$keys){
            throw new nestedSetsException("узла с id = $id не существует");
        }
        $lk = $keys->{$this->_columns['left_key']};
        $rk = $keys->{$this->_columns['right_key']};
        $sql = "SELECT * FROM $this->_table WHERE right_key > $lk AND left_key < $rk ORDER BY ".$this->_columns['left_key'];
        return $this->_db->select_sql($sql);
    }

    /**
     * Функция выборки родительского узла
     * @param $id integer идентификатор узла
     * @return object|NULL
     * @throws nestedSetsException
     */
    public function getParentNode($id){
        $keys = $this->selectKeys($id);
        if (!$keys){
            throw new nestedSetsException("узла с id = $id не существует");
        }
        $lk = $keys->{$this->_columns['left_key']};
        $rk = $keys->{$this->_columns['right_key']};
        $level = $keys->{$this->_columns['level']};
        if($level!=0){
            $sql = "SELECT * FROM $this->_table
                      WHERE ".$this->_columns['left_key']." <= $lk
                        AND ".$this->_columns['right_key']." >= $rk
                        AND ".$this->_columns['level']." = $level-1  ORDER BY ".$this->_columns['left_key'];
            $res = $this->_db->select_sql($sql);
            return $res[0];
        }
        else{
            return NULL;
        }
    }

    /**
     * Функция проверяет целостность таблицы
     * @return bool если не пройден, то SomeObject[] c id строк с ошибками
     */
    private function testNsets(){
        $sql = "SELECT t1.id$this->_table, COUNT(t1.id$this->_table) AS rep, MAX(t3.".$this->_columns['right_key'].") AS max_right
                    FROM $this->_table AS t1, $this->_table AS t2, $this->_table AS t3
                    WHERE t1.".$this->_columns['left_key']." <> t2.".$this->_columns['left_key']."
                        AND t1.".$this->_columns['left_key']." <> t2.".$this->_columns['right_key']."
                        AND t1.".$this->_columns['right_key']." <> t2.".$this->_columns['left_key']."
                        AND t1.".$this->_columns['right_key']." <> t2.".$this->_columns['right_key']."
                    GROUP BY t1.".$this->_columns['id']." HAVING max_right <> SQRT(4 * rep + 1) + 1";
        $res = $this->_db->select_sql($sql);
        if (empty($res)){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Функция создания узла (добавляет в конец дочернего списка)
     * @param $id идентификатор родительского узла, либо -1 если новая ветка
     * @param \stdClass $obj дополнительные столбцы $obj->имя=значение
     * @return bool| lastId
     */
    public function createNode($id,\stdClass $obj){
        $str = "";
        foreach($obj as $item=>$value){
            $str.=", `$item`='$value'";
        }
        if($id==-1){
            $sql = "SELECT MAX(".$this->_columns['right_key'].") as rk FROM $this->_table";
            $rk = $this->_db->select_sql($sql);
            $rk = $rk[0]->rk;
            $sql = "INSERT INTO $this->_table SET ".$this->_columns['left_key']." = $rk+1,
                                                  ".$this->_columns['right_key']." = $rk + 2,
                                                  ".$this->_columns['level']." = 0 $str";
            if($this->_db->update_sql($sql)==1and!$this->testNsets()){
                return true;
            }
            else return false;
        }
        else{
            $keys = $this->selectKeys($id);
            $rk = $keys->{$this->_columns['right_key']};
            $level = $keys->{$this->_columns['level']};
            if($this->_db->begin_trans()){
                $sql = "UPDATE $this->_table
                          SET   ".$this->_columns['right_key']." = ".$this->_columns['right_key']." + 2,
                                ".$this->_columns['left_key']." =
                                IF(".$this->_columns['left_key']." > $rk, ".$this->_columns['left_key']." + 2, ".$this->_columns['left_key'].")
                          WHERE ".$this->_columns['right_key']." >= $rk";
                $this->_db->update_sql($sql);
                $sql = "INSERT INTO $this->_table
                          SET ".$this->_columns['left_key']." = $rk,
                              ".$this->_columns['right_key']." = $rk+1,
                              ".$this->_columns['level']." = $level+1 $str";
                $this->_db->update_sql($sql);
            }
            $lastId = $this->_db->lastInsertId();
            if ($this->testNsets()){
                $this->_db->rollback_trans();
                return false;
            }
            else {
                $this->_db->commit_trans();
                return true;
            }
        }
    }

    /**
     * Функция удаления узла
     * @param $id integer идентификатор удаляемого узла
     * @return bool
     */

    public function deleteNode($id){
        $keys = $this->selectKeys($id);
        $lk = $keys->{$this->_columns['left_key']};
        $rk = $keys->{$this->_columns['right_key']};
        if($this->_db->begin_trans()){
            $sql = "DELETE FROM $this->_table
                      WHERE ".$this->_columns['left_key']." >= $lk AND ".$this->_columns['right_key']." <= $rk";
            $this->_db->update_sql($sql);
            $sql = "UPDATE $this->_table
                      SET ".$this->_columns['left_key']." =
                        IF(".$this->_columns['left_key']." > $lk,
                            ".$this->_columns['left_key']." - ($rk-$lk+1), ".$this->_columns['left_key']."),
                        ".$this->_columns['right_key']." = ".$this->_columns['right_key']." - ($rk-$lk+1)
                      WHERE ".$this->_columns['right_key']." > $rk";
            $this->_db->update_sql($sql);
        }
        if ($this->testNsets()){
            $this->_db->rollback_trans();
            return false;
        }
        else {
            $this->_db->commit_trans();
            return true;
        }
    }



    /**
     * @param int $id идентификатор текущего узла
     * @param int $pid если ноль, то перенос на первое место в группе
     * @param bool $inner true перенос внутрь $pid
     * @return bool
     * @throws nestedSetsException
     */
    function moveNode($id, $pid=0,$inner){
        $keys = $this->selectKeys($id); //ключи перемещаемого узла
        if (!$keys){
            throw new nestedSetsException("узла с id = $id не существует");
        }
        $lk = $keys->{$this->_columns['left_key']};
        $rk = $keys->{$this->_columns['right_key']};
        $level = $keys->{$this->_columns['level']};
        if($pid==0){ //перенос на первое место в группе
            $plevel = $level;
            $pnode = $this->getParentNode($id);
            if(!isset($pnode)){ //если не существует родительский узел
                $rk_near = 0;
            }
            else{
                $rk_near = $pnode->left_key;
            }
        }
        else{ //pid isset
            if($inner){
                $right_key = $this->_columns['right_key'].'-1';
                $level--;
            }
            else{
                $right_key = $this->_columns['right_key'];
            }

            $keys = $this->selectKeys($pid);
            $plevel = $keys->{$this->_columns['level']};
            $sql = "SELECT ($right_key) AS ".$this->_columns['right_key']."
                        FROM $this->_table WHERE ".$this->_columns['id']." = $pid";
            $rk_near = $this->_db->select_sql($sql);
            $rk_near = $rk_near[0]->{$this->_columns['right_key']};
        }
        $skew_level = $plevel - $level;
        $skew_tree = $rk - $lk + 1;
        $this->_db->update_sql($sql);
        $this->_db->begin_trans();
        if($rk_near <$rk){
            $skew_edit = $rk_near - $lk + 1;
            $sql = "UPDATE $this->_table
                        SET ".$this->_columns['right_key']." = IF(".$this->_columns['left_key']." >= $lk, ".$this->_columns['right_key']." + $skew_edit,
                        IF(".$this->_columns['right_key']." < $lk, ".$this->_columns['right_key']." + $skew_tree, ".$this->_columns['right_key'].")),
                        ".$this->_columns['level']." = IF(".$this->_columns['left_key']." >= $lk, ".$this->_columns['level']." + $skew_level, ".$this->_columns['level']."),
                        ".$this->_columns['left_key']." = IF(".$this->_columns['left_key']." >= $lk, ".$this->_columns['left_key']." + $skew_edit,
                        IF(".$this->_columns['left_key']." > $rk_near, ".$this->_columns['left_key']." + $skew_tree, ".$this->_columns['left_key']."))
                        WHERE ".$this->_columns['right_key']." > $rk_near AND ".$this->_columns['left_key']." < $rk";
            $this->_db->update_sql($sql);
        }
        else{
            $skew_edit = $rk_near - $lk + 1 - $skew_tree;
            $sql = "UPDATE $this->_table SET ".$this->_columns['left_key']." = IF(".$this->_columns['right_key']." <= $rk, ".$this->_columns['left_key']." + $skew_edit,
                        IF(".$this->_columns['left_key']." > $rk, ".$this->_columns['left_key']." - $skew_tree, ".$this->_columns['left_key'].")),
                        ".$this->_columns['level']." = IF(".$this->_columns['right_key']." <= $rk, ".$this->_columns['level']." + $skew_level, ".$this->_columns['level']."),
                        ".$this->_columns['right_key']." = IF(".$this->_columns['right_key']." <= $rk, ".$this->_columns['right_key']." + $skew_edit,
                        IF(".$this->_columns['right_key']." <= $rk_near, ".$this->_columns['right_key']." - $skew_tree, ".$this->_columns['right_key']."))
                        WHERE ".$this->_columns['right_key']." > $lk AND ".$this->_columns['level']." <= $rk_near";
            $this->_db->update_sql($sql);
        }
        if ($this->testNsets()){
             $t = $this->_db->rollback_trans();
            return false;
        }
        else {
            $this->_db->commit_trans();
            return true;
        }
    }

    /**
     * метод поиска ключей по id
     * @param $id
     * @return object stdClass
     * @throws nestedSetsException
     */

    private function selectKeys($id){
        if (!is_int($id)){
            $type = gettype($id);
            throw new nestedSetsException("id текущего узла тип : $type, а должен быть integer");
        }
        $sql = "SELECT ".$this->_columns['left_key'].",".
                        $this->_columns['right_key'].",".
                        $this->_columns['level'].
                " FROM $this->_table WHERE id$this->_table = $id";
        $row = $this->_db->select_sql($sql);
        if (!$row){
            return false;
        }
        else{
            return $row[0];
        }
    }


}