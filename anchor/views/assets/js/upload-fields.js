/**
 * Populate placeholder when user selects a file to upload
 */
$(function () {
    var basename = function (path) {
        return path.replace(/\\/g, '/').replace(/.*\//, '');
    };

    /**
     * Display the image before sending ot to server
     * @param input     The <input type='file'> where the file comes from
     * @param img       The <img> element where to put the image
     * @return boolean  true if success : The file has been found, has been successfully identified as an image, is added to the given img element.
     *                  false otherwise
     *\/!\ FileReader API isn't supported in IE and Opera Mini
     * TODO Implement cross-browser work-around : http://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded
     */
    function readURLAsImageFile(input, img) {
        console.group("File added to the form : ");
        console.log(input.files ? input.files[0] : "No file added");
        console.groupEnd();
        if (input.files && input.files[0]) {
            if (input.files[0].type.startsWith('image')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    img.attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    $('input[type=file]').bind('change', function () {
        var input = $(this), placeholder = input.parent().parent().find('.current-file');
        var $img = $('<img class="file-image-preview" width="200" height="auto">');
        placeholder.html(basename(input.val()));
        if (readURLAsImageFile(input[0], $img)) {
            input.parent().parent().find(".file-image-preview").remove();
            input.parent().parent().append($img);
        }
    });
});