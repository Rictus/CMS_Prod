<?php echo $header; ?>
<?php
$typeofpublication = false;
$externallink = false;
$customdate = false;
$publicofpublication = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'externallink':
            $externallink = $field;
            break;
        case 'typeofpublication':
            //Say if it's a book or a text publication. Normally book here
            $typeofpublication = $field;
            break;
        case 'customdate':
            $customdate = $field;
            break;
        case 'publicofpublication':
            $publicofpublication = $field;
            break;
        default;
            //We do not get other extends
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/publications/addPublication'); ?>"
          enctype="multipart/form-data"
          novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="meta split">
            <div class="wrap">

                <?php
                echo Form::text("extend[" . $typeofpublication->key . "]", null, array(
                    'placeholder' => $typeofpublication->label,
                    'id' => "extend_" . $typeofpublication->key,
                    'value' => 'textpublication',
                    'class' => 'hide'
                ));

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
                    if ($publicofpublication) {
                        echo "<label for='extend_" . $publicofpublication->key . "'>" . $publicofpublication->label . "</label>";
                        echo Form::select("extend[" . $publicofpublication->key . "]", array(
                            'scientific' => 'Scientifique',
                            'public' => 'Grand public'
                        ), 'public');
                    }
                    ?>

                </p>

                <p>
                    <?php
                    if ($customdate) {
                        echo "<p><label for='extend_" . $customdate->key . "'>" . $customdate->label . "</label>" . Extend::html($customdate, 'date') . "</p>";
                    }
                    ?>
                </p>

                <p>
                    <?php
                    if ($externallink) {
                        echo Form::text("extend[" . $externallink->key . "]", null, array(
                            'placeholder' => $externallink->label,
                            'autocomplete' => 'off',
                            'id' => 'extend_' . $externallink->key
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
<?php

addScriptTag('anchor/views/assets/js/jquery-2.1.4.min.js');
addScriptTag('anchor/views/assets/js/slug.js');
addScriptTag('anchor/views/assets/js/text-resize.js');
addScriptTag('anchor/views/assets/js/ckeditor/ckeditor.js');
addScriptTag('anchor/views/assets/js/ckeditor_init.js');
addScriptTag('anchor/views/assets/js/bootstrap.min.js');
addScriptTag('anchor/views/assets/js/bootstrap-datepicker.min.js');

?>
    <script>
        $('.date').datepicker({
            format: "dd/mm/yyyy",
            weekStart: 1,
            clearBtn: true,
            language: "fr",
            todayHighlight: true
        });
    </script>

<?php echo $footer; ?>