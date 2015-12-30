var $editor = $('textarea.ckeditorgo')[0];

CKEDITOR.editorConfig = function (config) {
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'doctools', 'document']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'links', groups: ['links']},
        {name: 'forms', groups: ['forms']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'styles', groups: ['styles']},
        {name: 'insert', groups: ['insert']},
        {name: 'colors', groups: ['colors']},
        {name: 'about', groups: ['about']}
    ];
    config.allowedContent = true;
    config.extraPlugins = 'uploadimage,videodetector';

    config.removeButtons = 'Subscript,Superscript,Cut,Redo,Copy,Undo,PasteText,PasteFromWord,Paste,Scayt,Link,Unlink,Anchor,SpecialChar,HorizontalRule,Maximize,Source,Strike,Outdent,Indent,Blockquote,Styles,Font,About,RemoveFormat,Underline,elementspath';
    config.image = "/content";
    config.imageUploadUrl = "/content";
};

CKEDITOR.editorConfig = function (config) {

    // %REMOVE_START%
    // The configuration options below are needed when running CKEditor from source files.
    config.plugins = 'dialogui,dialog,about,a11yhelp,basicstyles,blockquote,clipboard,panel,floatpanel,menu,contextmenu,resize,button,toolbar,enterkey,entities,popup,filebrowser,floatingspace,listblock,richcombo,format,horizontalrule,htmlwriter,wysiwygarea,image,indent,indentlist,fakeobjects,link,list,magicline,maximize,pastetext,pastefromword,removeformat,showborders,sourcearea,specialchar,menubutton,scayt,stylescombo,tab,table,tabletools,undo,wsc,autogrow,ccmsconfighelper,autolink,autoembed,font,tableresize,staticspace,templates,lineutils,widget,filetools,notification,notificationaggregator,uploadwidget,uploadimage';
    config.skin = 'moono';
    // %REMOVE_END%

    // Set the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre;iframe';

    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';

    config.extraPlugins = 'uploadimage,videodetector';
    config.imageUploadUrl = "/admin/posts/upload";

    config.allowedContent = true;
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'doctools', 'document']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'links', groups: ['links']},
        {name: 'forms', groups: ['forms']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph', 'videodetector']},
        {name: 'styles', groups: ['styles']},
        {name: 'insert', groups: ['insert']},
        {name: 'colors', groups: ['colors']},
        {name: 'about', groups: ['about']}
    ];

    config.removeButtons = 'Subscript,Superscript,Styles,Cut,Redo,Copy,Undo,PasteText,PasteFromWord,Paste,Scayt,Link,Unlink,Anchor,SpecialChar,HorizontalRule,Maximize,Source,Strike,Outdent,Indent,Blockquote,Styles,Font,About,RemoveFormat,Underline,Templates,NumberedList,FontSize,Table,elementspath';
};
if ($editor)
    CKEDITOR.replace($editor);