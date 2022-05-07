<?php
class Autoloader
{
    public static function autoload($classname){
        $filename = preg_replace("(([A-Z]))","/\\1",$classname);
        if(substr($filename,0,1) != "/"){
            $filename = "/" . $filename;
        }
        $filename .= ".php";
        include_once(__DIR__ . $filename);
    }

}
?>
