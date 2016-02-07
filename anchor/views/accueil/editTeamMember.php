<?php echo $header;
$teamMemberName = false;
$teamMemberJob = false;
$teamMemberJob_en = false;
foreach ($fields as $field) {
    switch ($field->key) {
        case 'teammembername':
            $teamMemberName = $field;
            break;
        case 'teammemberjob':
            $teamMemberJob = $field;
            break;
        case 'teammemberjob_en':
            $teamMemberJob_en = $field;
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
            <div class="wrap split">
                <?php
                if ($teamMemberName) {
                    echo Form::text('extend[' . $teamMemberName->key . ']', isset($teamMemberName->value->text) ? $teamMemberName->value->text : "", array(
                        'label' => $teamMemberName->label,
                        'id' => "extend_" . $teamMemberName->key
                    ));
                }
                if ($teamMemberJob) {
                    echo Form::text('extend[' . $teamMemberJob->key . ']', isset($teamMemberJob->value->text) ? $teamMemberJob->value->text : "", array(
                        'label' => $teamMemberJob->label,
                        'id' => "extend_" . $teamMemberJob->key
                    ));
                }
                if ($teamMemberJob_en) {
                    echo Form::text('extend[' . $teamMemberJob_en->key . ']', isset($teamMemberJob_en->value->text) ? $teamMemberJob_en->value->text : "", array(
                        'label' => $teamMemberJob_en->label,
                        'id' => "extend_" . $teamMemberJob_en->key
                    ));
                }
                ?>
            </div>
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