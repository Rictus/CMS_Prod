<?php echo $header;
$catchImage = false;
$catchPhrase = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'catchphrase':
            $catchPhrase = $field;
            break;
        case 'catchimage':
            $catchImage = $field;
            break;
        default:
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/accueil/addCatch'); ?>" enctype="multipart/form-data"
          novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">
        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>


        <fieldset class="main">
            <div class="wrap">
                <?php
                if ($catchPhrase) {
                    echo Form::text('extend[' . $catchPhrase->key . ']', '', array(
                        'placeholder' => $catchPhrase->label,
                        'id' => "extend_" . $catchPhrase->key
                    ));
                }
                if ($catchImage) {
                    echo Form::text("extend[" . $catchImage->key . "]", null, array(
                        'placeholder' => $catchImage->label,
                        'autocomplete' => 'off',
                        'id' => 'extend_' . $catchImage->key,
                        'class' => 'upload_filename hide'
                    ));

                    echo "<p><img src='' alt='' class='file-image-preview'></p>";
                    echo '<div class="upload_explain">Glissez une image ici pour définir l\'image de votre accroche.</div>' .
                        '<div id="upload-file-progress"><progress value="0"></progress></div>';
                }
                ?>
                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>
                </aside>
            </div>
        </fieldset>

    </form>
<?php
addScriptTag('anchor/views/assets/js/slug.js');
addScriptTag('anchor/views/assets/js/dragdrop.js');
addScriptTag('anchor/views/assets/js/upload-fields.js');
addScriptTag('anchor/views/assets/js/text-resize.js');
addScriptTag('anchor/views/assets/js/ckeditor/ckeditor.js');
addScriptTag('anchor/views/assets/js/ckeditor_init.js');
?>
    <script>
        initDragdrop(function (url, filename) {
            $('.file-image-preview').attr('src', url).attr('value', url); //adding image to img element to display it
            $('.upload_explain').hide(); //Hiding explain, an upload has been done
            console.log(filename); //Displaying filename
            $('.upload_filename').attr("value", filename); //Init value of input text that should store filename
        });
    </script>
<?php echo $footer; ?>