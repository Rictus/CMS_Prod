<?php echo $header;

$customdate = false;
$typeofpublication = false;
$externallink = false;
$publicofpublication = false;
foreach ($fields as $field): ?>
    <?php switch ($field->key) {
        case 'externallink':
            $externallink = $field;
            break;
        case 'typeofpublication':
            $typeofpublication = $field;
            break;
        case 'customdate':
            $customdate = $field;
            break;
        case 'publicofpublication':
            $publicofpublication = $field;
            break;
    }
    ?>
<?php endforeach; ?>
    <form method="post" action="<?php echo Uri::to('admin/publications/editPublication/' . $publication->id); ?>"
          enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="meta split">
            <div class="wrap">
                <p class="hidden">
                    <label><?php echo __('posts.slug'); ?>:</label>
                    <?php echo Form::text('slug', Input::previous('slug', $publication->slug)); ?>
                    <em><?php echo __('posts.slug_explain'); ?></em>
                </p>

                <p>
                    <label for="description"><?php echo __('posts.description'); ?>:</label>
                    <?php echo Form::textarea('description', Input::previous('description', $publication->description)); ?>
                    <em><?php echo __('posts.description_explain'); ?></em>
                </p>


                <p>

                    <?php
                    if ($publicofpublication) {
                        echo "<label for='extend_" . $publicofpublication->key . "'>" . $publicofpublication->label . "</label>";
                        echo Form::select("extend[" . $publicofpublication->key . "]", array(
                            'scientific' => 'Scientifique',
                            'public' => 'Grand public'
                        ), $publicofpublication->value->text);
                    }
                    ?>

                </p>



                <p>
                    <?php
                    if ($customdate) {
                        echo Form::text("extend[" . $customdate->key . "]", $customdate->value->text, array(
                            'class' => 'date'
                        ));
                    }


                    echo Form::text("extend[" . $typeofpublication->key . "]", null, array(
                        'placeholder' => $typeofpublication->label,
                        'id' => "extend_" . $typeofpublication->key,
                        'value' => 'textpublication',
                        'class' => 'hide'
                    ));


                    echo "<p><label for='extend_" . $externallink->key . "'>" . $externallink->label . "</label>" . Extend::html($externallink) . "</p>";
                    ?>
                </p>


                <p>
                    <label for="status"><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status', $publication->status)); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
                </p>


                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>

                    <?php echo Html::link('admin/publications/deletePublication/' . $publication->id, __('global.delete'), array(
                        'class' => 'btn delete red'
                    )); ?>
                </aside>
            </div>
        </fieldset>
    </form>
<?php
addScriptTag('anchor/views/assets/js/slug.js');
addScriptTag('anchor/views/assets/js/text-resize.js');
addScriptTag('anchor/views/assets/js/ckeditor/ckeditor.js');
addScriptTag('anchor/views/assets/js/jquery-2.1.4.min.js');
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