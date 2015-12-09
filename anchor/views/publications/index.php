<?php echo $header; ?>
<?php
$books = [];
$textPublications = [];
$erroredPublications = [];
foreach ($posts->results as $book) {
    if ($book->typeofpublication == 'book') {
        $books[] = $book;
    } else if ($book->typeofpublication == 'textpublication') {
        $textPublications[] = $book;
    } else {
        $erroredPublications[] = $book;
    }
}

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
                <?php foreach ($books as $book): ?>
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
                        <a href="<?php echo Uri::to('admin/publications/editBook/' . $book->id); ?>">
                            <strong><?php echo $book->title; ?></strong>
                            <img width=300 height=auto src="/content/<?php echo $book->bookimage; ?>" alt="">
<!--                            <a href="--><?php //echo $book->externallink; ?><!--">Lien vers ce livre</a>--> <!--TODO : Search for a work around to make this link clickable inside the big clickable area.-->
                            <p><?php echo strip_tags($book->description); ?></p>
                            <span>
                                <time><?php echo Date::format($book->created); ?></time>

                                <em class="status <?php echo $book->status; ?>"
                                    title="<?php echo __('global.' . $book->status); ?>">
                                    <?php echo __('global.' . $book->status); ?>
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