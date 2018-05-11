<?php
/**
 * Index.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午10:59
 */

class IndexController extends AuthBaseController {

    /**
     * 商家首页接口
     */
    public function indexAction()
    {
        echo "this is index action in Bis module";
    }

    /**
     * 临时测试接口
     */
    public function testAction()
    {
        $redis = Common_Cache::getInstance();
        $redis->set('demo', 'demo');
        $info = $redis->get('demo');
        var_dump($info);
        $redis->delete('demo');
        $info = $redis->get('demo');
        var_dump($info);
    }

}
