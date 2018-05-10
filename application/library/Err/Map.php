<?php
/**
 * Map.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午11:30
 * @desc 错误字典公共类
 */
class Err_Map
{
    const ERRMAP = array(
        1000 => 'Exception Error!',
        1001 => '参数传递不正确',
        1002 => '该用户已存在，请重新输入用户名',
        1003 => '插入数据失败',
        1004 => '用户名或密码不正确',
        1005 => '没有此用户或用户状态不合法',
        1006 => '用户名或密码不正确',
        1007 => '设置token失败',
        1008 => '获取用户失败',
        1009 => '退出登录失败',
        1010 => '未知的退出登录用户，请指定用户id',

    );

    /**
     * 根据错误码得到错误信息
     * @param $code  : 错误码
     * @return array : 错误信息
     */
    static function get($code) {
        if( isset(self::ERRMAP[$code]) ) {
            return array(
                0 => (0 - $code),
                1 => self::ERRMAP[$code]
            );
        } else {
            return array(
                0 => (0 - $code),
                1 => "undefined this error code"
            );
        }
    }
}
