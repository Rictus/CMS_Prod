<?php echo $header;
$catchImage = false;
$catchPhrase = false;
$catchImage_en = false;
$catchPhrase_en = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'catchphrase':
            $catchPhrase = $field;
            break;
        case 'catchimage':
            $catchImage = $field;
            break;
        case 'catchphrase_en':
            $catchPhrase_en = $field;
            break;
        case 'catchimage_en':
            $catchImage_en = $field;
            break;
        default:
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/accueil/editCatch/' . $post->id); ?>"
          enctype="multipart/form-data" novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">
        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="meta split">
            <div class="wrap">
                <?php
                if ($catchPhrase) {
                    $v = array_key_exists('text', $catchPhrase->value) ? $catchPhrase->value->text : "";
                    echo Form::text('extend[' . $catchPhrase->key . ']', $v, array(
//                        'placeholder' => $catchPhrase->label,
                        'id' => "extend_" . $catchPhrase->key,
                        'label' => Html::entities($catchPhrase->label)
                    ));
                }
                if ($catchPhrase_en) {
                    $v = array_key_exists('text', $catchPhrase_en->value) ? $catchPhrase_en->value->text : "";
                    echo Form::text('extend[' . $catchPhrase_en->key . ']', $v, array(
//                        'placeholder' => $catchPhrase_en->label,
                        'id' => "extend_" . $catchPhrase_en->key,
                        'label' => Html::entities($catchPhrase_en->label)
                    ));
                }
                if ($catchImage) {
                    $v = array_key_exists('text', $catchImage->value) ? $catchImage->value->text : "";
                    echo Form::text("extend[" . $catchImage->key . "]", $v, array(
                        'placeholder' => $catchImage->label,
                        'autocomplete' => 'off',
                        'id' => 'extend_' . $catchImage->key,
                        'class' => 'upload_filename hide'
                    ));

                    echo "<p><img src='/content/" . $v . "' alt='' class='file-image-preview'></p>";
                    echo '<div class="upload_explain">Glissez une image ici pour définir l\'image de votre accroche.</div>' .
                        '<div id="upload-file-progress"><progress value="0"></progress></div>';
                }
                ?>
            </div>
        </fieldset>

        <fieldset class="meta split">
            <div class="wrap">

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
<?php
echo $footer;
?>