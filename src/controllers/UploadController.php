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
}