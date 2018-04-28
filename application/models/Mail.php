<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Mail.php
 * Created By Colorful
 * Date:2018/4/28
 * Time:上午1:37
 */
class MailModel {

    public $errno = 0;
    public $errmsg = '';

    protected static $config = [];

    public function __construct()
    {
        self::$config = array(
            'host' => Yaf_Registry::get('config')->mail->host,
            'username' => Yaf_Registry::get('config')->mail->username,
            'password' => Yaf_Registry::get('config')->mail->password,
            'port' => Yaf_Registry::get('config')->mail->port,
            'from_name' => Yaf_Registry::get('config')->mail->fromname,
        );
    }

    public function send( $to, $subject, $body, $attachment = '' )
    {
        $mail = new PHPMailer();                                  // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = self::$config['host'];                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = self::$config['username'];          // SMTP username
            $mail->Password = self::$config['password'];          // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = self::$config['port'];                  // TCP port to connect to

            //Recipients
            $mail->setFrom(self::$config['username'], self::$config['from_name']);
            $mail->addAddress( $to );                             // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('fujiale3@126.com', 'He had received mail!');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            if( $attachment ) {
                $mail->addAttachment( $attachment );         // Add attachments
            }
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                            // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        $this->errno = -3003;
        $this->errmsg = "发送邮件失败";
        return false;
    }

    public function getEmailByUid( $uid, $is_bis = true ) {
        if( $is_bis ) {
            $sql = "SELECT `email` FROM `bis_account` WHERE `id` = ? ";
        } else {
            $sql = "SELECT `email` FROM `user` WHERE `id` = ? ";
        }
        $query = Db_Base::getInstance()->prepare($sql);
        $query->execute([$uid]);
        $ret = $query->fetchAll();
        if( !$ret || !filter_var( $ret[0]['email'], FILTER_VALIDATE_EMAIL ) ) {
            $this->errno = -3004;
            $this->errmsg = "邮箱格式不正确";
            return false;
        } else {
            return $ret[0]['email'];
        }

    }
}
