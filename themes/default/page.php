<?php

/**
 * @param int $category Get all the posts of a given category
 */


?>
<?php theme_include('header');
theme_include('page_utils');
?>

<?php
switch (page_slug()) {
    case 'blog':
        echo page_content();
        displayAllPostsCategory();
        break;
    case 'dossier':
        echo page_content();
        displayDossierSummary(false);
        break;
    case 'publication':
        echo page_content();
        displayAllPostsCategory();
        break;
}
?>

    <!---->
    <!--        --><?php //while (categories()): ?>
    <!--            --><?php //while (latest_posts(category_id())): ?>
    <!--                <h2>-->
    <!--                    --><?php //echo(category_id() . "  " . category_title() . "   " . article_title());
//                    echo "<br>"; ?>
    <!--                </h2>-->
    <!--                --><?php //echo article_html(); ?>
    <!--                --><?php //echo article_markdown(); ?>
    <!--            --><? // endwhile; ?>
    <!--        --><?php //endwhile; ?>

<?php theme_include('mapContact'); ?>
<?php theme_include('footer'); ?>