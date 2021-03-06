<?php echo $header;
if (!$variableInfo) {
    echo "This variable isn't defined.<br>";
    var_dump($variableInfo);
    die();
}
?>

    <form method="post" action="<?php echo Uri::to('admin/accueil/editInfo/' . $variableInfo->key); ?>"
          enctype="multipart/form-data"
          novalidate>
        <input name="token" type="hidden" value="<?php echo $token; ?>">
        <fieldset class="header">
            <div class="wrap">
                <?php echo $messages; ?>
            </div>
        </fieldset>

        <fieldset class="main">
            <div class="wrap split">
                <?php
                switch ($variableInfo->key) {
                    case 'custom_introfirstpart':
                    case 'custom_introsecondpart':
                    case 'custom_introthirdpart':
                    case 'custom_introfirstpart_en':
                    case 'custom_introsecondpart_en':
                    case 'custom_introthirdpart_en':
                        echo Form::textarea('value', $variableInfo->value, array(
                            'class' => 'ckeditorgo'
                        ));
                        break;
                    case 'custom_address1':
                    case 'custom_address1_en':
                        $label = "Adresse partie 1";
                        echo Form::text('value', $variableInfo->value, array(
                            'label' => $label
                        ));
                        break;
                    case 'custom_address2':
                    case 'custom_address2_en':
                        $label = "Adresse partie 2";
                        echo Form::text('value', $variableInfo->value, array(
                            'label' => $label
                        ));
                        break;
                    case 'custom_mail':
                    case 'custom_mail_en':
                        $label = "Adresse email de contact";
                        echo Form::text('value', $variableInfo->value, array(
                            'label' => $label
                        ));
                        break;
                    case 'custom_telnumber':
                    case 'custom_telnumber_en':
                        $label = "Numéro de téléphone";
                        echo Form::text('value', $variableInfo->value, array(
                            'label' => $label
                        ));
                        break;
                    default:
//                        var_dump($variableInfo);
                        break;
                }
                ?>
                <aside class="buttons">
                    <?php echo Form::button(__('global.save'), array(
                        'type' => 'submit',
                        'class' => 'btn'
                    )); ?>
                </aside>
            </div>
        </fieldset>
    </form>
<?php
addScriptTag('anchor/views/assets/js/text-resize.js');
addScriptTag('anchor/views/assets/js/ckeditor/ckeditor.js');
addScriptTag('anchor/views/assets/js/ckeditor_init.js');
?>
<?php echo $footer; ?>