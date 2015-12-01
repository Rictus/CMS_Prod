<?php echo $header; ?>

    <hgroup class="wrap">
        <h1><?php echo __('publications.publications'); ?></h1>
<!--        --><?php //if ($posts->count): ?>

            <nav>
                <?php echo Html::link('admin/publications/addPublication', __('publications.create_publication'), array('class' => 'btn')); ?>
                <?php echo Html::link('admin/publications/addBook', __('publications.create_book'), array('class' => 'btn')); ?>
            </nav>
<!--        --><?php //endif; ?>
    </hgroup>

    <section class="wrap">
        <?php echo $messages; ?>



    </section>

<?php echo $footer; ?>