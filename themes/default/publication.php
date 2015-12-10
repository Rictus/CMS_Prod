<?php

$posts = Registry::get('posts');

$books = [];
$textPublications = [];
$erroredPublications = [];
foreach ($posts as $post) {
    $ext = $post->data['extends'];

    if ($ext['typeofpublication'] == 'book') {
        $books[] = $post;
    } else if ($ext['typeofpublication'] == 'textpublication') {
        $textPublications[] = $post;
    } else {
        $erroredPublications[] = $post;
    }
}

$numberOfBookPerRow = 3;

//echo "<h1>Books : </h1><p>".count($books)."</p>";
//echo "<h1>Texts : </h1><p>".count($textPublications)."</p>";
//echo "<h1>Errors : </h1><p>".count($erroredPublications)."</p>";

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


<div class="publicationContainer">
    <div class="publicationCol">
        <div class="publicationColTitle">Publication <br>grand public</div>
        <div class="publication">
            <div class="date">13 mai 2015</div>
            <div class="text">Des spermatozoïdes fabriqués  en laboratoire : c'est important  pour les couples
                infertiles
            </div>
        </div>
        <div class="publication">
            <div class="date">21 novembre 2015</div>
            <div class="text">" Si son nom est l'anagramme de celui du Viagra, c'est le fait du hasard. Si les
                promoteurs de "la pillule de l'amour" ont retenu un nom proche du sien qui était au départ celui
                d'un médicament destiné à aider les hommes à uriner, judicieusement inspiré de "Niagara" ... "
            </div>
        </div>
        <div class="publication">
            <div class="date">21 novembre 2015</div>
            <div class="text">(...)Il y a eu le Viagra, le Cialis, et puis maintenant le Levitra, une nouvelle
                pilule pour favoriser l'érection.
            </div>
        </div>
        <div class="publication">
            <div class="date">14 mai 2015</div>
            <div class="text">L’invité Ronald VIRAG Il est reconnu aujourd’hui comme une sommité mondiale dans le
                traitement des ..
            </div>
        </div>
        <div class="publication">
            <div class="date">18 avril 2015</div>
            <div class="text">Le traitement de l'impuissance sexuelle entre sécurité sanitaire et contrainte
                économique. Le Viagra est - il un médicament ord ...
            </div>
        </div>
        <div class="dropdown">
            <div class="dropdown-drop title">2014</div>
            <div class="dropdown-content">
                <div class="publication">
                    <div class="date">18 avril 2015</div>
                    <div class="text">Le traitement de l'impuissance sexuelle entre sécurité sanitaire et contrainte
                        économique. Le Viagra est - il un médicament ord ...
                    </div>
                </div>
                <div class="publication">
                    <div class="date">13 mai 2015</div>
                    <div class="text">Des spermatozoïdes fabriqués  en laboratoire : c'est important  pour les couples
                        infertiles
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <div class="dropdown-drop title">2013</div>
            <div class="dropdown-content">
                <div class="publication">
                    <div class="date">21 novembre 2015</div>
                    <div class="text">" Si son nom est l'anagramme de celui du Viagra, c'est le fait du hasard. Si les
                        promoteurs de "la pillule de l'amour" ont retenu un nom proche du sien qui était au départ celui
                        d'un médicament destiné à aider les hommes à uriner, judicieusement inspiré de "Niagara" ... "
                    </div>
                </div>
                <div class="publication">
                    <div class="date">18 avril 2015</div>
                    <div class="text">Le traitement de l'impuissance sexuelle entre sécurité sanitaire et contrainte
                        économique. Le Viagra est - il un médicament ord ...
                    </div>
                </div>
                <div class="publication">
                    <div class="date">13 mai 2015</div>
                    <div class="text">Des spermatozoïdes fabriqués  en laboratoire : c'est important  pour les couples
                        infertiles
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <div class="dropdown-drop title">2012</div>
            <div class="dropdown-content">
                <div class="publication">
                    <div class="date">13 mai 2015</div>
                    <div class="text">Des spermatozoïdes fabriqués  en laboratoire : c'est important  pour les couples
                        infertiles
                    </div>
                </div>
                <div class="publication">
                    <div class="date">13 mai 2015</div>
                    <div class="text">Elliovir-Un nouveau complément alimentaire Elliovir conçu d'après les travaux du
                        CETI
                        est destiné à protéger l'endothélium vasculaire et le tissu érectile des méfaits des facteurs de
                        risque vasculaire: diabète, hypertension artérielle, tabac, surpoids, excès de graisse.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="publicationCol">
        <div class="publicationColTitle">Publication <br>scientifique</div>
        <div class="publication">
            <div class="date">13 mai 2015</div>
            <div class="text">Elliovir-Un nouveau complément alimentaire Elliovir conçu d'après les travaux du CETI
                est destiné à protéger l'endothélium vasculaire et le tissu érectile des méfaits des facteurs de
                risque vasculaire: diabète, hypertension artérielle, tabac, surpoids, excès de graisse.
            </div>
        </div>
        <div class="publication">
            <div class="date">13 mai 2015</div>
            <div class="text">Comments from Ronald Virag on intracavernous injection: 25 years later.
                J Sex Med. 2005 May;2(3):289-90. No abstract available. PMID: 16422859 [PubMed - indexed for
                MEDLINE]
            </div>
        </div>
        <div class="publication">
            <div class="date">13 mai 2015</div>
            <div class="text">Flow-dependent dilatation of the cavernous artery. A potential test of penile NO
                content
                J Mal Vasc. 2002 Oct;27(4):214-7. French. PMID: 12457126 [PubMed - indexed for MEDLINE]
            </div>
        </div>
        <div class="dropdown ">
            <div class="dropdown-drop title">2014</div>
            <div class="dropdown-content">
            </div>
        </div>
        <div class="dropdown">
            <div class="dropdown-drop title">2013</div>
            <div class="dropdown-content">
            </div>
        </div>
        <div class="dropdown ">
            <div class="dropdown-drop title">2012</div>
            <div class="dropdown-content">
            </div>
        </div>
    </div>
</div>
<script>
    var $dropdowndrop = $('.dropdown-drop');
    var toggledClass = 'active';
    $dropdowndrop.click(function (e) {
        $(this).parent().toggleClass(toggledClass);
    });
</script>