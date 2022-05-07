<?php

ini_set("log_errors", 1);
ini_set("error_log", "error-log.log");
ini_set('display_startup_errors', 0);
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once(__DIR__."/config.inc.php");
require_once(__DIR__."/Autoloader.php");

spl_autoload_register(array('Autoloader','autoload'));

$application = new Application();
$application->run();

?>
