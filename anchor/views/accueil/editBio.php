<?php echo $header;
$biofirstpart_en = false;
$biosecondpart_en = false;
$biothirdpart_en = false;
$bioimage_en = false;

$biofirstpart = false;
$biosecondpart = false;
$biothirdpart = false;
$bioimage = false;
foreach ($page_fields as $key => $field) {
    switch ($key) {
        case 'biofirstpart_en':
            $biofirstpart_en = $field;
            break;
        case 'biosecondpart_en':
            $biosecondpart_en = $field;
            break;
        case 'biothirdpart_en':
            $biothirdpart_en = $field;
            break;
        case 'bioimage_en':
            $bioimage_en = $field;
            break;
        case 'biofirstpart':
            $biofirstpart = $field;
            break;
        case 'biosecondpart':
            $biosecondpart = $field;
            break;
        case 'biothirdpart':
            $biothirdpart = $field;
            break;
        case 'bioimage':
            $bioimage = $field;
            break;
        default:
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/accueil/editBio'); ?>" enctype="multipart/form-data"
          novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">
        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>


        <fieldset class="main">
            <div class="wrap">
                <hgroup class="wrap">
                    <h1 id="fr">Français</h1>
                </hgroup>
                <?php
                $r = [$biofirstpart_en, $biosecondpart_en, $biothirdpart_en, $bioimage_en];
                foreach ($r as $f) {
                    $v = array_key_exists('text', $f->value) ? $f->value->text : "";
                    echo "<input type='text' name='extend[" . $f->key . "]' class='hidden hide' value='" . $v . "'>";
                }
                if ($bioimage) {
                    echo Form::text("extend[" . $bioimage->key . "]", $bioimage->value->text, array(
                        'placeholder' => $bioimage->label,
                        'autocomplete' => 'off',
                        'id' => 'extend_' . $bioimage->key,
                        'class' => 'upload_filename hide'
                    ));
                    echo "<p><img src='/content/" . $bioimage->value->text . "' alt='' class='file-image-preview'></p>";
                    echo '<div class="upload_explain">Glissez une image ici pour définir l\'image de votre biographie.</div>' .
                        '<div id="upload-file-progress"><progress value="0"></progress></div>';
                }
                ?>
                <?php
                if ($biofirstpart) {
                    echo Form::textarea('extend[' . $biofirstpart->key . ']', isset($biofirstpart->value->text) ? $biofirstpart->value->text : "", array(
                        'placeholder' => $biofirstpart->label,
                        'id' => "extend_" . $biofirstpart->key,
                        'rows' => '5',
                        'style' => 'height:auto!important;'
                    ));
                }
                if ($biosecondpart) {
                    echo Form::textarea('extend[' . $biosecondpart->key . ']', isset($biosecondpart->value->text) ? $biosecondpart->value->text : "", array(
                        'placeholder' => $biosecondpart->label,
                        'id' => "extend_" . $biosecondpart->key,
                        'cols' => 25,
                        'style' => 'display: inline-block;width:50%;'
                    ), false);
                }
                if ($biothirdpart) {
                    echo Form::textarea('extend[' . $biothirdpart->key . ']', isset($biothirdpart->value->text) ? $biothirdpart->value->text : "", array(
                        'placeholder' => $biothirdpart->label,
                        'id' => "extend_" . $biothirdpart->key,
                        'cols' => 25,
                        'style' => 'display: inline-block;width:50%;'
                    ), false);
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