
var $editor = $('textarea.ckeditorgo')[0];

CKEDITOR.editorConfig = function( config ) {
    config.toolbarGroups = [
        { name: 'document', groups: [ 'mode', 'doctools', 'document' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'about', groups: [ 'about' ] }
    ];

    config.extraPlugins = 'uploadimage';

    config.removeButtons = 'Subscript,Superscript,Cut,Redo,Copy,Undo,PasteText,PasteFromWord,Paste,Scayt,Link,Unlink,Anchor,SpecialChar,HorizontalRule,Maximize,Source,Strike,Outdent,Indent,Blockquote,Styles,Font,About,RemoveFormat,Underline,elementspath';
    config.image = "/content";
    config.imageUploadUrl = "/content";
};
if($editor)
    CKEDITOR.replace($editor);