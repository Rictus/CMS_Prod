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

    <form method="post" action="<?php echo Uri::to('admin/blog/edit/' . $post->id); ?>"
          enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main split">
            <div class="wrap">
                <?php echo Form::text('title', Input::previous('title', $post->title), array(
                    'label' => __('posts.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>
                <?php echo Form::textarea('html', Input::previous('html', $post->html), array(
                    'placeholder' => __('posts.content_explain'),
                    'class' => 'ckeditorgo'
                )); ?>

            </div>
            <div class="wrap">
               <?php
               echo addTargetLanguageSelect($targetLanguage);
               ?>

                <p>
                    <label><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status', $post->status), array('class' => '')); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
                </p>


                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>

                    <?php echo Html::link('admin/posts/delete/' . $post->id, __('global.delete'), array(
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
echo $footer;
?>