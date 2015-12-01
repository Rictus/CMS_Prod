<?php echo $header; ?>

    <hgroup class="wrap">
        <h1><?php echo __('blog.blog'); ?></h1>
        <?php if ($posts->count): ?>
            <nav>
                <?php echo Html::link('admin/blog/add', __('blog.create_post'), array('class' => 'btn')); ?>
            </nav>
        <?php endif; ?>
    </hgroup>

    <section class="wrap">
        <?php echo $messages; ?>

    </section>

<?php echo $footer; ?>