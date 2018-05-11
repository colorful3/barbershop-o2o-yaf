<?php
/**
 * Abstract.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:04
 * @desc 1、接口项目不渲染模板  2、验证sign签名
 */
class AbstractController extends Yaf_Controller_Abstract
{

    // 存储商家用户信息的成员变量
    protected $bis_user = [];

    protected $headers = [];

   public function init()
    {
        // 1、关闭模板渲染
        Yaf_Dispatcher::getInstance()->disableView();

        // 2、验签算法
        $this->checkRequestAuth();  // 上线开启 signature签名算法

        if( Yaf_Registry::get('config')->application->debug ) {
            Log::record('[ HEADER ] ' . var_export( Common_Request::getInstance()->header(), true), 'info');
            Log::record('[ PARAM ] ' . var_export( $_REQUEST , true), 'info');
        }

        // $this->testAes();
        // $this->testAes2();
    }

    public function testAes()
    {
        $data = [
            'appname' => 'barbershop',
            'version' => '1.0',
            'time' => Common_Time::getTimeStamp()
        ];
        // Ht0f4tPLcM9YYwZtchaXQVg9AtNFyM0AbQz3NodH4ga\/SgJ6\/nS4Av5osbUDFxzNJqReGNvxBipnNfkkSwYJGg==
        $sign_str = Common_IAuth::setSign($data);
        Common_Request::response(0, '', $sign_str);
    }

    public function testAes2()
    {
        $headers = Common_Request::getInstance()->header();
        $res = Common_IAuth::checkSignPass($headers);
        var_dump($res);
    }


    /**
     * 验证请求是否合法
     */
    public function checkRequestAuth()
    {
        // 获取header
        $headers = Common_Request::getInstance()->header();
        // 基础参数校验
        if( empty($headers['sign']) ) {
            Common_Request::response(400, 'sign参数未传递');
            // throw new ApiException('sign参数未传递', 400);
        }
        // 签名算法
        if( !Common_IAuth::checkSignPass($headers) ) {
            Common_Request::response(400, '授权码sign验签失败');
            // throw new ApiException('授权码sign验签失败', 400);
        }

        if( !Yaf_Registry::get('config')->application->debug ) {
            try {
                Common_Cache::getInstance()->set($headers['sign'], 1, Yaf_Registry::get('config')->time->sign_cache_time);
            } catch (Exception $exception) {
                // TODO 记录错误日志
            }
        }
        /*
        // sign唯一性  1、文件缓存 2、mysql 3、redis
        Common_Cache::getInstance()->set( $headers['sign'], 1, Yaf_Registry::get('config')->time->sign_cache_time );
        // 把sign存入redis，并且设置有效时间
        */

        $this->headers = $headers;
    }

}
