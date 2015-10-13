<?php
/**
 * Created by YASSTRIM
 * Date: 24.12.14
 * Time: 0:09
 */

namespace lib\core\router;


use lib\core\exception\BaseException;
use lib\core\exception\FileException;
use lib\app\controllers;
use lib\core\exception\RouterException;

class Router {

    private $_dispatcher;
    private $_controller;
    private $_action;
    private $_args;

    public function __construct(){
        $this->_dispatcher = new Dispatcher();
        $this->_controller = '\lib\app\controllers\\'.$this->_dispatcher->getController();
        $this->_action = $this->_dispatcher->getAction();
        $this->_args = $this->_dispatcher->getArgs();
        $this->run();

    }

    private function run(){
        try {
//            $refCtr = new \ReflectionClass($this->_controller);
//            $hasMethod = $refCtr->hasMethod($this->_action);
//            $method = $hasMethod ? $this->_action : 'defaultAction';
            $ctr = new $this->_controller;
            $action = $this->_action;
            $ctr->$action($this->_args);


        }
        catch (RouterException $e){
            echo "Error (File: ".$e->getFile().", line ".
                $e->getLine()."): ".$e->getMessage();

        }


    }

}