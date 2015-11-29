<?php


function category_posts()
{

    $page = Registry::get('page');
    $pageId = $page->data['id'];
    $category = Registry::get('category');
    $categoryId = $category->data['id'];

    $posts = Post::where('category', '=', $categoryId)->get();
    //Replacing author id by author name
    for ($i = 0; $i < count($posts); $i++) {
        $author = User::where('id', '=', $posts[$i]->data["author"])->get();
        $author = $author[0];
        $posts[$i]->data["author"] = $author->real_name;
    }
    return $posts;
}

/**
 * Close all tags for a given html
 * E.g :  <p>abcde<b>dza
 * return <p>abcde<b>dza</b></p>
 * @param $html
 * @return string
 */
function closetags($html)
{
    #put all opened tags into an array
    preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result);
    $openedtags = $result[1];
    #put all closed tags into an array
    preg_match_all("#</([a-z]+)>#iU", $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    # all tags are closed
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    # close tags
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            $html .= "</" . $openedtags[$i] . ">";
        } else {
            unset ($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
}

/**
 * Remove the last sentence of a given str. A sentence should end with a .
 * @param $str
 * @return string
 */
function removeLastSentence($str)
{
    $splittedStr = preg_split("/\./", $str);
    array_pop($splittedStr);
    return implode(".", $splittedStr) . ".";
}

function removeStyleAttribute($str)
{
    return preg_replace('/style=(\'|").*(\'|")/mi', '', $str);
}


function removeLastWord($str)
{
    $splittedStr = preg_split("/\ /", $str);
    array_pop($splittedStr);
    return implode(" ", $splittedStr);
}

/**
 * Limit a given htmltext to a given number of characters without removing html tags
 * @param $htmlText
 * @param int $limit
 */
function limitHTMLText($htmlText, $limit = 350)
{
    $str = substr($htmlText, 0, $limit); //$limit first chars of $htmlText, tags included
    $strWithoutHTMLTags = strip_tags($str); //Removing tags, calculating length
    $i = strlen($str);
    while (strlen($strWithoutHTMLTags) < $limit && $i < strlen($htmlText)) { //If length not enough and if there is still some text to add : adding chars
        $str .= $htmlText[$i];
        $strWithoutHTMLTags = strip_tags($str); //Removing tags for calculating length of the text only
        $i++;
    }
    return closetags($str);
}

function appendClickablePreviewArticles($id, $title, $date, $author, $content, $link, $addSeparatorLine = false)
{
    $contentText = limitHTMLText($content, 350);
    $contentText = closetags(removeLastWord($contentText) . " …");
    $contentText = removeStyleAttribute($contentText);

    echo '<a class="hiddenLink articleLink" href="' . $link . '">';
    echo '<div class="articleContainer preview col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 col-sm-offset-0">
        <section class="content wrap" id="article-' . $id . '">';


    echo '<time class="date" datetime="' . date(DATE_W3C, $date) . '">' . date('d F o', $date) . '</time>';
    echo '<h1 class="">' . $title . '</h1>';
    echo '<article >' . $contentText . '</article>';
    echo "</section>";
    if ($addSeparatorLine)
        echo "<div class='centerLine'></div>";
    echo "</div>";
    echo "</a>";
}

function removeTypeofproblem($title)
{
    return preg_replace("(^\{.*?\})", "", $title); //Removing existing {} and texte inside it. Only at the beginning
}

function getTypeofproblem($title)
{
    $matchedArray = array();
    preg_match("(^\{.*?\})", $title, $matchedArray);
    return $matchedArray;
}

function displayDossierSummary_PostLink($summaryInArticlePage = true, $post)
{
    $postTitle = removeTypeofproblem($post['title']);
    $postSlug = $post['slug'];
    if ($summaryInArticlePage)
        echo '<a class="summary-link" href=' . $postSlug . '>' . $postTitle . '</a> ';
    else
        echo '<a class="summary-link" href=./posts/' . $postSlug . '>' . $postTitle . '</a> ';
}

function displayDossierSummary($summaryInArticlePage = true)
{
    $posts = category_posts();
    for ($i = 0; $i < count($posts); $i++) {
        $matchedArray = getTypeofproblem($posts[$i]->data["title"]);
        if (count($matchedArray) > 0) {
            $posts[$i]->data['typeofproblem'] = $matchedArray[0];
        } else {
            $posts[$i]->data['typeofproblem'] = false;
        }
    }
    echo "
<div class='summary col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12'>";

    if (!$summaryInArticlePage)
        echo "<h1 class='pageTitle'>Étude et information <br>en andrologie & sexologie.</h1>"; //could be page title from admin


    echo "
    <div class='summary-col col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
    //First displaying posts with no specified type of problem :
    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        if (!$curPost['typeofproblem']) {
            displayDossierSummary_PostLink($summaryInArticlePage, $curPost);
        }
    }
//Then displaying typeofproblem=female
    echo "<h3>Problème féminin</h3>";
    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        if ($curPost['typeofproblem'] == '{feminin}') {
            displayDossierSummary_PostLink($summaryInArticlePage, $curPost);
        }
    }
    echo "</div>";//col


    echo "
    <div class='summary-col col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
    echo "<h3>Problème masculin</h3>";
    //Then displaying typeofproblem=male
    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        if ($curPost['typeofproblem'] == '{masculin}') {
            displayDossierSummary_PostLink($summaryInArticlePage, $curPost);
        }
    }
    echo "</div>"; //col
    echo "</div>";//summary

}

function displayBlogPostsPreview()
{
    $posts = Registry::get('posts');
    $page = Registry::get('page');
    $category = Registry::get('category');
    $total = Registry::get('total_posts');
    $max_page = Registry::get('maxPageNumber');
    $pageNumber = Registry::get('currentPageNumber');

    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        $link = "/posts/" . $curPost['slug'];
        $date = strtotime($curPost['created']);
        appendClickablePreviewArticles($curPost['id'], $curPost['title'], $date, $curPost['author'], $curPost['html'], $link, true);
    }

    echo "<div class='paginationContainer col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4'><div class='pagination'>";
    if ($pageNumber - 1 >= 1)
        echo "<a class='prevNext' href='/blog/" . ($pageNumber - 1) . "'>Précédente</a>";
    for ($i = 1; $i <= $max_page; $i++) {
        if ($i == $pageNumber) {
            echo "<a href='/blog/" . $i . "' class='active'>" . $i . "</a>";
        } else {
            echo "<a href='/blog/" . $i . "'>" . $i . "</a>";
        }
    }
    if ($pageNumber + 1 <= $max_page)
        echo "<a class='prevNext' href='/blog/" . ($pageNumber + 1) . "'>Suivante</a>";
    echo "</div></div>";
}

function displayAllPostsCategory()
{
    $posts = category_posts();
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

            echo "
<section class='content wrap' id='article-" . $curId . "'>";
            echo " <h1><a href=" . " posts/" . $curSlug . " title=" . $curTitle . ">" . $curTitle . "</a></h1>";
            echo "
    <time datetime=" . date(DATE_W3C, strtotime($curDatePost)) . ">" . strftime('%d %B %Y', strtotime($curDatePost)) .
                "
    </time>
    ";
            echo "
    <article class=''>" . $curHTML . "</article>
    ";
            echo "
    <section class='footnote'>Auteur : " . $curAuthor . "</section>
</section>";
        }
    }
}