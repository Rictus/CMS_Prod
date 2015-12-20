<?php echo $header; ?>
    <hgroup class="wrap">
        <h1><?php echo __('accueil.accueil'); ?></h1>
    </hgroup>

    <hgroup class="wrap">
        <h1>Votre équipe</h1>
        <nav>
            <?php echo Html::link('admin/accueil/addTeamMember', __('accueil.create_teamMember'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>
    <section class="wrap">
        <?php echo $messages; ?>
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