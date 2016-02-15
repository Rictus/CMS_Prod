<?php
theme_include('header');
?>
    <div
        class="articleContainer col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 col-sm-offset-0">
        <section class="content wrap" id="article-<?php echo article_id(); ?>">

            <h1 class=""><?php echo article_title(); ?></h1>

            <?php
            echo "<time class='date' datetime=" . date(DATE_W3C, article_time()) . ">" . utf8_encode(strftime('%d %B %Y',article_time())) . "</time>";
            ?>

            <article>
                <?php echo article_markdown(); ?>
            </article>

            <div class="articleAuthorTextRules">
                <?php echo "auteur : " . article_author(); ?>
            </div>

        </section>
    </div>


<?php
//Some content to add after an article
switch (article_category_slug()) {
    case 'blog':
        break;
    case 'dossier':
        //Here, adding the summary
        displayDossierSummary(true, $dossierbigtitle, $masculintitle, $feminintitle);
        break;
    case 'publication':
        break;
}

theme_include('mapContact');
theme_include('footer');

?>