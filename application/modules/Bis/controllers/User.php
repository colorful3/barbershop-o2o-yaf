<?php
/**
 * User.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:14
 */
class UserController extends AbstractController
{

    static $current_user;

    /**
     * 商家用户登录接口
     */
    public function loginAction() {
        // var_dump($data);exit;
        $uname = $this->getRequest()->getPost('uname', ''); // 可以是用户名、邮箱、或者手机号
        // $email = $this->getRequest()->getPost('email', '');
        $pwd = $this->getRequest()->getPost('pwd', '');
        if( !$uname || !$pwd  ) {
            Common_Request::response(-1004, '用户名或密码不正确');
        }
        $model = new BisModel();
        // 开始验证密码是否正确
        $uid = $model->login($uname, $pwd);
        if( !$uid ) {
            Common_Request::response($model->errno, $model->errmsg);
        }
        // 获取session实例
        $yaf_session = Yaf_Session::getInstance();
        // var_dump( $yaf_session->get('bis_account') );exit;
        self::$current_user = [
            'user_token' => md5('Colorful' . $_SERVER['REQUEST_TIME'] . $uid ),
            'user_token_time' => $_SERVER['REQUEST_TIME'],
            'user_id' => $uid
        ];
        // 判断session是否存在
        if( !$yaf_session->has($this->bis_user) ) {
            // 不存在，则设置session

            $yaf_session->set($this->bis_user, self::$current_user);
        }
        // 登录成功，更新数据库相关数据
        $model->updateLoginData($uid);
        Common_Request::response(0, '', $uname );
    }

    /**
     * 用户退出登录接口
     */
    public function logoutAction() {
        $yaf_session = Yaf_Session::getInstance();
        $yaf_session->del($this->bis_user);
        session_destroy();
        Common_Request::response(0, '');
    }

    /**
     * 商家用户注册接口
     */
    public function registerAction()
    {
        $uname = $this->getRequest()->getPost('uname', '');
        $pwd = $this->getRequest()->getPost('pwd', '');
        $email = $this->getRequest()->getPost('email', '');
        if( !$uname || !$pwd || !$email) {
            Common_Request::response(-1001, '参数传递不正确');
        }
        // 生成密码盐
        $salt = Common_IAuth::randSalt(32);
        // 对密码进行加密处理
        $md5_pwd = Common_IAuth::pwdEncode($pwd, $salt);
        $data = array(
            $uname, $md5_pwd, $salt, $email
        );
        // var_dump($data);exit;
        $model = new BisModel();
        $last_id = $model->add($data);
        // TODO sms短信验证
        if( !$last_id ) {
            Common_Request::response($model->errno, $model->errmsg);
        } else {
            Common_Request::response(0, $uname);
        }
    }

    /**
     * 商家用户详情接口
     */
    public function userInfoAction(){
        Common_Request::response(0, '', self::$current_user );
    }
}
