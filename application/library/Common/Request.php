<?php
/**
 * Request.php
 * @desc 接收请求类
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:08
 */
class Common_Request
{
    protected static $_instance = null;

    protected $server = [];
    protected $header = array();

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * 根据请求类型获取请求参数
     * @param $key : 参数名
     * @param null $default : 默认值
     * @param null $type    : 请求类型
     * @return null|string
     */
    static function request( $key, $default = null, $type = null )
    {
        if( $type == 'get' ) {
            $result = isset($_GET[$key]) ? trim($_GET[$key]) : null;
        } else if( $type == 'post' ) {
            $result = isset( $_POST[$key] ) ? trim( $_POST[$key] ) : null;
        } else {
            $result = isset( $_REQUEST[$key] ) ? trim( $_REQUEST[$key] ) : null;
        }
        if( $default != null && $result == null ) {
            $result = $default;
        }
        return $result;
    }

    /**
     * 获取get请求参数
     * @param $key
     * @param null $default
     * @return null|string
     */
    static function getRequest( $key, $default = null )
    {
        return self::request( $key, $default, 'get' );
    }

    /**
     * 获取post请求参数
     * @param $key
     * @param null $default
     * @return null|string
     */
    static function postRequest( $key, $default = null )
    {
        return self::request( $key, $default, 'post' );
    }

    /**
     * 单利接口
     * @param array $options
     * @return null|static
     */
    public static function getInstance($options = [])
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new static($options);
        }
        return self::$_instance;
    }

    /**
     * 返回序列化的数据给客户端
     * @param $errno : 错误码
     * @param string $errmsg : 错误提示消息
     * @param array $data : 数据
     * @param string $type : 返回数据的类型，默认json
     */
    static function response($errno = 0, $errmsg = "", $data = [], $type = 'json')
    {
        if( $type == 'json') {
            $rep = array(
                'errno' => $errno,
                'errmsg' => $errmsg,
            );
            if( isset($data) && $data ) {
                $rep['data'] = $data;
            }
            // 如果应用处于调试模式，对返回的数据做日志记录
            if( Yaf_Registry::get('config')->application->debug ) {
                Log::record('[ RESPONSE ] ' . var_export( $rep, true), 'info');
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

    /**
     * 获取客户端IP地址
     * @param integer   $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean   $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    public static function ip($type = 0, $adv = true)
    {
        $type      = $type ? 1 : 0;
        static $ip = null;
        if (null !== $ip) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim(current($arr));
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];
        return $ip[$type];
    }


    /**
     * 获取上传的文件信息
     * @access public
     * @param string|array $name 名称
     * @return null|array|\\File
     */
    public function file($name = '')
    {
        if (empty($this->file)) {
            $this->file = isset($_FILES) ? $_FILES : [];
        }
        if (is_array($name)) {
            return $this->file = array_merge($this->file, $name);
        }
        $files = $this->file;
        if (!empty($files)) {
            // 处理上传文件
            $array = [];
            foreach ($files as $key => $file) {
                if (is_array($file['name'])) {
                    $item  = [];
                    $keys  = array_keys($file);
                    $count = count($file['name']);
                    for ($i = 0; $i < $count; $i++) {
                        if (empty($file['tmp_name'][$i]) || !is_file($file['tmp_name'][$i])) {
                            continue;
                        }
                        $temp['key'] = $key;
                        foreach ($keys as $_key) {
                            $temp[$_key] = $file[$_key][$i];
                        }
                        $item[] = (new Common_File($temp['tmp_name']))->setUploadInfo($temp);
                    }
                    $array[$key] = $item;
                } else {
                    if ($file instanceof Common_File) {
                        $array[$key] = $file;
                    } else {
                        if (empty($file['tmp_name']) || !is_file($file['tmp_name'])) {
                            continue;
                        }
                        $array[$key] = (new Common_File($file['tmp_name']))->setUploadInfo($file);
                    }
                }
            }
            if (strpos($name, '.')) {
                list($name, $sub) = explode('.', $name);
            }
            if ('' === $name) {
                // 获取全部文件
                return $array;
            } elseif (isset($sub) && isset($array[$name][$sub])) {
                return $array[$name][$sub];
            } elseif (isset($array[$name])) {
                return $array[$name];
            }
        }
        return;
    }

}
