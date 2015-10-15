
$('body').add('yui3-skin-sam');

var WYSIWYGEditorSelector = $("textarea");

// Create a new YUI instance and populate it with the required modules.
YUI().use('editor', function (Y) {
    // Rich Text Editor is available and ready for use. Add implementation
    // code here.
});
YUI().use('editor-base', function(Y) {

    var editor = new Y.EditorBase({
        content: '<strong>This is <em>a test</em></strong> <strong>This is <em>a test</em></strong> '
    });

    //Add the BiDi plugin
    editor.plug(Y.Plugin.EditorBidi);

    //Focusing the Editor when the frame is ready..
    editor.on('frame:ready', function() {
        this.focus();

        var inst = this.getInstance();
        //inst is now an instance of YUI that is bound to the iframe.

        var body = inst.one('body');
        //body is a Node instance of the BODY element "inside" the iframe.


        var strongs = inst.all('strong');
        //strongs is a NodeList instance of all the STRONG elements "inside" the iframe.
    });

    //Rendering the Editor.
    editor.render(WYSIWYGEditorSelector);

});