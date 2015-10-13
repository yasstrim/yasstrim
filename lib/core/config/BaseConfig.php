<?php
/**
 * Created by YASSTRIM
 * Date: 08.12.14
 * Time: 12:08
 */

namespace lib\core\config;
/**
 * Class BaseConfig
 * @package core\config
 */
class BaseConfig{

    private $_data; // хранит в виде массива BaseConfig.json
    private static $once = NULL; // хранит объект класса BaseConfig
    private static $file = 'BaseConfig.json'; // имя файла
    private $get_arr = NULL; // индексный массив с именами ключей
/**
* @return BaseConfig|null
 * синглтон получает содержимое файла конфигурации
 */
    static function obj(){
        if(is_null(self::$once)):
            self::$once = new self();
            $file = __DIR__.DS .self::$file;
            $json = is_file($file) ? file_get_contents($file) : NULL;
            self::$once->_data = json_decode($json, TRUE);
        endif;
        RETURN self::$once;
    }
/**
* @param $name
 * @return BaseConfig|null
 * перегрузка
 */
    public function __get($name) {
        if($name === 'data') RETURN $this->_data;
        $this->get_arr[] = $name;
        RETURN self::obj();
    }

    public function __call($name, $arg) {
        if(count($arg) > 1) RETURN NULL;
        if( property_exists($this, $name)  ){
            if(count($arg) !== 1) RETURN NULL;
            $this->$name = $arg[0];
            RETURN self::obj();
        }else{
            $this->get_arr[] = $name;
            $result = $this->_data;
            foreach ($this->get_arr as $name):
                if( !is_array($result) ) RETURN NULL;
                $result = $result[$name];
            endforeach;
            $this->get_arr = NULL;
            RETURN isset($arg[0]) && is_array($result) ?  $result[$arg[0]] : $result;
        }
    }

    public function __destruct() { $this->_data = NULL; }
}