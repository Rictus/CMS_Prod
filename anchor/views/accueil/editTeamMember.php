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
        <fieldset class="header">
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