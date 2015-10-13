<?php
/**
 * Created by YASSTRIM
 * Date: 19.12.14
 * Time: 15:13
 */
namespace lib\core\interfaces;

/**
 * Interface RequestInterface
 * @package core\interfaces
 * return $request['uri'=string,'get'=array|null,'post'=object|array|null]
 */
interface RequestInterface
{
    public function getRequest(); // получает текущий запрос , GET и POST если есть

}
