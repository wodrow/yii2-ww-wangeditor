<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-2-13
 * Time: 上午9:55
 */

namespace wodrow\yii2wwwangeditor\models;


use yii\base\Model;

class FormAttachmentsUpload extends Model
{
    public $attachments;

    public function attributeLabels()
    {
        return [
            'attachments' => "附件",
        ];
    }

    public function rules()
    {
        return [
            ['attachments', 'safe'],
        ];
    }
}