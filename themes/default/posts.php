<?php
include("langVars.php");
theme_include('header');
theme_include('header_image');
$lang = $GLOBALS['lang'];
?>
    <div class="content">
        <div class="bigText wrap">
            <?php echo $introfirstpart; ?>
        </div>
        <div class="">
            <div class="listOfPostsContainer">
                <div class="listOfPosts">
                    <?php echo $introsecondpart ?>
                </div>
                <div class="listOfPosts">
                    <?php echo $introthirdpart; ?>
                </div>
            </div>
        </div>

        <?php

        ?>
        <div class="bio row">
            <div class="bioImgCol col-lg-5 col-md-5 col-sm-6 col-xs-12">
                <div class="bioPicture">
                    <img src="/content/<?php echo $bioimage; ?>" alt="Photo de Ronald Virag">
                </div>
            </div>
            <div class="bioTextCol col-lg-7 col-md-7 col-sm-6 col-xs-12">
                <div class="mainBio">
                    <?php echo $biofirstpart; ?>
                </div>
                <div class="row">
                    <div class="bioContent col-lg-6 col-md-6 col-sm-9 col-xs-10"><?php echo $biosecondpart; ?></div>
                    <div class="bioContent col-lg-6 col-md-6 col-sm-9 col-xs-10"><?php echo $biothirdpart; ?></div>
                </div>
                <a class="link pre-chevron"
                   href="https://fr.wikipedia.org/wiki/Ronald_Virag"><?php echo $knowmore; ?></a>
            </div>
        </div>

        <div class="team">
            <div class="title"><?php echo $ourteam; ?></div>
            <?php
            function displayTeamMember($teamMember)
            {
                $name = $teamMember['teammemberjob'];
                $job = $teamMember['teammembername'];
                echo '<div class="peopleDesc">
                <div class="job">' . $name . '</div>
                <div class="people">' . $job . '</div>
                </div>';
            }

            $nbItemsPerRow = 4;
            $totalNbRow = ceil(count($team) / $nbItemsPerRow);
            for ($rowNumber = 0; $rowNumber < $totalNbRow; $rowNumber++) {
                echo '<div class="teamInnerContainer">';
                for ($i = $nbItemsPerRow - 1; $i >= 0; $i--) {
                    $indexMember = $i + $nbItemsPerRow * $rowNumber;
                    if ($indexMember < count($team)) {
                        displayTeamMember($team[$indexMember]->data);
                    }
                }
                echo '</div>';
            }
            ?>
        </div>

        <?php
        $lastBlogPost = Registry::get('lastBlogPost');
        $lastBlogPost_en = Registry::get('lastBlogPost_en');


        function appendPreviewArticles($article, $sizeLimit = 350)
        {

            $id = $article["id"];
            $title = $article["title"];
            $date = $article["created"];
            $date = utf8_encode(strftime('%d %B %Y', article_time_given_date($article['created'])));
            $author = $article["author"];
            $content = $article["html"];
            $link = $article["slug"];
            $contentText = limitHTMLText($content, $sizeLimit);
            $contentText = closetags(removeLastWord($contentText) . " …");
            $contentText = removeStyleAttribute($contentText);


            echo '<a href="/posts/' . $link . '" class="hidden-link article-link">
                    <div class="inner">
                        <div class="date">' . $date . '</div>
                        <div class="title">' . $title . '</div>
                        ' . $contentText . '
                    </div>
                </a>';
        }

        if ($lastBlogPost != false):
            if ($GLOBALS['lang'] === 'en') {
                $lastBlogPost = $lastBlogPost_en->data;
            } else //if( $GLOBALS['lang']==='fr')
            {
                $lastBlogPost = $lastBlogPost->data;
            }

            echo ' <div class="lastPost">';
            appendPreviewArticles($lastBlogPost, 100);
            echo '</div>';
        endif;

        ?>
    </div>


<?php
$books = Registry::get('books');
$nbBookToDisplay = 3;
$nbBookDisplayed = 0;
function displayBook($book)
{
    echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 publication" date="' . $book['created'] . '">
                <div class="picture"><img src="content/' . $book['bookimage'] . '"></div>
                <div class="title">' . $book['title'] . '</div>
                <div class="description">' . $book['description'] . '</div>
                </div>';
}

function compareDateBook($bookA, $bookB)
{

    $dateA = $bookA->data['created'];
    $dateB = $bookB->data['created'];

    $dateTimeA = DateTime::createFromFormat('Y-m-d H:i:s', $dateA);
    $dateTimeB = DateTime::createFromFormat('Y-m-d H:i:s', $dateB);

    $timeA = $dateTimeA->getTimestamp();
    $timeB = $dateTimeB->getTimestamp();

    if ($timeA < $timeB) {
        return 1;
    } else if ($timeB < $timeA) {
        return -1;
    } else {
        return 0;
    }//*/
}

if (count($books) > 0) {
    usort($books, "compareDateBook");
    echo '<div class="lastPublications">';
    echo '<div class="inner row">';
    while ($nbBookDisplayed < $nbBookToDisplay && $nbBookDisplayed < count($books)) {
        if ($books[$nbBookDisplayed]->data['targetlanguage'] == $GLOBALS['lang']) {
            displayBook($books[$nbBookDisplayed]->data);
            $nbBookDisplayed++;
        } else {
            array_splice($books, $nbBookDisplayed, 1);
        }
    }

    echo '</div><div class="linkContainer"><a href="/publication" class="link pre-chevron">' . $accessbooks . '</a></div></div>';
}
?>


    <script>
        $(".keepwhitespaces").each(function () {
            var html = $(this).html();
            var pattern = html.match(/\s*\n[\t\s]*/);
            $(this).html(html.replace(new RegExp(pattern, "g"), '\n'));
        });
    </script>

<?php theme_include('mapContact'); ?>
<?php theme_include('footer'); ?>