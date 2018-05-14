<?php
class AdminModel {
    public $errno = 0;
    public $errmsg = '';

    // 登录校验方法
    public function login( $uname, $pwd )
    {
        if( empty($uname) || empty($pwd) ) {
	    $this->errno = -9002;
        $this->errmsg = '用户名和密码是必须参数';
	    return false;
	}
	$query = Db_Base::getInstance()->prepare("SELECT * FROM `admin` WHERE `username` = ? OR `phone` = ? OR `email` = ? ");
	$query->execute([$uname, $uname, $uname]);
	$admin_userinfo = $query->fetchAll();
	if( !$admin_userinfo || $admin_userinfo[0]['status'] != 'normal' ) {
	    $this->errno = -9003;
	    $this->errmsg = '用户不存在或用户状态不正常';
	    return false;
	}
        if( Common_IAuth::pwdEncode( $pwd, $admin_userinfo[0]['salt'] ) != $admin_userinfo[0]['password'] ) {
	    $this->errno = -9004;
	    $this->errmsg = "密码不正确";
	    return false;
	}
	return intval( $admin_userinfo[0]['id'] );
        
    }    
}
