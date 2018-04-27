<?php
/**
 * Index.php
 * Created By Colorful
 * Date:2018/4/24
 * Time:上午10:59
 */

class IndexController extends AuthBaseController {

    public function indexAction() {
        echo 'this is index action in Bis module';
   }

   public function testAction() {
       // var_dump( openssl_get_cipher_methods() );
       $key = 'ColorfulColorful';
       $obj = new Common_Aes( $key );
       $res = $obj->encrypt('yzg');
       $res2 = $obj->decrypt($res);
       var_dump( $res, $res2 );
   }

}
