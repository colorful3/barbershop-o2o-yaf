<?php
date_default_timezone_set("Asia/ShangHai");
define('APPLICATION_PATH', dirname(__FILE__) . "/../");

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
