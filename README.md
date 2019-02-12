# yii2-ww-wangeditor
使用版本为3.1.1

[wangEditor 官网](http://www.wangeditor.com/)

安装
------------

```
php composer.phar require wodrow/yii2-ww-wangeditor "dev-master"
```

使用
-----

```php
echo \wodrow\yii2wwwangeditor\widgets\WangEditorWidget::widget([
    'name' => 'inputName',
    //'canFullScreen' => true, // 增加全屏的按钮
]);
```

配置
-----

## clientJs 客户端 js 扩展

可替换变量：

 - `{name}`:editor实例
 - `{hiddenInputId}`:隐藏输入域的id

配置举例：

```php
'clientJs' => <<<JS
// 设置上传文件路径
{name}.customConfig.uploadImgServer = '/upload/wang';
// 将富文本的数据更改后加入到隐藏域，该方法默认已经配置，不需要重复写，可以覆盖写
{name}.customConfig.onchange = function (html) {
   $('#{hiddenInputId}').val(html);
}
JS
```

更多配置见[官网配置](https://www.kancloud.cn/wangfupeng/wangeditor3/332599)

完整例子设置图片上传的路径
-----

```php
$clientJs = <<<JS
{name}.customConfig.uploadImgServer = '/upload/wang';
JS;
echo \wodrow\yii2wwwangeditor\widgets\WangEditorWidget::widget([
    'name' => 'content',
    'clientJs' => $clientJs
]);
```