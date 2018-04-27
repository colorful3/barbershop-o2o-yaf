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
<<<<<<< HEAD
   }

   public function testAction() {
       // var_dump( openssl_get_cipher_methods() );
       $key = 'ColorfulColorful';
       $obj = new Common_Aes( $key );
       $res = $obj->encrypt('yzg');
       $res2 = $obj->decrypt($res);
       var_dump( $res, $res2 );
   }
=======
    }

    public function testAction() {
        $key = 'Colorful';
        $obj = new Common_Aes( $key  );
        $res = $obj->encrypt('yzg');
        $res2 = $obj->decrypt($res);
        var_dump( $res, $res2  );
    }
>>>>>>> 9bda410cd47b58e5d8942c53f2bab9ee87bea638

}
