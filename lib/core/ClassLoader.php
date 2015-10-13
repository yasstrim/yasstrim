<?

namespace lib\core;
use lib\core\exception\FileException;

spl_autoload_register(function( $class ) {
    $classFile = str_replace( '\\', DS, $class );
    $classPI = pathinfo( $classFile );
    $classPath = $classPI[ 'dirname' ] ;
//    echo BASE_DIR.DS.$classPath . DS . $classPI[ 'filename' ] . '.php<BR>';
    IF (file_exists(BASE_DIR.DS.$classPath . DS . $classPI[ 'filename' ] . '.php')){
        include_once( BASE_DIR.DS.$classPath . DS . $classPI[ 'filename' ] . '.php' );
    }
    ELSE{
        throw new FileException('Файл '.BASE_DIR.DS.$classPath . DS . $classPI[ 'filename' ] . '.php не существует');
    }
});