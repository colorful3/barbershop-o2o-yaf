<?php
/**
 * Abstract.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:04
 */
class AbstractController extends Yaf_Controller_Abstract
{

    // 存储商家用户信息的成员变量
    protected $bis_user = [];

    protected $headers = [];

   public function init()
    {
        Yaf_Dispatcher::getInstance()->disableView();
        // $this->testAes();
        // $this->testAes2();
        $this->checkRequestAuth();  // 上线开启 signature签名算法
    }

    public function testAes()
    {
        $data = [
            'app_name' => 'barbershop',
            'version' => '1.0',
            'time' => Common_Time::getTimeStamp()
        ];
        // cvSOhzgiflkaB1lAnLXkpKEmuCKa70BAOa/rHNYqek1cWPetrQJeosnxk2/Ld27fUfFTMHjgsqQDsqhZda25Rg==
        Common_IAuth::setSign($data);
    }

    public function testAes2()
    {
        $request = new Common_Request();
        $headers = $request->header();
        Common_IAuth::checkSignPass($headers);
    }


    /**
     * 验证请求是否合法
     */
    public function checkRequestAuth()
    {
        // 获取header
        $request = new Common_Request();
        $headers = $request->header();

        // 基础参数校验
        if( empty($headers['sign']) ) {
            Common_Request::response(-400, 'sign参数未传递');
            // throw new ApiException('sign参数未传递', 400);
        }
        // 签名算法
        if( !Common_IAuth::checkSignPass($headers) ) {
            // throw new ApiException('授权码sign验签失败', 400);
        }

        /*
        // sign唯一性  1、文件缓存 2、mysql 3、redis
        Common_Cache::getInstance()->set( $headers['sign'], 1, Yaf_Registry::get('config')->time->sign_cache_time );
        // 把sign存入redis，并且设置有效时间
        */

        $this->headers = $headers;
    }

}
