/*window.wangEditor.attachment = {
    // editor create之后调用
    init: function(editorSelector){
        alert(1);
        $(editorSelector + " .w-e-toolbar").append('<div class="w-e-menu"><a href="###" onclick="alert(1)">fsadf</a>');
    },
};*/

window.wangEditor.attachment = {
    // editor create之后调用
    init: function(editorSelector){
        $(editorSelector + " .w-e-toolbar").append('<div class="w-e-menu"><a class="_wangEditor_btn_fullscreen" href="###" onclick="window.wangEditor.attachment.toggleFullscreen(\'' + editorSelector + '\')">fsadf</a></div>');
    },
    toggleFullscreen: function(editorSelector){
        $(editorSelector).toggleClass('fullscreen-editor');
        if($(editorSelector + ' ._wangEditor_btn_fullscreen').text() == 'fasdf'){
            $(editorSelector + ' ._wangEditor_btn_fullscreen').text('退出gsadfasd');
        }else{
            $(editorSelector + ' ._wangEditor_btn_fullscreen').text('sdfsa');
        }
    }
};