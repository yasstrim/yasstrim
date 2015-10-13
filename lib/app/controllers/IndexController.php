<?php

/**
 * Created by YASSTRIM
 * Date: 24.12.14
 * Time: 2:42
 */

namespace lib\app\controllers;

use lib\core\base\BaseController;
use lib\library\class_map\adverts;
use lib\library\class_map\nstree;

class IndexController extends BaseController {

    function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        $var = $this->model->test(); 
//        $this->response->block('vcontent',$var);
        $this->response->display();
    }

}
