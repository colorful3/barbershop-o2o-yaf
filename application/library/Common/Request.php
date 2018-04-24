<?php
/**
 * Request.php
 * 接收请求类
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:08
 */
class Common_Request
{

    public static $request = null;

    protected $server  = [];
    protected $header  = [];

    public function __construct()
    {
        $this->request = new Yaf_Request_Http();
    }

    public static function get( $key, $value ) {

    }

    public static function post( $key, $default = '' ) {
        if( isset($key) ) {
            self::$request->getPost( $key );
            if( isset($default) ) {
                self::$request->getPost( $key );
            }
        } else {
            self::$request->getPost();
        }
        return self::$request;
    }

    /**
     * 返回序列化的数据给客户端
     * @param $errno : 错误码
     * @param string $errmsg : 错误提示消息
     * @param array $data : 数据
     * @param string $type : 返回数据的类型，默认json
     */
    public static function response($errno, $errmsg = "", $data = [], $type = 'json')
    {
        if( $type == 'json') {
            $rep = array(
                'errno' => $errno,
                'errmsg' => $errmsg,
            );
            if( isset($data) && $data ) {
                $rep['data'] = $data;
            }
            exit( json_encode( $rep ) );
        }
    }

    /**
     * 设置或者获取当前的Header
     * @access public
     * @param string|array  $name header名称
     * @param string        $default 默认值
     * @return string
     */
    public function header($name = '', $default = null)
    {
        if (empty($this->header)) {
            $header = [];
            if (function_exists('apache_request_headers') && $result = apache_request_headers()) {
                $header = $result;
            } else {
                $server = $this->server ?: $_SERVER;
                foreach ($server as $key => $val) {
                    if (0 === strpos($key, 'HTTP_')) {
                        $key          = str_replace('_', '-', strtolower(substr($key, 5)));
                        $header[$key] = $val;
                    }
                }
                if (isset($server['CONTENT_TYPE'])) {
                    $header['content-type'] = $server['CONTENT_TYPE'];
                }
                if (isset($server['CONTENT_LENGTH'])) {
                    $header['content-length'] = $server['CONTENT_LENGTH'];
                }
            }
            $this->header = array_change_key_case($header);
        }
        if (is_array($name)) {
            return $this->header = array_merge($this->header, $name);
        }
        if ('' === $name) {
            return $this->header;
        }
        $name = str_replace('_', '-', strtolower($name));
        return isset($this->header[$name]) ? $this->header[$name] : $default;
    }

}
