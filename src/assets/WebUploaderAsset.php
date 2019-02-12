<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-12
 * Time: 下午4:32
 */

namespace wodrow\yii2wwwangeditor\assets;


use yii\web\AssetBundle;

class WebUploaderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/wodrow/yii2-ww-wangeditor/src/static/webuploader/dist';

    public function init()
    {
        $this->css = [
            'webuploader.css',
        ];
        $this->js = [
            'webuploader.nolog.js'
        ];
    }
}