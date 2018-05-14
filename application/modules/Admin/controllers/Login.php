<?php
/**
 * Login.php
 * Created By Colorful
 * Date:2018/5/12
 * Time:下午7:23
 */
class LoginController extends AbstractController
{
    // 当前登录用户
    static $current_user;

    // 存在session中的用户
    protected $admin_user = 'admin_user';


    function init()
    {
        // 重写初始化方法。
    }

    /**
     * 登录页面
     */
    public function indexAction()
    {
        /*
        // 使用smarty的传统方式
        $config = Yaf_Registry::get('config')->smarty->toArray();
        $smarty = new Smarty();
        $smarty->setTemplateDir($config['template_dir']);
        $smarty->setCompileDir($config['compile_dir']);
        $smarty->setConfigDir($config['config_dir']);
        $smarty->setCacheDir($config['cache_dir']);

        return $smarty->display('login/index.tpl');
        */

        if( $this->getRequest()->isPost() ) {
            // var_dump($_POST);
            $data = $this->getRequest()->getPost();
            if( !$data['username'] || !$data['password'] ) {
                Common_Request::response(-9001, '用户名或密码不正确');
            }
	    // 实例化admin模型
	    $obj = new AdminModel();
	    $uid = $obj->login( strtolower( trim( $data['username'] ) ), trim( $data['password'] ));
	    if( !$uid ) {
		    Common_Request::response( $obj->errno, $obj->errmsg);
	    }
        // 登录成功，设置登录态到session中,TODO
        $yaf_session = Yaf_Session::getInstance();
//         var_dump( $yaf_session->get('admin_user') );exit;
        self::$current_user = [
            'user_token' => md5('Colorful' . $_SERVER['REQUEST_TIME'] . $uid ),
            'user_token_time' => $_SERVER['REQUEST_TIME'],
            'user_id' => $uid
        ];
        // 判断session是否存在
        if( !$yaf_session->has($this->admin_user) ) {
            // 不存在，则设置session

            $yaf_session->set($this->admin_user, self::$current_user);
        }

        Common_Request::response( 0, 'OK', $data['username'] );
        // 如果是post方式提交，那么关闭模板渲染。
        return false;
        } else {
            // 如果是get方式提交，那么打开模板渲染。
            return true;
        }
    }


}
