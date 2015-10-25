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


function displayDossierSummary()
{
    $posts = category_posts('dossier');
//    print_r($posts);
    echo "<div class='summary'>";
    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        $postTitle = $curPost['title'];
        $postSlug = $curPost['slug'];
        echo '<a class="summary-link" href=./posts/' . $postSlug . '>' . $postTitle . '</a><br>';
//        var_dump($curPost);
        echo "<br>";
    }
    echo "</div>";

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