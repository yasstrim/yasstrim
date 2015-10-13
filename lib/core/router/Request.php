<?php
/**
 * Created by YASSTRIM
 * Date: 19.12.14
 * Time: 16:28
 */

namespace lib\core\router;
use lib\core\interfaces\RequestInterface;

class Request implements RequestInterface {

    private $_uri;
    private $_get;
    private $_post;
    private $request;

    public function __construct(){
        $this->getUri();
        $this->getPost();



    }

    public function getRequest(){
        $this->request['uri'] = $this->_uri;
        $this->request['get'] = $this->_get;
        $this->request['post'] = $this->_post;
        return $this->request;




    }

    private function getUri(){
        $uri = $_SERVER['REQUEST_URI'];
        $uri = urldecode($uri);
        $uri = parse_url($uri);
        $this->_uri = $uri['path'];
        if(isset($uri['query'])?parse_str($uri['query'],$this->_get):$this->_get = NULL);


    }


    private function getPost(){
        ($_SERVER['REQUEST_METHOD']==='POST'?$this->_post = $_POST:$this->_post = NULL);
    }

}