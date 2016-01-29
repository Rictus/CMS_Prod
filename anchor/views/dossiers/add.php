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
    <form method="post" action="<?php echo Uri::to('admin/dossiers/add'); ?>" enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main">
            <div class="wrap split">

                <?php

                $articleTitle = Input::previous('title');

                echo Form::text('title', $articleTitle, array(
                    'label' => __('dossiers.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>
                <?php echo Form::textarea('html', Input::previous('html'), array(
                    'placeholder' => __('dossiers.content_explain'),
                    'class' => 'ckeditorgo'
                )); ?>

            </div>
            <div class="wrap split">
                <p class="hidden">
                    <?php echo Form::text('slug', Input::previous('slug'), array('class' => 'hidden')); ?>
                </p>
                <?php echo addTargetLanguageSelect($targetLanguage); ?>
                <p>
                    <label><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status')); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
                </p>

                <?php foreach ($fields as $field): ?>
                    <p>
                        <?php if ($field->key == 'typeofproblem'): ?>
                            <label for="extend_<?php echo $field->key; ?>">
                                <?php echo $field->label; ?>:
                            </label>
                            <select id="extend_typeofproblem" name="extend[typeofproblem]">
                                <option value="masculin">Masculin</option>
                                <option value="feminin">Féminin</option>
                                <option value="indifferent" selected>Indifferent</option>
                            </select>
                        <?php else: ?>

                        <?php endif; ?>
                    </p>
                <?php endforeach; ?>
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