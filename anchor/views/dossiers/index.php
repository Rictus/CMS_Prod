<?php echo $header; ?>

    <hgroup class="wrap">
        <h1><?php echo __('dossiers.dossiers'); ?></h1>
        <?php if ($posts->count): ?>
            <nav>
                <?php echo Html::link('admin/dossiers/add', __('dossiers.create_post'), array('class' => 'btn')); ?>
            </nav>
        <?php endif; ?>
    </hgroup>

    <section class="wrap">
        <?php echo $messages; ?>


        <nav class="sidebar">
            <?php
            $lang = 'fr';
            echo Html::link('admin/dossiers', __('global.all'));
            echo Html::link('admin/fr/dossiers/', 'Français', array(
                'class' => $lang == 'fr' ? 'active' : ''
            ));
            echo Html::link('admin/en/dossiers/', 'Anglais', array(
                'class' => $lang == 'en' ? 'active' : ''
            ));
            ?>
        </nav>

        <?php if ($posts->count): ?>
            <ul class="main list">
                <?php foreach ($posts->results as $article):
                    ?>

                    <li>
                        <a href="<?php echo Uri::to('admin/dossiers/edit/' . $article->id); ?>">
                            <strong><?php echo $article->title; ?></strong>
                            <strong><?php echo $article->targetlanguage == "fr" ? "Français" : "Anglais"; ?></strong>
				<span>
					<time><?php echo Date::format($article->created); ?></time>

					<em class="status <?php echo $article->status; ?>"
                        title="<?php echo __('global.' . $article->status); ?>">
                        <?php echo __('global.' . $article->status); ?>
                    </em>
				</span>

                            <p><?php echo strip_tags($article->description); ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <aside class="paging"><?php echo $posts->links(); ?></aside>

        <?php else: ?>

            <p class="empty posts">
                <span class="icon"></span>
                <?php echo __('dossiers.noposts_desc'); ?><br>
                <?php echo Html::link('admin/dossiers/add', __('dossiers.create_post'), array('class' => 'btn')); ?>
            </p>

        <?php endif; ?>
    </section>

<?php echo $footer; ?>