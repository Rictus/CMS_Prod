<?php
theme_include('header');
theme_include('header_image');
?>
    <div class="content">
    <div class="bigText wrap">
        <ul>
            Evaluer pour :
            <li>- mieux traiter les dysfonctionnments</li>
            <li>- prevenir les mefaits des facteurs de risque vasculaire</li>
            <li>- corriger les mefaits du vieillissements</li>
        </ul>
    </div>
    <div class="">
        <div class="listOfPostsContainer">
            <div class="listOfPosts">
                <div class="colTitle">Nos compétences :</div>
                <ul>
                    <div class="listTitle">DYSFONCTION SEXUELLES</div>
                    <li>- Désir, érection, éjaculation</li>
                    <li>- Problèmes de couple</li>
                    <li>- Maladie de Lapeyronie</li>
                    <li>- Anomalie morphologiques</li>
                </ul>

                <ul>
                    <div class="listTitle">MALADIE VASCULAIRE</div>
                    <li>- Varices, variscosités</li>
                    <li>- Lymphatiques</li>
                    <li>- Artérites, Anévrysmes</li>
                    <li>- Phlébites, Ulcères</li>
                </ul>
                <ul>
                    <div class="listTitle">MÉDECINE RÉGÉNÉRATIVE</div>
                    <li>- Détection du risque vasculaire</li>
                    <li>- Thérapie cellulaire autologue</li>
                </ul>
            </div>
            <div class="listOfPosts">
                <div class="colTitle">Bilans personnalisés adaptés à chacun :</div>
                <ul>
                    <div class="listTitle">Pour les dysfonctions</div>
                    <li>- Questionnaire spécifique</li>
                    <li>- Test pharmacologique avec échographie</li>
                    <li>- Bilan psychologique MMPI</li>
                    <li>- Étude biologique</li>
                    <li>- Cavernoscanner</li>
                </ul>
                <ul>
                    <div class="listTitle">Dépistage cardio vasculaire et métabolique</div>
                    <li>- Oligoscan et étude biologique</li>
                    <li>- Mesure de l’intima media</li>
                    <li>- Endopath</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="bio row">
        <div class="bioImgCol col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="bioPicture">
                <img src="<?php echo theme_url("./img/Portrait.png") ?>" alt="Photo de Ronald Virag">
            </div>
        </div>
        <div class="bioTextCol col-lg-7 col-md-7 col-sm-6 col-xs-12">
            <div class="mainBio">
                Le Docteur Virag, né le 7 décembre 1938, médecin et chirurgien en sexologie à Paris dans le huitième
                arrondissement, est un spécialiste des troubles sexuels au Centre d'Explorations et Traitements de
                l'Impuissance (difficultés, dysfonctions, éjaculation prématurée...) et de la prévention des
                maladies du cœur et des vaisseaux.
            </div>
            <div class="row">
                <div class="bioContent col-lg-6 col-md-6 col-sm-9 col-xs-10">
                    Le Docteur Virag est fort d'une expérience de plus de trente ans en recherches et expériences
                    cliniques.Il est membre de l'Académie Nationale de Chirurgie, ancien interne des Hôpitaux de Paris,
                    ancien chef de clinique à la Faculté de Paris, docteur en médecine, spécialisé en chirurgie,
                    compétent en angiologie et sexologie vous reçoit à Paris en consultation, discrète, individuelle et
                    de couple
                </div>
                <div class="bioContent col-lg-6 col-md-6 col-sm-9 col-xs-10">
                    Bilan par doppler, échographie, électromyogramme, cavernoscanner. <br> Il utilise une approche
                    médicalisée fondée sur des techniques et des traitement innovants. Le Docteur Virag a publié plus de
                    soixante-dix publications dans des grandes revues scientifiques et est l'auteur de plusieurs livres
                    dont le dernier « Erection mode d'emploi ».
                </div>
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
        $lastBlogPost = $lastBlogPost->data;
        $lastBlogPostDate = utf8_encode(strftime('%d %B %Y', article_time_given_date($lastBlogPost['created'])));
        ?>
        <div class="inner">
            <div class="date"><?php echo $lastBlogPostDate; ?></div>
            <div class="title"><?php echo $lastBlogPost['title']; ?></div>
            <?php
                echo $lastBlogPost['html']; //TODO : limit number of chars
            ?>
            <!--            <div class="picture"><img src="-->
            <?php //echo theme_url("./img/Actu.png"); ?><!--" alt=""></div>-->
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

<?php theme_include('mapContact'); ?>
<?php theme_include('footer'); ?>