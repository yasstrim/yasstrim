<?
error_reporting(E_ALL);
ini_set('display_errors', 1); // включает показ ошибок

header('Content-Type: text/html; charset=utf-8'); //установка кодировки
header('X-Powered-By: YASSTRIM'); // отправка заголовка
define('BASE_DIR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
require_once(BASE_DIR . '/lib/core/Bootstrap.php'); // запуск основного загрузчика
?>
