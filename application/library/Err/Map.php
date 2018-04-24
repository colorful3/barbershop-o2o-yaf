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
        1001 => '请通过正规渠道提交',
    );

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
