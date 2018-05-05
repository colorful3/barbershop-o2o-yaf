<?php
/**
 * Image.php
 * Created By Colorful
 * Date:2018/5/5
 * Time:上午7:22
 */
class ImageController extends AbstractController {


    public function localUploadAction()
    {
        $file = Common_Request::getInstance()->file('file');
        $info = $file->move('upload');
        if( $info->getPathname() ) {
            Common_Request::response(0, '', '/' . $info->getPathname() );
        } else {
            echo json_encode([
                'status' => 0,
                'message' => 'error',
                'data' => []
            ]);
            Common_Request::response(-4001, 'error' );

        }

    }
}
