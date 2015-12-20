<?php echo $header;
$teamMemberName = false;
$teamMemberJob = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'teammembername':
            $teamMemberName = $field;
            break;
        case 'teammemberjob':
            $teamMemberJob = $field;
            break;
        default:
            break;
    }
}
?>
    <form method="post" action="<?php echo Uri::to('admin/accueil/editTeamMember/' . $member->id); ?>"
          enctype="multipart/form-data" novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">
        <fieldset class= "header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main">
            <?php
            if ($teamMemberName) {
                echo Form::text('extend[' . $teamMemberName->key . ']', $teamMemberName->value->text, array(
                    'placeholder' => $teamMemberName->label,
                    'id' => "extend_" . $teamMemberName->key
                ));
            }
            if ($teamMemberJob) {
                echo Form::text('extend[' . $teamMemberJob->key . ']', $teamMemberJob->value->text, array(
                    'placeholder' => $teamMemberJob->label,
                    'id' => "extend_" . $teamMemberJob->key
                ));
            }
            ?>
        </fieldset>

        <fieldset class="meta split">
            <div class="wrap">

                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>

                    <?php echo Html::link('admin/accueil/deleteTeamMember/' . $member->id, __('global.delete'), array(
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