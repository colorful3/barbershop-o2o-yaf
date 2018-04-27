<?php
/**
 * Bisuser.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:14
 * @desc 商家用户控制器
 */
class BisuserController extends AbstractController
{
    // 模型类对象成员属性
    private $_obj;

    public function init()
    {
        parent::init();
        $this->_obj = new BisModel();
    }

    /**
     * 商家用户登录接口
     */
    public function loginAction()
    {
        // 得到post的数据
        $postData = $this->getRequest()->getPost();
        if( !isset($postData['uname']) || !isset($postData['pwd'])  ) {
            Common_Request::response(-1004, '用户名或密码不正确');
        }
        $uid = 0;
        try {
            // 开始验证密码是否正确
            $uid = $this->_obj->login($postData['uname'], $postData['pwd']);
        } catch (\Exception $exception) {
            Common_Request::response( -1007, $exception->getMessage() );
        }
        if( !$uid ) {
            Common_Request::response($this->_obj->errno, $this->_obj->errmsg);
        }
        // 设置token
        $token = Common_IAuth::setAppLoginToken($postData['uname']);
        $res = 0;
        try {
            // 根据uid更新用户token
            $res = $this->_obj->setUserToken($token, $uid);
        } catch (\Exception $exception) {
            Common_Request::response( -1007, $exception->getMessage() );
        }
        if( !$res ) {
            Common_Request::response( $this->_obj->errno, $this->_obj->errmsg );
        }
        $aes_key = Yaf_Registry::get('config')->keys->aes_salt;
        $aes_obj = new Common_Aes($aes_key);
        // 拼接返回给客户端的数据
        $data = array(
            // token => d4ZYxo+v1UXeAjY0olCrmjsXf0JDcHPzyhl82PmPMoM80ndsTMZTtKFxh9070bHi
            'token' =>  $aes_obj->encrypt( $token . "||" . $uid ),
            'uid' => $uid,
            'uname' => $postData['uname']
        );
        /*
        # 改为user_access_token登录
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
        */
        // 登录成功，更新数据库相关数据
        $this->_obj->updateLoginData($uid);
        Common_Request::response(0, '', $data );
    }

    /**
     * 用户退出登录接口
     */
    public function logoutAction()
    {
        $uid = $this->getRequest()->getPost('uid', 0);
        if( !$uid ) {
            return Common_Request::response(-1011, '未知的退出登录用户，请指定用户id');
        }
        $res = 0;
        try {
            $res = $this->_obj->logout($uid);
        } catch (\Exception $exception) {
            Common_Request::response( -1012, $exception->getMessage() );
        }
        if( !$res ) {
            Common_Request::response( $this->_obj->errno, $this->_obj->errmsg );
        }
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
            Common_Request::response(0, '', $uname);
        }
    }

    /**
     * 商家用户详情接口
     */
    public function userInfoAction() {
        Common_Request::response(0, '', $this->bis_user );
    }
}
