<?php

/**
 * Created by YASSTRIM
 * Date: 25.12.14
 * Time: 12:46
 */

namespace lib\core\base;

use lib\core\Auth;
use lib\core\exception\FileException;
use lib\core\exception\MethodException;
use lib\core\router\Response;

abstract class BaseController {

    protected $model;
    protected $auth;
    protected $response;
    protected $activeUser;
    private $_modelName;

    function __construct() {
        $this->getModelName();
        if (class_exists('lib\core\Auth')) {
            $this->auth = new Auth();
            $this->activeUser = $this->auth->getActiveUser();
        } else {
            throw new FileException("класс авторизации не подключен");
        }
        if (class_exists($this->_modelName)) {
            $this->model = new $this->_modelName;
        } else {
            throw new FileException("контроллер : " . get_class($this) . "не может подключить модель : " . $this->_modelName);
        }
        if (class_exists('\lib\core\router\Response')) {
            $this->response = new Response('index');

        } else {
            throw new FileException("контроллер : " . get_class($this) . "не может подключить response ");
        }
    }

    abstract function indexAction();

    public function __call($method, $args = null) {
        throw new MethodException('Метод : ' . $method . ' контроллера ' . get_class($this) . ' не существует');
    }

    private function getModelName() {
        $this->_modelName = str_replace(['controllers', 'Controller'], ['model', 'Model'], get_class($this));
    }

    function factoryAction($param) {
        if (isset($param['module'])and isset($param['action'])) {
            $class = 'lib\\library\\library\\' . $param['module'];
            $func = $param['action'] . '_' . $param['module'];
            $reflection = new \ReflectionMethod($class, $func);
            if (!empty($param['table'])) {
                $reflection->invoke(new $class($param['table']), $param);
            } else {
                $reflection->invoke(new $class(), $param);
            }
        }
    }

}
