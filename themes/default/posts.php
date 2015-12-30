<?php
theme_include('header');
theme_include('header_image');
?>
    <div class="content">
        <div class="bigText wrap">
            <?php echo site_meta('introfirstpart'); ?>
        </div>
        <div class="">
            <div class="listOfPostsContainer">
                <div class="listOfPosts">
                    <?php echo site_meta('introsecondpart'); ?>
                </div>
                <div class="listOfPosts">
                    <?php echo site_meta('introthirdpart'); ?>
                </div>
            </div>
        </div>

        <?php
        $bioimage = Registry::get('bioimage');
        $biofirstpart = Registry::get('biofirstpart');
        $biosecondpart = Registry::get('biosecondpart');
        $biothirdpart = Registry::get('biothirdpart');

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
                <a class="link pre-chevron" href="#">En savoir plus</a>
            </div>
        </div>

        <div class="team">
            <div class="title">
                Notre équipe
            </div>
            <?php
            function displayTeamMember($teamMember)
            {
                echo '<div class="peopleDesc">
                <div class="job">' . $teamMember['teammemberjob'] . '</div>
                <div class="people">' . $teamMember['teammembername'] . '</div>
                </div>';
            }


            $team = Registry::get('team');
            $nbItemsPerRow = 4;
            $totalNbRow = ceil(count($team) / $nbItemsPerRow);
            for ($rowNumber = 0; $rowNumber < $totalNbRow; $rowNumber++) {
                echo '<div class="teamInnerContainer">';
                for ($i = 0; $i < $nbItemsPerRow; $i++) {
                    $indexMember = $i + $nbItemsPerRow * $rowNumber;
                    if ($indexMember < count($team)) {
                        displayTeamMember($team[$indexMember]->data);
                    }
                }
                echo '</div>';
            }
            ?>
        </div>

        <div class="lastPost">
            <?php

            $lastBlogPost = Registry::get('lastBlogPost');
            //        var_dump($lastBlogPost);
            $lastBlogPost = $lastBlogPost->data;
            $lastBlogPostDate = utf8_encode(strftime('%d %B %Y', article_time_given_date($lastBlogPost['created'])));
            ?>
            <a href="/posts/<?php echo $lastBlogPost['slug']; ?>" class="hidden-link article-link">
                <div class="inner">
                    <div class="date"><?php echo $lastBlogPostDate; ?></div>
                    <div class="title"><?php echo $lastBlogPost['title']; ?></div>
                    <?php
                    echo $lastBlogPost['html']; //TODO : limit number of chars
                    ?>
                </div>
            </a>
        </div>
    </div>


    <div class="lastPublications">
        <div class="inner row">
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

            usort($books, "compareDateBook");
            while ($nbBookDisplayed < $nbBookToDisplay && $nbBookDisplayed < count($books)) {
                displayBook($books[$nbBookDisplayed]->data);
                $nbBookDisplayed++;
            }
            ?>
        </div>
        <div class="linkContainer">
            <a href="/publication" class="link pre-chevron">Accéder aux livres</a>
        </div>
    </div>


    <script>
        $(".keepwhitespaces").each(function () {
            var html = $(this).html();
            var pattern = html.match(/\s*\n[\t\s]*/);
            $(this).html(html.replace(new RegExp(pattern, "g"), '\n'));
        });
    </script>

<?php theme_include('mapContact'); ?>
<?php theme_include('footer'); ?>