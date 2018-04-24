<?php
/**
 * Time.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:下午9:53
 */
class TimeController extends Yaf_Controller_Abstract
{
    // 服务端客户端时间一致性解决方案
    public function indexAction() {
        Common_Request::response(0, '', Common_Time::getTimeStamp() );
    }
}