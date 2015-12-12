<?php

$posts = Registry::get('posts');

$books = [];
$publicTextPublications = [];
$scientificTextPublications = [];
$erroredPublications = [];
foreach ($posts as $post) {
    $ext = $post->data['extends'];

    switch ($ext['typeofpublication']) {
        case 'book':
            $books[] = $post;
            break;
        case 'textpublication':
            switch ($post->extends['publicofpublication']) {
                case 'scientific':
                    $scientificTextPublications[] = $post;
                    break;
                case 'public':
                default:
                    $publicTextPublications[] = $post;
                    break;
            }
            break;
        default:
            $erroredPublications[] = $post;
            break;
    }
}

//echo "<h1>Books : </h1><p>" . count($books) . "</p>";
//echo "<h1>Publications publiques : </h1><p>" . count($publicTextPublications) . "</p>";
//echo "<h1>Publications scientifiques : </h1><p>" . count($scientificTextPublications) . "</p>";
//echo "<h1>Errors : </h1><p>" . count($erroredPublications) . "</p>";

//Now we need to sort scientific/public text publications by date
function compareFunctionTextPublication($publicationA, $publicationB)
{
    $dateA = $publicationA->extends['customdate'];
    $dateB = $publicationB->extends['customdate'];


    $dateTimeA = DateTime::createFromFormat('d/m/Y', $dateA);
    $dateTimeB = DateTime::createFromFormat('d/m/Y', $dateB);

    $timeA = $dateTimeA->getTimestamp();
    $timeB = $dateTimeB->getTimestamp();

    if ($timeA < $timeB) {
        return 1;
    } else if ($timeB < $timeA) {
        return -1;
    } else {
        return 0;
    }
}

usort($publicTextPublications, "compareFunctionTextPublication");
usort($scientificTextPublications, "compareFunctionTextPublication");

function getYearOfPublication($publication, $extendKey)
{
    $d = date_parse($publication->extends[$extendKey]);
    return $d['year'];
}

//Then we would like to group by year

function groupPublicationByYear($array, $extendKey)
{
    $tmp = array();
    foreach ($array as $item) {
        $year = getYearOfPublication($item, $extendKey);
        $tmp[$year][] = $item;
    }
    return $tmp;
}

$publicTextPublications = groupPublicationByYear($publicTextPublications, 'customdate');
$scientificTextPublications = groupPublicationByYear($scientificTextPublications, 'customdate');


$numberOfBookPerRow = 3;
?>

<div class="bookContainer">
    <?php

    function displayHTMLBook($book, $ext)
    {
        echo '<div class="book">' .
            '<a class="hidden-link" href="">' .
            '<img src="/content/' . $ext['bookimage'] . '" alt="" class="bookImg">' .
            '<div class="bookTitle">' . $book->data['title'] . '</div>' .
            '</a>' .
            '</div>';
    }

    for ($row = 0; $row < floor(count($books) / $numberOfBookPerRow); $row++) {
        echo '<div class="bookRow">';
        for ($rowIndex = 0; $rowIndex < $numberOfBookPerRow; $rowIndex++) {
            $bookIndex = $row * $numberOfBookPerRow + $rowIndex;
            $ext = $posts[$bookIndex]->data['extends'];
            displayHTMLBook($books[$bookIndex], $ext);
        }
        echo '</div>';
    }
    if (floor(count($books) / $numberOfBookPerRow) != ceil(count($books) / $numberOfBookPerRow)) {
        //Some trailing books
        echo '<div class="bookRow">';
        $nbDoneRows = floor(count($books) / $numberOfBookPerRow);
        for ($i = $nbDoneRows * $numberOfBookPerRow; $i < count($books); $i++) {
            $ext = $posts[$i]->data['extends'];
            displayHTMLBook($books[$i], $ext);
        }
        echo '</div>';
    }

    ?>
</div>


<?php
function displayHTMLPublication($publication)
{

    echo '<a href="' . $publication['extends']['externallink'] . '"><div class="publication">' .
        '<div class="date">' . $publication['extends']['customdate'] . '</div>' .
        '<div class="text">' . $publication['description'] . '</div>' .
        '</div></a>';
}

function displayHTMLPublicationCol($ar)
{
    //The first year to display should be the first key in the array as it is sorted
    reset($ar);
    $firstYear = key($ar);
    $public = $ar[$firstYear][0]->data['extends']['publicofpublication'];

    echo '<div class="publicationColTitle">Publication <br>' . $public . '</div>';
    foreach ($ar[$firstYear] as $publication) {
        displayHTMLPublication($publication->data);
    }

    //Next years should be displayed as dropdowns
    foreach ($ar as $year => $publications) {
        if ($year != $firstYear) {
            echo '<div class="dropdown">'
                . '<div class="dropdown-drop title">' . $year . '</div>'
                . '<div class="dropdown-content">';
            foreach ($publications as $publication) {
                displayHTMLPublication($publication->data);
            }
            echo '</div></div>';
        }
    }

}

?>


<div class="publicationContainer">
    <div class="publicationCol">
        <?php
        displayHTMLPublicationCol($publicTextPublications);
        ?>
    </div>
    <div class="publicationCol">
        <?php
        displayHTMLPublicationCol($scientificTextPublications);
        ?>
    </div>
</div>
<script>
    var $dropdowndrop = $('.dropdown-drop');
    var toggledClass = 'active';
    $dropdowndrop.click(function (e) {
        $(this).parent().toggleClass(toggledClass);
    });
</script>