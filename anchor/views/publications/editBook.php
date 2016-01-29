<?php echo $header;
$bookimage = false;
$externallink = false;
$typeofpublication = false;
$targetLanguage = false;
foreach ($fields as $field): ?>
    <?php switch ($field->key) {
        case 'bookimage':
            $bookimage = $field;
            break;
        case 'externallink':
            $externallink = $field;
            break;
        case 'typeofpublication':
            $typeofpublication = $field;
            break;
        case 'targetlanguage':
            $targetLanguage = $field;
            break;
    }
    ?>
<?php endforeach; ?>
    <form method="post" action="<?php echo Uri::to('admin/publications/editBook/' . $book->id); ?>"
          enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main split">
            <div class="wrap">
                <?php echo Form::text('title', Input::previous('title', $book->title), array(
                    'label' => __('posts.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>
            </div>
            <div class="wrap">
                <p class="hidden">
                    <?php echo Form::text('slug', Input::previous('slug', $book->slug), array('class' => 'hidden')); ?>
                </p>
                <?php

                echo '<div class="upload_explain">Glissez une image ici pour remplacer l\'image de votre livre.</div>' .
                    '<div id="upload-file-progress"><progress value="0"></progress></div>';
                echo "<img class='file-image-preview' src='/content/" . $bookimage->value->text . "'>";
                echo Form::text("extend[" . $bookimage->key . "]", $bookimage->value->text, array(
                    'placeholder' => $bookimage->label,
                    'autocomplete' => 'off',
                    'id' => 'extend_' . $bookimage->key,
                    'class' => 'upload_filename hide'
                ));
                echo Form::text("extend[" . $typeofpublication->key . "]", null, array(
                    'placeholder' => $typeofpublication->label,
                    'id' => "extend_" . $typeofpublication->key,
                    'value' => 'book',
                    'class' => 'hide'
                ));
                ?>
                <p>
                    <?php echo Form::textarea('description', Input::previous('description', $book->description), array(
                        'label' => 'Description du livre',
                        'autofocus' => 'false'
                    )); ?>
                    <em><?php echo __('posts.description_explain'); ?></em>
                </p>
                <?php echo "<p><label for='extend_" . $externallink->key . "'>" . $externallink->label . "</label>" . Extend::html($externallink) . "</p>"; ?>
                <?php
                echo addTargetLanguageSelect($targetLanguage);
                ?>
                <p>
                    <label for="status"><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status', $book->status)); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
                </p>


                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>

                    <?php echo Html::link('admin/publications/deleteBook/' . $book->id, __('global.delete'), array(
                        'class' => 'btn delete red'
                    )); ?>
                </aside>
            </div>
        </fieldset>
    </form>
<?php
addScriptTag('anchor/views/assets/js/dragdrop.js');
addScriptTag('anchor/views/assets/js/upload-fields.js');
addScriptTag('anchor/views/assets/js/slug.js');
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