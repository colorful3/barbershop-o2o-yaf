<?php
/**
 * Bis.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:43
 */
class BisModel
{
    public $errno = 0;
    public $errmsg = '';

    /**
     * 注册用户
     * @param $data
     * @return bool|int
     */
    public function add($data) {
        $res = $this->checkExists($data[0], $data[3]);
        if(!$res) {
            $this->errno = -1002;
            $this->errmsg = '该用户已存在，请重新输入用户名';
            return false;
        }
        $query = Db_Base::getInstance()->prepare(
            "INSERT INTO `bis_account` (`uname`, `pwd`, `salt`, `email`, `c_time`)
              VALUES (?,?,?,?,?)"
        );
        $data[] = date("Y-m-d H:i:s");
        // var_dump($data);exit;
        $ret = $query->execute( $data );
        if(!$ret) {
            $this->errno = -1003;
            $this->errmsg = "插入数据失败";
            return false;
        }
        return (int)Db_Base::getInstance()->lastInsertId();
    }


    public function login($uname , $pwd) {
        $query = Db_Base::getInstance()->prepare("SELECT * from `bis_account` WHERE `uname` = ? OR `email` = ? OR `phone` = ? ");
        $query->execute([$uname, $uname, $uname]);
        $user_info = $query->fetchAll();
        if( !$user_info || $user_info[0]['status'] != 'normal' ) {
            $this->errno = -1005;
            $this->errmsg = '没有此用户或用户状态不合法';
            return false;
        }

        if( Common_IAuth::pwdEncode($pwd, $user_info[0]['salt']) != $user_info[0]['pwd'] ) {
            $this->errno = -1006;
            $this->errmsg = "用户名或密码不正确";
            return false;
        }
        return intval( $user_info[0]['id'] );
    }

    public function updateLoginData($uid) {
        $query = Db_Base::getInstance()->prepare(
            "UPDATE `bis_account` SET `last_login_time` = ?, `last_login_ip` = ? WHERE `id` = ?"
        );
        $ret = $query->execute([
            date('Y-m-d H:i:s'),
            ip2long( $_SERVER['REMOTE_ADDR'] ),
            intval($uid)
        ]);
        if( $ret ) {
            return true;
        } else {
            // TODO 记录错误日志
            return false;
        }
    }

    /**
     * 设置token
     * @param $token
     * @param $uid
     * @return bool
     */
    public function setUserToken($token, $uid)
    {

        $query = Db_Base::getInstance()->prepare(
            "UPDATE `bis_account` SET `token` = ?, `token_timeout` = ? WHERE `id` =? "
        );
        $ret = $query->execute([$token, date('Y-m-d H:i:s', time() + 604800 ), $uid]);
        if( !$ret ) {
            $this->errno = -1008;
            $this->errmsg = '设置token失败';
            return false;
        } else {
            return true;
        }
    }

    /**
     * 根据用户token和uid获取用户详情
     * @param $token
     * @param $uid
     * @return bool
     */
    public function getUserByToken( $token, $uid )
    {
        $query = Db_Base::getInstance()->prepare(
            "SELECT * FROM `bis_account` WHERE `token` = ? AND `id` = ?"
        );
        $query->execute([$token, $uid]);
        $res = $query->fetchAll();
        if( !$res || $res[0]['status'] != 'normal' ) {
            $this->errno = -1009;
            $this->errmsg = '获取用户失败';
            return false;
        } else {
            return $res[0];
        }
    }

    /**
     * 验证用户是否存在
     * @param $uname
     * @param $email
     * @return bool
     */
    private function checkExists( $uname, $email ) {
        $query = Db_Base::getInstance()->prepare("SELECT COUNT(1) AS c FROM `bis_account` WHERE `uname` = ? OR  `email` = ?");
        $query->execute(array($uname, $email));
        $count = $query->fetchAll();
        if( $count[0]['c'] != 0 ) {
            return false;
        }
        return true;
    }
}
