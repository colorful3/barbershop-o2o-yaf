<?php
/**
 * Catch.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:下午10:13
 * @desc 公共缓存类库，使用redis做缓存。
 */
class Common_Cache
{
    /**
     * redis对象
     * @var Redis
     */
    private static $_obj;

    /**
     * redis 配置文件
     * @var array
     */
    private static $_config = [];

    /**
     * 实例
     * @var null
     */
    private static $_instance = null;

    /**
     * 私有构造函数，防止外部直接实例化
     * Common_Cache constructor.
     */
    private function __construct()
    {
        // 得到redis的相关配置
        self::$_config = Yaf_Registry::get('config')->resources->database->redis;
        // 实例化php-redis
        self::$_obj = new Redis();
        self::$_obj->connect( self::$_config['host'], self::$_config['port'] );
    }

    /**
     * 私有克隆魔术方法，防止外部克隆多个对象
     */
    private function __clone()
    {
    }

    /**
     * 单例模式的接口
     * @return Common_Cache|null
     */
    static function getInstance()
    {
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
        switch ( count($arguments) ) {
            case 1:
                return self::$_obj->$name( $arguments[0] );
                break;
            case 2:
                return self::$_obj->$name( $arguments[0], $arguments[1] );
                break;
            case 3:
                return self::$_obj->$name( $arguments[0], $arguments[1], $arguments[2] );
                break;
            case 4:
                return self::$_obj->$name( $arguments[0], $arguments[1], $arguments[2], $arguments[3] );
                break;
            case 5:
                return self::$_obj->$name( $arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4] );
                break;
        }
        return 0;
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
