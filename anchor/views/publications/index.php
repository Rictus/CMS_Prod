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
    } else {
        $erroredPublications[] = $post;
    }
}

//echo "<h1>Books : </h1><p>".var_dump($books)."</p>";
//echo "<h1>Texts : </h1><p>".var_dump($textPublications)."</p>";
//echo "<h1>Errors : </h1><p>".var_dump($erroredPublications)."</p>";

?>

    <hgroup class="wrap">
        <h1><?php echo __('publications.publications'); ?></h1>

        <nav>
            <?php echo Html::link('admin/publications/addPublication', __('publications.create_publication'), array('class' => 'btn')); ?>
            <?php echo Html::link('admin/publications/addBook', __('publications.create_book'), array('class' => 'btn')); ?>
        </nav>
    </hgroup>


    <section class="wrap">
        <?php echo $messages; ?>
        <!--//TODO WORKING HERE-->
        <!-- TODO Differencier livres et publciations texte -->

        <?php if ($posts->count): ?>
            <ul class="main list">
                <?php foreach ($books as $post): ?>
                    <!--                    Post Object ( [data] => Array (
                    [id] => 57
                    [title] => test type of publication
                    [slug] => test-type-of-publication
                    [description] => test
                    [html] =>
                    [css] =>
                    [js] =>
                    [created] => 2015-12-09 22:01:27
                    [author] => 1
                    [category] => 4
                    [status] => published
                    [comments] => 0
                    [typeofpublication] => book ) )
                    [bookimage] => book ) )
                    [externallink] => book ) )-->
                    <li>
                        <a href="<?php echo Uri::to('admin/publications/editBook/' . $post->id); ?>">
                            <strong><?php echo $post->title; ?></strong>
                            <img width=300 height=auto src="/content/<?php echo $post->bookimage; ?>" alt="">
<!--                            <a href="--><?php //echo $book->externallink; ?><!--">Lien vers ce livre</a>--> <!--TODO : Search for a work around to make this link clickable inside the big clickable area.-->
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

<?php echo $footer; ?>