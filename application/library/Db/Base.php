<?php
/**
 * Base.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:下午1:22
 */
class Db_Base
{
    // 类实例
    private static $_instance = null;

    // 连接实例
    private static $_db = null;

    // 配置文件
    private static $config = [];

    /**
     * 1、得到配置文件
     * 2、建立PDO连接
     * Db_Base constructor.
     */
    private function __construct()
    {
        self::$config = Yaf_Registry::get('config')->resources->database->master;
        self::$_db = new PDO("mysql:host=" . self::$config['host'] . ";dbname=" . self::$config['dbname'], self::$config['username'], self::$config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);
    }

    private function __clone()
    {
    }

    /**
     * 单例模式的接口
     * @return Db_Base|null
     */
    static function getInstance()
    {
        if( is_null(self::$_instance) ) {
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
        return @self::$_db->$name($arguments[0]);
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
        list(self::$_instance, self::$config) = [null, []];
    }





}
