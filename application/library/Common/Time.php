<?php
/**
 * Time.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:下午9:49
 */
class Common_Time {

    /**
     * 获取13位时间戳
     * @return int
     */
    public static function getTimeStamp() {
        list($t1, $t2) = explode(' ', microtime() );
        return $t2 . ceil($t1 * 1000);
    }
}
