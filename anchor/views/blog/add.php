<?php echo $header;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'targetlanguage':
            $targetLanguage = $field;
            break;
        default:
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/blog/add'); ?>" enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main split">
            <div class="wrap">

                <?php echo Form::text('title', Input::previous('title'), array(
                    'label' => __('posts.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>
                <?php echo Form::textarea('html', Input::previous('html'), array(
                    'placeholder' => __('posts.content_explain'),
                    'class' => 'ckeditorgo'
                )); ?>

                <?php echo $editor; ?>
            </div>
            <div class="wrap">
                <?php
                echo addTargetLanguageSelect($targetLanguage);
                ?>
                <p>
                    <label><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status')); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
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