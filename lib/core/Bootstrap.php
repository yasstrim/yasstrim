<?php
/**
 * Created by YASSTRIM
 * Date: 06.12.14
 * Time: 15:37
 */
session_start();
require_once(BASE_DIR . '/lib/core/ClassLoader.php');
function cfg(){  // подключаем файл конфигурации /config/BaseConfig.json
    RETURN lib\core\config\BaseConfig::obj();
}
$locale = cfg()->locale();
putenv('LANG='.$locale); // Задаем текущий язык проекта
setlocale(LC_ALL, 'ru_RU.utf8'); // Задаем текущую локаль (кодировку)
bindtextdomain (cfg()->domain(), "./locale"); // Задаем каталог домена, где содержатся переводы
textdomain (cfg()->domain()); // Выбираем домен для работы
bind_textdomain_codeset(cfg()->domain(), 'UTF-8'); // принудительно указываем кодировку

$router = new lib\core\router\Router();
//$disp = new \core\Dispatcher();
//var_dump($req->getRequest());
//
//echo _('привет');
//echo _('fff');
//echo _(' main');
//echo _(' item1');
//echo _(' item2');
//$db = cfg()->db();
//var_dump( $db);
//phpinfo();

