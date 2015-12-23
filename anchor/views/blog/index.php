<?php echo $header; ?>

    <hgroup class="wrap">
        <h1><?php echo __('blog.blog'); ?></h1>
        <nav>
            <?php echo Html::link('admin/blog/add', __('blog.create_post'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>

    <section class="wrap">
        <?php echo $messages; ?>

        <?php if ($posts->count): ?>
            <ul class="main list">
                <?php foreach ($posts->results as $article): ?>
                    <li>
                        <a href="<?php echo Uri::to('admin/blog/edit/' . $article->id); ?>">
                            <strong><?php echo $article->title; ?></strong>
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

    </section>

<?php echo $footer; ?>