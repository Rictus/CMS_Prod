<?php theme_include('header'); ?>
<?php theme_include('header_image'); ?>
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
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="bioPicture">
                <img src="<?php echo theme_url("./img/Portrait.png") ?>" alt="Photo de Ronald Virag">
            </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
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
            <a class="link pre-chevron" href="">En savoir plus</a>
        </div>
    </div>

    <div class="team">
        <div class="title">
            Notre équipe
        </div>
        <div class="row">
            <div class="peopleDesc col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="job">Chirurgien et Sexologue</div>
                <div class="people">Dr RONALD VIRAG</div>
            </div>
            <div class="peopleDesc col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="job">Médecin vasculaire, echographie vasculaire</div>
                <div class="people">Dr HÉLÈNE SUSSMAN</div>
            </div>
            <div class="peopleDesc col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="job">Neuro-psychiatre, electromyogramme</div>
                <div class="people">Dr JEAN FLORESCO</div>
            </div>
            <div class="peopleDesc col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="job">Médecin vasculaire, échographie générale</div>
                <div class="people">Dr CHRISTELLE RICHARD</div>
            </div>
        </div>
    </div>

    <!--
        <?php /*if (has_posts()): */ ?>
            <ul class="items">
                <?php /*posts(); */ ?>
                <li>
                    <article class="wrap">
                        <time
                            datetime="<?php /*echo date(DATE_W3C, article_time()); */ ?>"><?php /*echo relative_time(article_time()); */ ?></time>
                        <?php /*if (count(article_title()) > 1): */ ?>
                            <h1>
                                <a href="<?php /*echo article_url(); */ ?>"
                                   title="<?php /*echo article_title(); */ ?>"><?php /*echo article_title(); */ ?></a>
                            </h1>
                        <?php /*endif; */ ?>
                        <div class="content">
                            <?php /*echo article_markdown(); */ ?>
                        </div>

                        <footer>
                            Auteur : <?php /*echo article_author(); */ ?>
                        </footer>
                    </article>
                </li>
                <?php /*$i = 0;
                while (posts()): */ ?>
                    <?php /*$bg = sprintf('background: hsl(215, 28%%, %d%%);', round(((++$i / posts_per_page()) * 20) + 20)); */ ?>
                    <li style="<?php /*echo $bg; */ ?>">
                        <article class="wrap">
                            <h2>
                                <a href="<?php /*echo article_url(); */ ?>"
                                   title="<?php /*echo article_title(); */ ?>"><?php /*echo article_title(); */ ?></a>
                            </h2>
                        </article>
                    </li>
                <?php /*endwhile; */ ?>
            </ul>

            <?php /*if (has_pagination()): */ ?>
                <nav class="pagination">
                    <div class="wrap">
                        <?php /*echo posts_prev(); */ ?>
                        <?php /*echo posts_next(); */ ?>
                    </div>
                </nav>
            <?php /*endif; */ ?>

        <?php /*else: */ ?>
            <p>Aucun article.</p>
        --><?php /*endif; */ ?>


<?php theme_include('footer'); ?>