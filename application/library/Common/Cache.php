<?php
/**
 * Catch.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:下午10:13
 */
class Common_Cache {

    private static $_link;
    private static $_config = [];
    private static $_instance = null;

    private function __construct()
    {
        self::$_config = Yaf_Registry::get('config')->resources->database->redis;

        self::$_link = new Redis( self::$_config['host'], self::$_config['port'] );
    }

    private function __clone()
    {
    }

    /**
     * 单例模式的接口
     * @return Common_Cache|null
     */
    static function getInstance() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 魔术方法，方法重载
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return self::$_link->$name($arguments[0]);
    }

    /**
     * 反序列化魔术方法
     */
    public function __wakeup()
    {
        self::$_instance = $this;
    }

    /**
     * 析构函数
     * @description 销毁实例
     */
    public function __destruct()
    {
        list(self::$_instance, self::$_config) = [null, []];
    }

}
