<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-12
 * Time: 下午4:50
 */
/**
 * @var \yii\web\View $this
 * @var string $name
 * @var \wodrow\yii2wwwangeditor\models\FormAttachmentsUpload $attachmentsModel
 * @var string $attachmentsUploadServer
 */

use kartik\file\FileInput;
use yii\widgets\ActiveForm;

?>

<div class="modal fade" id="modal-<?=$name ?>" tabindex="-1" role="dialog" aria-labelledby="modal-<?=$name ?>-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">上传附件</h4>
            </div>
            <div class="modal-body">
                <?php
                echo FileInput::widget([
                    'model' => $attachmentsModel,
                    'attribute' => "attachments[]",
                    'options' => [
                        'accept' => '*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        // 是否展示预览图
                        'initialPreviewAsData' => true,
                        // 异步上传的接口地址设置
                        'uploadUrl' => urldecode($attachmentsUploadServer),
                        // 异步上传需要携带的其他参数，比如商品id等
                        'uploadExtraData' => [
                            'model_name' => 'FormAttachmentsUpload',
                            'attr_name' => 'attachments',
                        ],
                        'uploadAsync' => true,
                        // 最少上传的文件个数限制
                        'minFileCount' => 1,
                        // 最多上传的文件个数限制
                        'maxFileCount' => 100,
                        // 是否显示移除按钮，指input上面的移除按钮，非具体图片上的移除按钮
                        'showRemove' => true,
                        // 是否显示上传按钮，指input上面的上传按钮，非具体图片上的上传按钮
                        'showUpload' => true,
                        //是否显示[选择]按钮,指input上面的[选择]按钮,非具体图片上的上传按钮
                        'showBrowse' => true,
                        // 展示图片区域是否可点击选择多文件
                        'browseOnZoneClick' => true,
                        // 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
                        'fileActionSettings' => [
                            // 设置具体图片的查看属性为false,默认为true
                            'showZoom' => false,
                            // 设置具体图片的上传属性为true,默认为true
                            'showUpload' => true,
                            // 设置具体图片的移除属性为true,默认为true
                            'showRemove' => false,
                        ],
                    ],
                    // 一些事件行为
                    'pluginEvents' => [
                        // 上传成功后的回调方法，需要的可查看data后再做具体操作，一般不需要设置
                        "fileuploaded" => "function (event, data, id, index) {
                            {$name}.txt.append('<p><a href=\"' + data.response.url + '\" target=\"_blank\">' + data.response.label_name + '</a></p>');
                            if(data.files.length == index + 1){
                                $('#modal-{$name}').modal('hide')
                            }
                            {$name}.change();
                        }",
                    ],
                ]);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
