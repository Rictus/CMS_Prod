<?php echo $header; ?>
    <form method="post" action="<?php echo Uri::to('admin/dossiers/edit/' . $article->id); ?>"
          enctype="multipart/form-data" novalidate>

        <input name="token" type="hidden" value="<?php echo $token; ?>">

        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main">
            <div class="wrap">
                <?php

                $pattern = "(^\{.*?\})";
                $articleTitle = Input::previous('title', $article->title);
                $typeofproblem = array();
                preg_match($pattern, $articleTitle, $typeofproblem);
                $typeofproblem = count($typeofproblem) > 0 ? $typeofproblem[0] : false;
                $articleTitle = preg_replace($pattern, "", $articleTitle);

                echo Form::text('title', Input::previous('title', $articleTitle), array(
                    'placeholder' => __('dossiers.title'),
                    'autocomplete' => 'off',
                    'autofocus' => 'true'
                )); ?>
                <?php echo Form::textarea('html', Input::previous('html', $article->html), array(
                    'placeholder' => __('dossiers.content_explain'),
                    'class' => 'ckeditorgo'
                )); ?>

            </div>
        </fieldset>

        <fieldset class="meta split">
            <div class="wrap">
                <p class="hidden">
                    <label><?php echo __('dossiers.slug'); ?>:</label>
                    <?php echo Form::text('slug', Input::previous('slug', $article->slug)); ?>
                    <em><?php echo __('dossiers.slug_explain'); ?></em>
                </p>

                <!--<p>
                    <label for="description"><?php /*echo __('dossiers.description'); */ ?>:</label>
                    <?php /*echo Form::textarea('description', Input::previous('description', $article->description)); */ ?>
                    <em><?php /*echo __('dossiers.description_explain'); */ ?></em>
                </p>
 -->
                <p>
                    <label for="status"><?php echo __('posts.status'); ?>:</label>
                    <?php echo Form::select('status', $statuses, Input::previous('status', $article->status)); ?>
                    <em><?php echo __('posts.status_explain'); ?></em>
                </p>
                <!--
                //Don't need to change the cateogy if it doesn't change
                <p>
                    <label for="category"><?php /*echo __('dossiers.category'); */ ?>:</label>
                    <?php /*echo Form::select('category', $categories, Input::previous('category', $article->category)); */ ?>
                    <em><?php /*echo __('dossiers.category_explain'); */ ?></em>
                </p>-->

                <!--<p>
                    <label><?php /*echo __('dossiers.allow_comments'); */ ?>:</label>
                    <?php /*echo Form::checkbox('comments', 1, Input::previous('comments', $article->comments) == 1); */ ?>
                    <em><?php /*echo __('dossiers.allow_comments_explain'); */ ?></em>
                </p>

                <p>
                    <label><?php /*echo __('dossiers.custom_css'); */ ?>:</label>
                    <?php /*echo Form::textarea('css', Input::previous('css', $article->css)); */ ?>
                    <em><?php /*echo __('dossiers.custom_css_explain'); */ ?></em>
                </p>

                <p>
                    <label for="js"><?php /*echo __('dossiers.custom_js'); */ ?>:</label>
                    <?php /*echo Form::textarea('js', Input::previous('js', $article->js)); */ ?>
                    <em><?php /*echo __('dossiers.custom_js_explain'); */ ?></em>
                </p>-->
                <?php foreach ($fields as $field): ?>
                    <p>
                        <?php if ($field->key == 'typeofproblem'): ?>
                            <label for="extend_<?php echo $field->key; ?>">
                                <?php echo $field->label; ?>:
                            </label>
                            <select id="extend_typeofproblem" name="extend[typeofproblem]">
                                <?php
                                echo "extracted : " . $typeofproblem;
                                echo "title : " . $articleTitle;
                                if ($typeofproblem && $typeofproblem == "{masculin}") {
                                    echo '<option value="masculin" selected>Masculin</option>';
                                } else if ($typeofproblem && $typeofproblem == "{feminin}") {
                                    echo '<option value="masculin">Masculin</option>';
                                    echo '<option value="feminin" selected>Feminin</option>';
                                } else {
                                    echo '<option value="masculin">Masculin</option>';
                                    echo '<option value="feminin">Feminin</option>';
                                    echo '<option value="indifferent" selected>Indifferent</option>';
                                }
                                ?>
                            </select>
                        <?php else: ?>
                            <!--We do not show other extend fields-->
                            <!-- <label for="extend_<?php /*echo $field->key; */ ?>">
                            <?php /*echo $field->label; */ ?>:
                            </label>--><?php /*echo Extend::html($field); */ ?>
                        <?php endif; ?>
                    </p>
                <?php endforeach; ?>

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

    <!--    <script src="--><?php //echo asset('anchor/views/assets/js/dragdrop.js'); ?><!--"></script>-->
    <!--    <script src="--><?php //echo asset('anchor/views/assets/js/upload-fields.js'); ?><!--"></script>-->
    <script src="<?php echo asset('anchor/views/assets/js/slug.js'); ?>"></script>
    <script src="<?php echo asset('anchor/views/assets/js/text-resize.js'); ?>"></script>
    <script src="<?php echo asset('anchor/views/assets/js/ckeditor/ckeditor.js'); ?>"></script>
    <!--<script src="--><?php //echo asset('anchor/views/assets/js/editor.js'); ?><!--"></script>-->
    <script src="<?php echo asset('anchor/views/assets/js/ckeditor_init.js'); ?>"></script>

    <script>
        //	$('textarea[name=html]').editor();
    </script>

<?php echo $footer; ?>