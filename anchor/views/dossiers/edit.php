<?php echo $header;
$typeofproblem = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'typeofproblem':
            $typeofproblem = $field;
            break;
        default: /*We do not show other extend fields*/
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/dossiers/edit/' . $article->id); ?>"
          enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main">
            <div class="wrap split">
                <?php

                $articleTitle = Input::previous('title', $article->title);

                echo Form::text('title', Input::previous('title', $articleTitle), array(
                    'label' => __('dossiers.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>
                <?php echo Form::textarea('html', Input::previous('html', $article->html), array(
                    'placeholder' => __('dossiers.content_explain'),
                    'class' => 'ckeditorgo'
                )); ?>

            </div>
            <div class="wrap split">
                <p class="hidden">
                    <?php echo Form::text('slug', Input::previous('slug', $article->slug), array('class' => 'hidden')); ?>
                </p>

                <p>
                    <label for="status"><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status', $article->status)); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
                </p>

                <p>
                    <?php if ($typeofproblem): ?>
                        <label for="extend_<?php echo $typeofproblem->key; ?>">
                            <?php echo $typeofproblem->label; ?>:
                        </label>
                        <select id="extend_typeofproblem" name="extend[typeofproblem]">
                            <?php
                            if ($typeofproblem->value->text == "masculin") { //Yeah i know this is shitty
                                echo '<option value="masculin" selected>Masculin</option>';
                                echo '<option value="feminin">Feminin</option>';
                                echo '<option value="indifferent" >Indifferent</option>';
                            } else if ($typeofproblem->value->text == "feminin") {
                                echo '<option value="masculin">Masculin</option>';
                                echo '<option value="feminin" selected>Feminin</option>';
                                echo '<option value="indifferent" >Indifferent</option>';
                            } else {
                                echo '<option value="masculin">Masculin</option>';
                                echo '<option value="feminin">Feminin</option>';
                                echo '<option value="indifferent" selected>Indifferent</option>';
                            }
                            ?>
                        </select>
                    <?php endif; ?>
                </p>

                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>

                    <?php echo Html::link('admin/dossiers/delete/' . $article->id, __('global.delete'), array(
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