<?php
/**
 * Created by YASSTRIM
 * Date: 23.12.14
 * Time: 11:42
 */

namespace lib\core\router;

use lib\core\interfaces\DispatcherInterface;

class Dispatcher implements DispatcherInterface{

    private $_uri;
    private $_get;
    private $_post;
    private $_multilang;
    private $_url_type;
//    --------------------
    private $_controller;
    private $_action;
    private $_args;
    private $_locale;

    public function __construct(){
        $request = new Request();
        $request = $request->getRequest();
        $this->_uri = $request['uri'];
        $this->_get = $request['get'];
        $this->_post = $request['post'];
        $this->_multilang = cfg()->multilang();
        $this->_url_type = cfg()->url_type();
        if ($this->_uri =='/'){
            $this->_controller = cfg()->default('controller');
            $this->_action = cfg()->default('action');
        }
        else {
            $this->getPartsUri();
            $this->parseUri();
        }
//        echo $this->_controller.'<Br>'.$this->_action.'<Br>';

    }

    public function getController(){
        return $this->_controller;
    }

    public function getAction(){
        return $this->_action;
    }

    public function getArgs(){
        return $this->_args;
    }

    private function getPartsUri(){
        $this->_uri = trim($this->_uri,'/');
        $this->_uri = explode('/',$this->_uri);

    }

    private function parseUri(){
        if ($this->_multilang == 'true'){
            $this->_locale = array_shift($this->_uri);//доработать проблему ru, ru-RU : en, en-US;
        }
        else{
            $this->_locale = cfg()->locale();
        }
//        var_dump($this->_uri);

        switch ($this->_url_type){
            case 'ctr/act/args':
                $this->_controller = ucfirst(array_shift($this->_uri)).'Controller';
                $this->_action = array_shift($this->_uri).'Action';
                $this->_args = $this->_uri;
                if(!is_null($this->_get)){
                    $this->_args = array_merge($this->_args,$this->_get);
                }
                if(!is_null($this->_post)){
                    $this->_args = array_merge($this->_args,$this->_post);
                }
            break;
        }



//        var_dump($this->_locale);

    }



}