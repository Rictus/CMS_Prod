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
            <div class="wrap">
                <?php
                echo Form::text('value', $variableInfo->value, array());
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
?>
<?php echo $footer; ?>