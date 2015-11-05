<?php


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
        $author = User::where('id', '=', $posts[$i]->data["author"])->get();
        $author = $author[0];
        $posts[$i]->data["author"] = $author->real_name;
    }
    return $posts;
}


function displayDossierSummary($summaryInArticlePage = true)
{
    $posts = category_posts('dossier');
    echo "<div class='summary col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12'>";

    if (!$summaryInArticlePage)
        echo "<h1 class='pageTitle'>Étude et information <br>en andrologie & sexologie.</h1>"; //could be page title from admin

    echo "<div class='summary-col col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
    for ($i = 0; $i < count($posts) / 2; $i++) {
        $curPost = $posts[$i]->data;
        $postTitle = $curPost['title'];
        $postSlug = $curPost['slug'];
        if($summaryInArticlePage)
            echo '<a class="summary-link" href=' . $postSlug . '>' . $postTitle . '</a> ';
        else
            echo '<a class="summary-link" href=./posts/' . $postSlug . '>' . $postTitle . '</a> ';
    }
    echo "</div>";//col

    echo "<div class='summary-col col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
    for ($i = count($posts) / 2; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        $postTitle = $curPost['title'];
        $postSlug = $curPost['slug'];
        if($summaryInArticlePage)
            echo '<a class="summary-link" href=' . $postSlug . '>' . $postTitle . '</a>';
        else
            echo '<a class="summary-link" href=./posts/' . $postSlug . '>' . $postTitle . '</a>';
    }
    echo "</div>"; //col
    echo "</div>";//summary

}

function displayAllPostsCategory()
{
    $posts = category_posts(page_title());
    if ($posts == false) {
//    echo "Aucun posts dans cette catégorie : " . page_title();
    } else {
        $nbPost = count($posts);
        for ($i = 0; $i < $nbPost; $i++) {
            $curPost = $posts[$i]->data;
            $curId = $curPost["id"];
            $curTitle = $curPost["title"];
            $curHTML = $curPost["html"];
            $curAuthor = $curPost["author"];
            $curDatePost = $curPost["created"];
            $curSlug = $curPost['slug'];

            //print_r(page_custom_field($key, $default = ''));
            echo "<section class='content wrap' id='article-" . $curId . "'>";
            echo " <h1><a href=" . "posts/" . $curSlug . " title=" . $curTitle . ">" . $curTitle . "</a></h1>";
            echo "<time datetime=" . date(DATE_W3C, strtotime($curDatePost)) . ">" . strftime('%d %B %Y', strtotime($curDatePost)) . "</time>";
            echo "<article class=''>" . $curHTML . "</article>";
            echo "<section class='footnote'>Auteur : " . $curAuthor . "</section></section>";
        }
    }
}