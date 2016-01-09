<?php echo $header; ?>
    <hgroup class="wrap">
        <?php echo $messages; ?>
    </hgroup>
    <section class="wrap">
        <hgroup class="wrap">
            <h1>Accroche de votre site</h1>
            <nav>
                <!--            --><?php //echo Html::link('admin/accueil/addCatch', __('accueil.create_catch'), array('class' => 'btn')); ?>
            </nav>
        </hgroup>

        <ul class="main list">
            <li>
                <a href="<?php echo Uri::to('admin/accueil/editCatch/' . $accroche->id); ?>">
                    <strong><?php echo $accroche->catchphrase; ?></strong>
                    <img width=auto height=100 src="/content/<?php echo $accroche->catchimage; ?>" alt="">
                </a>
            </li>
        </ul>
    </section>

    <section class="wrap">
        <hgroup class="wrap">
            <h1>Introduction de votre site</h1>
            <nav>

            </nav>
        </hgroup>
        <ul class="main list">
            <?php
            $introParts = ['custom_introfirstpart', 'custom_introsecondpart', 'custom_introthirdpart'];
            foreach ($introParts as $part) {
                echo "<li>" .
                    "<a href='" . Uri::to('admin/accueil/editInfo/' . $part) . "'>" .
                    "<strong>" . Config::meta($part) . "</strong>" .
                    "</a>" .
                    "</li>";
            }
            ?>
        </ul>
    </section>


    <section class="wrap">
        <hgroup class="wrap">
            <h1>Vos informations</h1>
            <nav>

            </nav>
        </hgroup>
        <ul class="main list">
            <?php
            $introParts = ['custom_address1', 'custom_address2', 'custom_mail', 'custom_telnumber'];
            foreach ($introParts as $part) {
                echo "<li>" .
                    "<a href='" . Uri::to('admin/accueil/editInfo/' . $part) . "'>" .
                    "<strong>" . strip_tags(Config::meta($part)) . "</strong>" .
                    "</a>" .
                    "</li>";
            }
            ?>
        </ul>
    </section>

    <section class="wrap">
        <hgroup class="wrap">
            <h1>Votre biographie</h1>
            <nav>
                <!--            --><?php //echo Html::link('admin/accueil/addBio', __('accueil.create_bio'), array('class' => 'btn')); ?>
            </nav>
        </hgroup>
        <ul class="main list">
            <li>
                <a href="<?php echo Uri::to('admin/accueil/editBio'); ?>">
                    <img width=auto height=100 class="leftSideImg" src="/content/<?php echo $bioimage; ?>" alt="">
                    <strong><?php echo explode(".", $biofirstpart)[0];?></strong>
                    <strong><?php echo explode(".", $biosecondpart)[0];?></strong>
                    <strong><?php echo explode(".", $biothirdpart)[0];?></strong>
                </a>
            </li>
        </ul>
    </section>

    <section class="wrap">
        <hgroup class="wrap">
            <h1>Votre équipe</h1>
            <nav>
                <?php echo Html::link('admin/accueil/addTeamMember', __('accueil.create_teamMember'), array('class' => 'btn')); ?>
            </nav>
        </hgroup>
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
    </section>

<?php echo $footer; ?>