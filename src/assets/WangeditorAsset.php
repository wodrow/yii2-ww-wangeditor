<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-12
 * Time: 上午11:53
 */

namespace wodrow\yii2wwwangeditor\assets;


use yii\web\AssetBundle;

class WangeditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/wodrow/yii2-ww-wangeditor/src/static';

    public function init()
    {
        $this->css = [
//            YII_DEBUG?'wangEditor.css':'wangEditor.min.css',
        ];
        $this->js = [
            YII_DEBUG?'wangEditor.js':'wangEditor.min.js',
        ];
    }
}