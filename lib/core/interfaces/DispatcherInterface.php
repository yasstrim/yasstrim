<?php
/**
 * Created by YASSTRIM
 * Date: 23.12.14
 * Time: 17:17
 */

namespace lib\core\interfaces;
/**
 * Interface DispatcherInterface
 * @package core\interfaces
 */
interface DispatcherInterface{
    public function getController();
    public function getAction();
    public function getArgs();
}