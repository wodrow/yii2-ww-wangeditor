<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-12
 * Time: 下午1:46
 */

namespace wodrow\yii2wwwangeditor\assets;


use yii\web\AssetBundle;

class WangEditorFullScreenAsset extends AssetBundle
{
    public $sourcePath = '@vendor/wodrow/yii2-ww-wangeditor/src/static/plugins/fullscreen';

    public function init()
    {
        $this->css = [
            'wangEditor-fullscreen-plugin.css',
        ];
        $this->js = [
            'wangEditor-fullscreen-plugin.js',
        ];
    }
}