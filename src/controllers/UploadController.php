<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-12
 * Time: 下午2:35
 */

namespace wodrow\yii2wwwangeditor\controllers;


use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;

class UploadController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionImagesUpload()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        foreach ($_FILES as $k => $v) {
            $size = $v['size'];
            if ($size > 5 * 1024 * 1024) {
                echo $size / 1024 / 1024;
                exit;
            }
        }
        $data = [];
        foreach ($_FILES as $k => $v) {
            $tmp_name = $v['tmp_name'];
            $tmp_path = \Yii::getAlias('@tmp_root/' . $v['name']);
            file_put_contents($tmp_path, file_get_contents($tmp_name));
            $name_ext = 'wangeditor/' . date('Y-m-d'). '/images/' . \Yii::$app->security->generateRandomString(10). "_" .$v['name'];
            $upload_path = \Yii::getAlias("@uploads_root/{$name_ext}");
            $upload_url = \Yii::getAlias("@uploads_url/{$name_ext}");
            if (!is_dir(dirname($upload_path))){
                FileHelper::createDirectory(dirname($upload_path));
            }
            if (file_put_contents($upload_path, file_get_contents($tmp_path))){
                $data[] = $upload_url;
            }
        }
        $resp = [
            'errno' => 0,
            'data' => $data,
            'files' => $_FILES,
            'req' => $_REQUEST,
        ];
        return $resp;
    }

    public function actionAttachmentsUpload()
    {
        \Yii::$app->response->format = 'json';
        $model_name = \Yii::$app->request->post('model_name');
        if (empty($_FILES[$model_name])) {
            return ['error'=>'没有找到上传的文件.'];
        }
        $file = $_FILES[$model_name];
        $filenames = $file['name'];
//        return ['error'=>'上传失败:'.var_export($file, true)];
        $upload_dir = \Yii::getAlias("@uploads_root/wangeditor_attachments");
        $upload_url = \Yii::getAlias("@uploads_url/wangeditor_attachments");
        if (!is_dir($upload_dir)){
            FileHelper::createDirectory($upload_dir);
        }
        foreach ($filenames as $k => $v){
            $image_ext_name = pathinfo(($file['name'][$k][0]), PATHINFO_EXTENSION);
            $random_string = \Yii::$app->security->generateRandomString(32);
            $image_name = date("Ymd_His_")."{$random_string}.".$image_ext_name;
            if (file_put_contents($upload_dir.DIRECTORY_SEPARATOR.$image_name, file_get_contents($file['tmp_name'][$k][0]))){
                $attachment_url = $upload_url.DIRECTORY_SEPARATOR.$image_name;
                return [
                    'label_name' => $file['name'][$k][0],
                    'url' => $attachment_url,
                ];
            }else{
                return ['error'=>"上传失败，请联系站长"];
                break;
            }
        }
    }
}