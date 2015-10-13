<?php

/**
 * Created YASSTRIM
 * Date: 27.12.14
 * Time: 13:32
 */

namespace lib\core;

use lib\core\db\PdoAdapter;
use lib\core\exception\BaseException;

class Auth {

    protected $_db;
    private $_active;

    function __construct() {
        $this->_db = PdoAdapter::getInstance();
        $this->_active = $this->activeUser();
    }

    public function getActiveUser() {
        return $this->_active;
    }

    private function getUlogin() {
        $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $this->_user = json_decode($s);
    }

    public function setUserSocial() {
        $this->getUlogin();
        $obj = new \stdClass();
        $obj->user_uid = $this->_user->identity;
        $obj->user_name = $this->_user->first_name;
        $obj->user_surname = $this->_user->last_name;
        $obj->user_hash = md5($this->_user->uid . 'abrasvabra' . $_SERVER['HTTP_USER_AGENT']);
        $row = $this->_db->selectRow('user', 'user_uid', $obj->user_uid);
        if (!$row) { //если user не существует
            $id = $this->_db->insertRow('user', $obj);
            $obj->user_role = 'user'; // новый пользователь только роль user
            $this->setCookie(['id' => $id, 'hash' => $obj->user_hash]); // только id и hash
            $this->setSession('user', ['id' => $id, 'user_name' => $obj->user_name,
                'hash' => $obj->user_hash, 'user_role' => $obj->user_role]);
        } else { // если user существует
            $row->user_hash = $obj->user_hash;
//            echo 'user = ';var_dump($row);
            $this->_db->update_row('user', $row, 'iduser'); //перезаписываем hash
            $this->setCookie(['id' => $row->iduser, 'hash' => $row->user_hash]);
            $this->setSession('user', ['id' => $row->iduser, 'user_name' => $row->user_name,
                'hash' => $row->user_hash, 'user_role' => $row->user_role]);

//            var_dump($_COOKIE);
        }
    }

    public function exitUser() {
        setcookie('id', '', time() - 3600, "/");
        setcookie('hash', '', time() - 3600, "/");
        session_unset();
    }

    private function setCookie($array) {
        foreach ($array as $key => $val) {
            setcookie($key, $val, time() + (60 * 60 * 24 * 30), "/");
        }
    }

    private function setSession($name, array $user) {
        $_SESSION[$name] = $user;
    }

    public function getSession() {
        return $_SESSION;
    }

    private function activeUser() {
        if (!isset($_SESSION['user'])) {
            if ((isset($_COOKIE['hash'])) & (isset($_COOKIE['id']))) {
                $hash = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "", $_COOKIE['hash']);
                $id = filter_var($_COOKIE['id'], FILTER_SANITIZE_NUMBER_INT);
                $user = $this->_db->selectRow('user', 'iduser', $id);
                if ($hash == $user->user_hash) {
                    return $user;
                } else
                    return false;
            } else
                return false;
        }
        else {    // есть user в сессии
            if (isset($_COOKIE['hash'])) {
                if ($_SESSION['user']['hash'] == $_COOKIE['hash']) {
                    $id = filter_var($_COOKIE['id'], FILTER_SANITIZE_NUMBER_INT);
                    $user = $this->_db->selectRow('user', 'iduser', $id);
                    return $user;
                } else
                    return false;
            } else
                return false;
        }
    }

//---------------------------------------------------------------------------
}
