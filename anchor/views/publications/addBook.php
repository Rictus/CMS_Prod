<?php echo $header; ?>
<?php
$bookImageField = false;
$externallink = false;
$typeofpublication = false;
$targetLanguage = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'bookimage':
            //The process of uploading an image is done with js/ajax.
            //The uploaded filename is then store in a input[type=text]
            //TODO Need a workaround to change the filename on serverside
            $bookImageField = $field;
            break;
        case 'externallink':
            $externallink = $field;
            break;
        case 'typeofpublication':
            //Say if it's a book or a text publication. Normally book here
            $typeofpublication = $field;
            break;
        case 'targetlanguage':
            $targetLanguage = $field;
            break;
        default;
            //We do not get other extends
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/publications/addBook'); ?>" enctype="multipart/form-data"
          novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>


        <fieldset class="main split">
            <div class="wrap">

                <?php echo Form::text('title', Input::previous('title'), array(
                    'label' => __('publications.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>


            </div>
            <div class="wrap">

                <?php
                if ($bookImageField) {
                    echo Form::text("extend[" . $bookImageField->key . "]", null, array(
                        'placeholder' => $bookImageField->label,
                        'autocomplete' => 'off',
                        'id' => 'extend_' . $bookImageField->key,
                        'class' => 'upload_filename hidden'
                    ));

                    echo "<p><img src='' alt='' class='file-image-preview file-image-preview-unloaded'></p>";
                    echo '<div class="upload_explain">Glissez une image ici pour définir l\'image de votre livre.</div>' .
                        '<div id="upload-file-progress"><progress value="0"></progress></div>';
                }

                echo Form::text("extend[" . $typeofpublication->key . "]", null, array(
                    'placeholder' => $typeofpublication->label,
                    'id' => "extend_" . $typeofpublication->key,
                    'value' => 'book',
                    'class' => 'hide'
                ));

                ?>


            </div>
            <div class="wrap">
                <p class="hidden">
                    <?php echo Form::text('slug', Input::previous('slug'), array('class' => 'hidden')); ?>
                </p>

                <p>
                    <?php echo Form::textarea('description', Input::previous('description'), array(
                        'label' => 'Description du livre',
                        'autofocus' => 'false'
                    )); ?>
                </p>

                <p>
                    <?php
                    if ($externallink) {
                        echo Form::text("extend[" . $externallink->key . "]", null, array(
                            'label' => $externallink->label,
                            'autocomplete' => 'off',
                            'id' => 'extend_' . $externallink->key
                        ));
                    }
                    ?>
                </p>
                <?php
                echo addTargetLanguageSelect($targetLanguage);
                ?>
                <p>
                    <label><?php echo __('publications.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status')); ?>
                    <em><?php echo __('publications.status_explain'); ?></em>
                </p>


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