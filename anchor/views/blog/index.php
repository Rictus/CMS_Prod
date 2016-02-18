<?php echo $header; ?>

    <hgroup class="wrap">
        <h1><?php echo __('blog.blog'); ?></h1>
        <nav>
            <?php echo Html::link('admin/blog/add', __('blog.create_post'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>

    <section class="wrap">
        <?php echo $messages; ?>

        <nav class="sidebar">
            <?php
            $lang = $choosenlanguage;
            echo Html::link('admin/blog/', __('global.all'), array(
                'class' => $lang == 'all' ? 'active' : ''
            ));
            echo Html::link('admin/blog/1/fr', 'Français', array(
                'class' => $lang == 'fr' ? 'active' : ''
            ));
            echo Html::link('admin/blog/1/en', 'Anglais', array(
                'class' => $lang == 'en' ? 'active' : ''
            ));
            ?>
        </nav>

        <?php if ($posts->count): ?>
            <ul class="main list">
                <?php foreach ($posts->results as $article): ?>
                    <li>
                        <a href="<?php echo Uri::to('admin/blog/edit/' . $article->id); ?>">
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
        <?php endif; ?>
        <aside class="paging"><?php echo $posts->links(); ?></aside>

    </section>

<?php echo $footer; ?>