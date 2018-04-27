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
    public function testAction() {
        $arrConfig = Yaf_Application::app()->getConfig();
        $data = [
            'uname' => 'Colorful',
            'pwd' => '1234098',
            'ctime' => 0
        ];
        Common_Request::response(-1002, '哈哈哈哈', $data);
    }

}
