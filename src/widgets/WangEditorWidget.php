<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-12
 * Time: 下午1:00
 */

namespace wodrow\yii2wwwangeditor\widgets;


use wodrow\yii2wwwangeditor\assets\WangeditorAsset;
use wodrow\yii2wwwangeditor\assets\WangEditorFullScreenAsset;
use wodrow\yii2wwwangeditor\assets\WebUploaderAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class WangEditorWidget extends InputWidget
{
    /**
     * 客户端 js 扩展
     * 使用替换变量：{name}:editor实例，{hiddenInputId}:隐藏输入域的id
     * example:
     * <<<JS
     * {name}.customConfig.uploadImgServer = '/upload/wang';
     * {name}.customConfig.onchange = function (html) {
     *    $('#{hiddenInputId}').val(html);
     * }
     * JS;
     * @link https://www.kancloud.cn/wangfupeng/wangeditor3/332599
     * @var string
     */
    public $clientJs;
    /**
     * 是否显示全屏
     * @link https://github.com/chris-peng/wangEditor-fullscreen-plugin
     * @var bool
     */
    public $canFullScreen = true;

    public $customImagesUploadServer;

    /**
     * @var string
     */
    private $_editorId;

    public $name;

    public function init()
    {
        parent::init();
        $this->_editorId = 'editor-' . $this->id;
        \Yii::trace($this->id);
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
            $attribute = $this->attribute;
            $content = Html::getAttributeValue($this->model, $attribute);
        } else {
            echo Html::hiddenInput($this->name, $this->value, $this->options);
            $content = $this->value;
        }
        echo Html::tag('div', $content, ['id' => $this->_editorId]);
        $this->registerJs();
        return $this->render('attachuploader', [
            'name' => $this->name,
        ]);
    }

    public function registerJs()
    {
        $view = $this->getView();
        WangeditorAsset::register($view);
        if ($this->canFullScreen) {
            WangEditorFullScreenAsset::register($view);
        }

        $id = $this->_editorId;
        $name = $this->name = 'editor' . $this->id;
        $hiddenInputId = $this->options['id'];
        $imagesUploadServer = Url::to(['/wangeditor/upload/images-upload'], true);
        if ($this->customImagesUploadServer){
            $imagesUploadServer = $this->customImagesUploadServer;
        }
        $this->clientJs = "{name}.customConfig.uploadImgServer = '{$imagesUploadServer}';{name}.customConfig.zIndex = 100;";
        $clientJs = strtr($this->clientJs, [
            '{name}' => $name,
            '{hiddenInputId}' => $hiddenInputId
        ]);
        $js = <<<JS
var WangEditor = window.wangEditor;
var {$name} = new WangEditor('#{$id}');
{$name}.customConfig.onchange = function (html) {
    $('#{$hiddenInputId}').val(html);
}
{$clientJs}
{$name}.create();
JS;
        if ($this->canFullScreen) {
            $js .= <<<JS
WangEditor.fullscreen.init('#{$id}');
JS;
        }
        $js .= <<<JS
$({$name}.toolbarSelector).find('.w-e-toolbar').append('<div class="w-e-menu"><a data-toggle="modal" data-target="#modal-{$name}">上传附件</a></div>');
JS;

        $view->registerJs($js);
    }

    protected function registerFullScreenAsset()
    {

    }
}