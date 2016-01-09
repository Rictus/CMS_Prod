<?php echo $header; ?>
<?php
$books = [];
$textPublications = [];
$erroredPublications = [];
foreach ($posts->results as $post) {
    if ($post->typeofpublication == 'book') {
        $books[] = $post;
    } else if ($post->typeofpublication == 'textpublication') {
        $textPublications[] = $post;
        $post->customdate = DateTime::createFromFormat('d/m/Y', $post->customdate);
        if ($post->customdate)
            $post->customdate = $post->customdate->format('Y-m-d H:i:s');
        else
            $post->customdate = false;

        $post->publicofpublication_text = $post->publicofpublication == 'public' ? 'Grand public' : 'Scientifique';
    } else {
        $erroredPublications[] = $post;
    }
}

//echo "<h1>Books : </h1><p>".count($books)."</p>";
//echo "<h1>Texts : </h1><p>".count($textPublications)."</p>";
//echo "<h1>Errors : </h1><p>".count($erroredPublications)."</p>";

?>
    <hgroup class="wrap">
        <?php echo $messages; ?>
        <nav>
            <?php echo Html::link('admin/publications/addPublication', __('publications.create_publication'), array('class' => 'btn')); ?>
            <?php echo Html::link('admin/publications/addBook', __('publications.create_book'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>


    <hgroup class="wrap">
        <h1>Vos livres</h1>
        <section class="wrap">
            <?php if ($posts->count): ?>
                <ul class="main list booksList">
                    <?php foreach ($books as $post): ?>
                        <li>
                            <a href="<?php echo Uri::to('admin/publications/editBook/' . $post->id); ?>">
                                <strong><?php echo $post->title; ?></strong>
                                <img width=auto height=100 src="/content/<?php echo $post->bookimage; ?>" alt="">

                                <p><b>Lien vers ce livre : </b><?php echo $post->externallink; ?></p>

                                <p><?php echo strip_tags($post->description); ?></p>
                            <span>
                                <time><?php echo Date::format($post->created); ?></time>

                                <em class="status <?php echo $post->status; ?>"
                                    title="<?php echo __('global.' . $post->status); ?>">
                                    <?php echo __('global.' . $post->status); ?>
                                </em>
                            </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <aside class="paging"><?php echo $posts->links(); ?></aside>


        </section>
    </hgroup>


    <hgroup class="wrap">
        <h1>Vos publications texte</h1>
        <section class="wrap">
            <?php if ($posts->count): ?>
                <ul class="main list">
                    <?php foreach ($textPublications as $publication): ?>
                        <li>
                            <a href="<?php echo Uri::to('admin/publications/editPublication/' . $publication->id); ?>">
                                <p><?php echo strip_tags($publication->description); ?></p>
                                <p>Publication <?php echo $publication->publicofpublication_text;?></p>
                                <p><b>Lien vers ce livre : </b><?php echo $post->externallink; ?></p>
                            <span>
                                <time><b>Date de création : </b><?php echo Date::format($publication->created); ?>
                                </time>
                            </span>
                                <br>
                            <span>
                                <time><b>Date de publication officielle : </b><?php
                                    echo $publication->customdate ? Date::format($publication->customdate) : ""; ?>
                                </time>
                                <em class="status <?php echo $publication->status; ?>"
                                    title="<?php echo __('global.' . $publication->status); ?>">
                                    <?php echo __('global.' . $publication->status); ?>
                                </em>
                            </span>
                            </a>
                        </li>

                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <aside class="paging"><?php echo $posts->links(); ?></aside>
        </section>
    </hgroup>
<?php echo $footer; ?>