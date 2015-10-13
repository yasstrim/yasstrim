<?php
/**
 * Created YASSTRIM
 * Date: 24.12.14
 * Time: 23:51
 */

namespace lib\core;


class ErrorHandler {

    public function __construct(){

    }



}



//------------------------------------
function log_error( $num, $str, $file, $line,  $context = null ){
    log_exception( new ErrorException( $str, 0, $num, $file, $line ) );
}

function log_exception( \Exception $e ){
    if ( DEBUG ){
        print "<div style='text-align: center;'>";
        print "<h2 style='color: rgb(190, 50, 50);'>Выброшено исключение:</h2>";
        print "<table style='width: 800px; display: inline-block;'>";
        print "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Type</th><td>" . get_class( $e ) . "</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Message</th><td>{$e->getMessage()}</td></tr>";
        print "<tr style='background-color:rgb(230,230,230);'><th>File</th><td>{$e->getFile()}</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Line</th><td>{$e->getLine()}</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Trace</th><td>{$e->getTraceAsString()}</td></tr>";
        print "</table></div>";
    }
    else
    {
        $message = "Type: " . get_class( $e ) . "; Message: {$e->getMessage()};
                        File: {$e->getFile()}; Line: {$e->getLine()}; Trace: {$e->getTraceAsString()}";
        file_put_contents( "log/exceptions.log", $message . PHP_EOL, FILE_APPEND );
        header( "Location: /error404/error404.php" );

    }

    exit();
}
function check_for_fatal(){
    $error = error_get_last();
    if ( $error["type"] == E_ERROR )
        log_error( $error["type"], $error["message"], $error["file"], $error["line"],  $error["trace"] );
}

register_shutdown_function( "check_for_fatal" );
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );
ini_set( "display_errors", "off" );
error_reporting( E_ALL );