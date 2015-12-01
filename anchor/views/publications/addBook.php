<?php echo $header; ?>

    <form method="post" action="<?php echo Uri::to('admin/publications/add'); ?>" enctype="multipart/form-data"
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
                <p class="hidden">
                    <label><?php echo __('publications.slug'); ?></label>
                    <?php echo Form::text('slug', Input::previous('slug')); ?>
                    <em><?php echo __('publications.slug_explain'); ?></em>
                </p>

                <p>
                    <?php echo Form::textarea('description', Input::previous('description'), array(
                        'placeholder' => __('publications.description_placeholder')
                    )); ?>
                    <em><?php echo __('publications.description_explain'); ?></em>
                </p>
                <?php foreach ($fields as $field): ?>
                    <?php switch ($field->key) {
                        case 'bookimage':
                            echo "<p><label for='extend_" . $field->key . "'>" . $field->label . "</label>" . Extend::html($field) . "</p>";
                            break;
                        case 'externallink':
                            echo Form::text("extend[".$field->key."]",null, array(
                                'placeholder' => $field->label,
                                'autocomplete' => 'off',
                                'id' => 'extend_' . $field->key
                            ));
                            break;
                        default: //do not show other extends
                            break;
                    }
                    ?>
                <?php endforeach; ?>


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
    <!--    <script src="--><?php //echo asset('anchor/views/assets/js/dragdrop.js'); ?><!--"></script>-->
    <!--    <script src="--><?php //echo asset('anchor/views/assets/js/upload-fields.js'); ?><!--"></script>-->
    <script src="<?php echo asset('anchor/views/assets/js/text-resize.js'); ?>"></script>
    <script src="<?php echo asset('anchor/views/assets/js/ckeditor/ckeditor.js'); ?>"></script>
    <!--<script src="--><?php //echo asset('anchor/views/assets/js/editor.js'); ?><!--"></script>-->
    <script src="<?php echo asset('anchor/views/assets/js/ckeditor_init.js'); ?>"></script>

    <script>
        //	$('textarea[name=html]').editor();
    </script>

<?php echo $footer; ?>