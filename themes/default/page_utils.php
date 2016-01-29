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

function limitHTMLText2($htmlText, $limit = 350)
{
    $str = substr($htmlText, 0, $limit); //$limit first chars of $htmlText, tags included
    $strWithoutHTMLTags = strip_tags($str); //Removing tags, calculating length
//    $strWithoutHTMLTags = preg_replace('/\s+/', '', $strWithoutHTMLTags); //Removing all white spaces
    /*if (strlen($strWithoutHTMLTags) == 0) {
        return $htmlText;
    } else {*/
    $i = strlen($strWithoutHTMLTags);
    while (strlen($strWithoutHTMLTags) < $limit && $i < strlen($htmlText) && strlen($strWithoutHTMLTags) > 0) { //If length not enough and if there is still some text to add : adding chars
        $str .= $htmlText[$i];
        $strWithoutHTMLTags = strip_tags($str); //Removing tags for calculating length without including html tags
//            $strWithoutHTMLTags = preg_replace('/\s+/', '', $strWithoutHTMLTags);
        $i++;
        //}*/
    }
    return closetags($str);

}


function strip_single_tag($str, $tag)
{

    $str = preg_replace('/<' . $tag . '[^>]*>/i', '', $str);

    $str = preg_replace('/<\/' . $tag . '>/i', '', $str);

    return $str;
}

/**
 * Limit a given htmltext to a given number of characters without removing html tags
 * @param $htmlText
 * @param int $limit
 */
function limitHTMLText($htmlText, $limit = 350, $removeLinkElements = true)
{
    //First removing videos, it can cause problems.
    $iframesMatched = [];
    $regex = '(<iframe .*\/iframe>)';
    preg_match($regex, $htmlText, $iframesMatched); // We're going to save the first to put it as an article header
    $htmlText = preg_replace($regex, '', $htmlText);
    $htmlText = preg_replace('(videodetector)', '', $htmlText);
    if (count($iframesMatched) > 0) {
        $iframesMatched = $iframesMatched[0];
    } else {
        $iframesMatched = "";
    }

    if ($removeLinkElements)
        $htmlText = strip_single_tag($htmlText, "a");

    $str = substr($htmlText, 0, $limit); //$limit first chars of $htmlText, tags included
    $strWithoutHTMLTags = strip_tags($str); //Removing tags, calculating length
    $i = strlen($str);
    while (strlen($strWithoutHTMLTags) < $limit && $i < strlen($htmlText)) { //If length not enough and if there is still some text to add : adding chars
        $str .= $htmlText[$i];
        $strWithoutHTMLTags = strip_tags($str); //Removing tags for calculating length of the text only
        $i++;
    }
    $str .= "...";
    $str = closetags($str);
    $str = "<div class='videodetector'>" . $iframesMatched . "</div>" . $str;
    return $str;
}

function appendClickablePreviewArticles($id, $title, $date, $author, $content, $link, $addSeparatorLine = false, $sizeLimit = 350)
{
    $contentText = limitHTMLText($content, $sizeLimit, true);
//    $contentText = closetags(removeLastWord($contentText) . " …");
    $contentText = removeStyleAttribute($contentText);
    $printableDate = utf8_encode(strftime('%d %B %Y', article_time_given_date($date)));

    echo '<a class="hiddenLink articleLink" href="' . $link . '">';
    echo '<div class="articleContainer preview col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 col-sm-offset-0">
        <section class="content wrap" id="article-' . $id . '">';


    echo '<time class="date" datetime="' . date(DATE_W3C, strtotime($date)) . '">' . $printableDate . '</time>';
    echo '<h1 class="">' . $title . '</h1>';
    echo '<article >' . $contentText . '</article>';
    echo "</section>";
    if ($addSeparatorLine)
        echo "<div class='centerLine'></div>";
    echo "</div>";
    echo "</a>";
}


function displayDossierSummary_PostLink($summaryInArticlePage = true, $post)
{
    $postTitle = $post['title'];
    $postSlug = $post['slug'];
    if ($summaryInArticlePage)
        echo '<a class="summary-link" href=' . $postSlug . '>' . $postTitle . '</a> ';
    else
        echo '<a class="summary-link" href=./posts/' . $postSlug . '>' . $postTitle . '</a> ';
}

function displayDossierSummary($summaryInArticlePage = true)
{
    $lang = getLanguage();
    $posts = Registry::get('posts');
    for ($i = 0; $i < count($posts); $i++) {
        $posts[$i]->data['typeofproblem'] = $posts[$i]->data['extends']['typeofproblem'];
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
        if ($curPost['extends']['targetlanguage'] == $lang) {
            if (!$curPost['typeofproblem'] || $curPost['typeofproblem'] == 'indifferent') {
                displayDossierSummary_PostLink($summaryInArticlePage, $curPost);
            }
        }
    }
//Then displaying typeofproblem=female
    echo "<div class='summary-col-title'>Problème féminin</div>";
    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        if ($curPost['extends']['targetlanguage'] == $lang) {
            if ($curPost['typeofproblem'] == 'feminin') {
                displayDossierSummary_PostLink($summaryInArticlePage, $curPost);
            }
        }
    }
    echo "</div>";//col


    echo "
    <div class='summary-col col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
    echo "<div class='summary-col-title'>Problème masculin</div>";
    //Then displaying typeofproblem=male
    for ($i = 0; $i < count($posts); $i++) {
        $curPost = $posts[$i]->data;
        if ($curPost['extends']['targetlanguage'] == $lang) {
            if ($curPost['typeofproblem'] == 'masculin') {
                displayDossierSummary_PostLink($summaryInArticlePage, $curPost);
            }
        }
    }
    echo "</div>"; //col
    echo "</div>";//summary

}

function getLanguage()
{
    return isset($GLOBALS['lang']) ? $GLOBALS['lang'] : 'fr';
}

function displayBlogPostsPreview()
{
    $lang = getLanguage();
    $posts = Registry::get('posts');
    $page = Registry::get('page');
    $category = Registry::get('category');
    $total = Registry::get('total_posts');
    $max_page = Registry::get('maxPageNumber');
    $pageNumber = Registry::get('currentPageNumber');

    for ($i = count($posts) - 1; $i >= 0; $i--) {
        $curPost = $posts[$i]->data;
        $link = "/posts/" . $curPost['slug'];
        if ($curPost['lang'] == $lang)
            appendClickablePreviewArticles($curPost['id'], $curPost['title'], $curPost['created'], $curPost['author'], $curPost['html'], $link, true);
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