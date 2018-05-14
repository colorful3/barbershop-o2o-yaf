<?php
try {
    date_default_timezone_set("Asia/ShangHai");
    define('APPLICATION_PATH', dirname(__FILE__) . "/../");
    // 定义静态资源前缀
    define('__STATIC__', '/static/');

    $application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");

    $application->bootstrap()->run();
} catch ( Exception $exception ) {
    echo json_encode( array(
        'errno' => -9999,
        'errmsg' => 'error.' . $exception->getMessage()
    ) );
}
?>
