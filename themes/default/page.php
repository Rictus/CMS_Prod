<?php

/**
 * @param int $category Get all the posts of a given category
 */
function category_posts($categoryTitle)
{
    $cat = Category::where('title', '=', $categoryTitle)->get();
    if (count($cat) > 0) {
        $idCategory = $cat[0]->id;
    } else {
        return false;
    }

    $posts = Post::where('category', '=', $idCategory)->get();
    //Replacing author id by author name
    for ($i = 0; $i < count($posts); $i++) {
        ;
        $author = User::where('id', '=', $posts[$i]->data["author"])->get();
        $author = $author[0];
        $posts[$i]->data["author"] = $author->real_name;
    }
    return $posts;
}

?>

<?php theme_include('header'); ?>

<?php //echo page_title() ?>
<?php echo page_content(); ?>
        <?php $posts = category_posts(page_title()); ?>
        <?php if ($posts == false) {
            echo "Aucun posts dans cette catégorie.";
        } else {
            $nbPost = count($posts);

            for ($i = 0; $i < $nbPost; $i++) {
                $curPost = $posts[$i]->data;
                $curId = $curPost["id"];
                $curTitle = $curPost["title"];
                $curHTML = $curPost["html"];
                $curAuthor = $curPost["author"];
                $curDatePost = $curPost["created"];
                setlocale(LC_ALL, 'fr_FR');
                echo "<section class='content wrap' id='article-".$curId."'>";
                echo "<h1>" . $curTitle . "</h1>";
                echo "<time datetime=" . date(DATE_W3C, strtotime($curDatePost)) . ">" . strftime('%d %B %Y', strtotime($curDatePost)) . "</time>";
                echo "<article class=''>".$curHTML."</article>";
                echo "<section class='footnote'>Auteur : " . $curAuthor . "</section>";
                echo "</section>";
            }
        } ?>

        <h1></h1>


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

<?php theme_include('footer'); ?>