<?php

/**
 * Created by YASSTRIM
 * Date: 25.12.14
 * Time: 14:33
 */

namespace lib\core\router;

use lib\core\exception\FileException;

class Response {

    protected $_template;
    protected $_tname;
    protected $_data = array();
    private $content;

    public function __construct($template) {
        if (file_exists(BASE_DIR . '/templates/' . $template . '/t_index_main.php')) {
            $this->_template = BASE_DIR . '/templates/' . $template . '/t_index_main.php';
            $this->_tname = $template;
        } else {
            throw new FileException("основной файл шаблона $template/t_index_main.php отсутствует");
        }
    }

    public function __set($key, $value) {
        $this->_data[$key] = $value;
    }

    public function blockToContent($template_block, $data = NULL) {
        if (file_exists(BASE_DIR . '/lib/app/design/templates/' . $this->_tname . '/' . $template_block . '.php')) {
            if ($data !== NULL)
                ob_start();
            require BASE_DIR . '/lib/app/design/templates/' . $this->_tname . '/' . $template_block . '.php';
            $out = ob_get_contents();
            ob_end_clean();
            $this->content.=$out;
        }
        else {
            return 'File ' . $template_block . ' not exists.';
        }
    }

    public function block($template_block, $data = NULL) {
        if (file_exists(BASE_DIR . '/templates/' . $this->_tname . '/' . $template_block . '.php')) {
//            if ($data !== NULL)
            ob_start();
            require BASE_DIR . '/templates/' . $this->_tname . '/' . $template_block . '.php';
            $out = ob_get_contents();
            ob_end_clean();
            $this->content.=$out;
        } else {
            return 'File ' . $template_block . ' not exists.';
        }
    }

    public function getBlock($template_block, $data = NULL) {
        if (file_exists(BASE_DIR . '/templates/' . $this->_tname . '/' . $template_block . '.php')) {
            if ($data !== NULL)
                ob_start();
            require BASE_DIR . '/templates/' . $this->_tname . '/' . $template_block . '.php';
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
        }
        else {
            return 'File ' . $template_block . ' not exists.';
        }
    }

    public function display() {
        extract($this->_data);
        $content = $this->content;
        require ($this->_template);
    }

}
