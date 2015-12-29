<?php echo $header; ?>
    <hgroup class="wrap">

        <?php echo $messages; ?>
        <h1><?php echo __('accueil.accueil'); ?></h1>
    </hgroup>

    <hgroup class="wrap">
        <h1>Votre accroche</h1>
        <nav>
            <!--            --><?php //echo Html::link('admin/accueil/addCatch', __('accueil.create_catch'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>
    <section class="wrap">
        <ul class="main list">
            <li>
                <a href="<?php echo Uri::to('admin/accueil/editCatch/' . $accroche->id); ?>">
                    <strong><?php echo $accroche->catchphrase; ?></strong>
                    <img width=auto height=100 src="/content/<?php echo $accroche->catchimage; ?>" alt="">
                </a>
            </li>
        </ul>
    </section>

<?php
//$biopage = Registry::get('biopage');
//$bioimage = Registry::get('bioimage');
//$biofirstpart = Registry::get('biofirstpart');
//$biosecondpart = Registry::get('biosecondpart');
//$biothirdpart = Registry::get('biothirdpart');

?>
    <hgroup class="wrap">
        <h1>Votre biographie</h1>
        <nav>
            <?php echo Html::link('admin/accueil/addBio', __('accueil.create_bio'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>
    <section class="wrap">
        <ul class="main list">
            <li>
                <a href="<?php echo Uri::to('admin/accueil/editBio'); ?>">
                    <img width=auto height=100 src="/content/<?php echo $bioimage; ?>" alt="">
                    <strong><?php echo $biofirstpart; ?></strong>

                    <p><?php echo $biosecondpart; ?></p>
                    <p><?php echo $biothirdpart; ?></p>
                </a>
            </li>
        </ul>
    </section>


    <hgroup class="wrap">
        <h1>Votre équipe</h1>
        <nav>
            <?php echo Html::link('admin/accueil/addTeamMember', __('accueil.create_teamMember'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>
    <section class="wrap">
        <ul class="main list">
            <?php foreach ($team as $member): ?>
                <li>
                    <a href="<?php echo Uri::to('admin/accueil/editTeamMember/' . $member->id); ?>">
                        <strong><?php echo $member->teammembername; ?></strong>

                        <p>
                            <?php echo $member->teammemberjob; ?>
                        </p>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!--            <aside class="paging">--><?php //echo $posts->links(); ?><!--</aside>-->

    </section>

<?php echo $footer; ?>