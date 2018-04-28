<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/**
 * Mail.php
 * @desc 邮件发送类
 * Created By Colorful
 * Date:2018/4/28
 * Time:上午1:12
 */
class MailController extends AbstractController {

    /**
     * 发送邮件接口
     */
    public function sendAction()
    {
        $uid = intval( $this->getRequest()->getPost('uid', 0) );
        $subject = trim( $this->getRequest()->getPost('subject', '') );
        $body = $this->getRequest()->getPost('body' , '');
        $attachment = $this->getRequest()->getPost('attachment' , '');
        $is_bis = $this->getRequest()->getPost('is_bis' , true);
        if( !$uid || !$subject || !$body ) {
            Common_Request::response( -3001, '参数传递不正确' );
        }
        $emailModel = new MailModel();
        try{
            $email = $emailModel->getEmailByUid($uid, true);
            if( !$email ) {
                Common_Request::response( $emailModel->errno, $emailModel->errmsg );
            } else {
                $res = '';
                try {
                    $res = $emailModel->send( $email, $subject, $body, $attachment );
                } catch (\Exception $e) {
                    Common_Request::response(-3005, $e->getMessage());
                }
                if( $res ) {
                    Common_Request::response(0, '');
                } else {
                    Common_Request::response( $emailModel->errno, $emailModel->errmsg );
                }
            }
        } catch (\Exception $exception) {
            Common_Request::response( -3002, $exception->getMessage() );
        }
    }

}
