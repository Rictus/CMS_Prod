<?php echo $header; ?>
<?php
$bookImageField = false;
$externalLinkField = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'bookimage':
            //The process of uploading an image is done with js/ajax.
            //The uploaded filename is then store in a input[type=text]
            $bookImageField = $field;
            break;
        case 'externallink':
            $externalLinkField = $field;
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


        <fieldset class="main">
            <div class="wrap">

                <?php echo Form::text('title', Input::previous('title'), array(
                    'placeholder' => __('publications.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>


            </div>
        </fieldset>
        <fieldset class="meta split">
            <div class="wrap">

                <?php
                if ($bookImageField) {
                    echo Form::text("extend[" . $bookImageField->key . "]", null, array(
                        'placeholder' => $bookImageField->label,
                        'autocomplete' => 'off',
                        'id' => 'extend_' . $bookImageField->key,
                        'class' => 'upload_filename hide'
                    ));

                    echo "<p><img src='' alt='' class='file-image-preview'></p>";
                    echo '<div class="upload_explain">Glissez une image ici pour définir l\'image de votre livre.</div>' .
                        '<div id="upload-file-progress"><progress value="0"></progress></div>';
                }
                ?>

            </div>
        </fieldset>
        <fieldset class="meta split">
            <div class="wrap">
                <p class="hidden">
                    <label><?php echo __('publications.slug'); ?></label>
                    <?php echo Form::text('slug', Input::previous('slug')); ?>
                    <em><?php echo __('publications.slug_explain'); ?></em>
                </p>

                <p>
                    <?php echo Form::textarea('description', Input::previous('description'), array(
                        'placeholder' => __('publications.description_placeholder'),
                        'autofocus' => 'false'
                    )); ?>
                    <em><?php echo __('publications.description_explain'); ?></em>
                </p>

                <p>
                    <?php
                    if ($externalLinkField) {
                        echo Form::text("extend[" . $externalLinkField->key . "]", null, array(
                            'placeholder' => $externalLinkField->label,
                            'autocomplete' => 'off',
                            'id' => 'extend_' . $externalLinkField->key
                        ));
                    }
                    ?>
                </p>

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

    <script src="<?php echo asset('anchor/views/assets/js/slug.js'); ?>"></script>
    <script src="<?php echo asset('anchor/views/assets/js/dragdrop.js'); ?>"></script>
    <script>
        initDragdrop(function (url, filename) {
            $('.file-image-preview').attr('src', url).attr('value', url); //adding image to img element to display it
            $('.upload_explain').hide(); //Hiding explain, an upload has been done
            console.log(filename); //Displaying filename
            $('.upload_filename').attr("value", filename); //Init value of input text that should store filename
        });
    </script>
    <script src="<?php echo asset('anchor/views/assets/js/upload-fields.js'); ?>"></script>
    <script src="<?php echo asset('anchor/views/assets/js/text-resize.js'); ?>"></script>
    <script src="<?php echo asset('anchor/views/assets/js/ckeditor/ckeditor.js'); ?>"></script>
    <!--<script src="--><?php //echo asset('anchor/views/assets/js/editor.js'); ?><!--"></script>-->
    <script src="<?php echo asset('anchor/views/assets/js/ckeditor_init.js'); ?>"></script>

    <script>
        //	$('textarea[name=html]').editor();
    </script>

<?php echo $footer; ?>