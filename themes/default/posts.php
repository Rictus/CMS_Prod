<?php theme_include('header'); ?>
<?php theme_include('header_image'); ?>
    <section class="content">
        <div class="headline wrap">
            <ul>
                Evaluer pour :
                <li>- mieux traiter les dysfonctionnments</li>
                <li>- prevenir les mefaits des facteurs de risque vasculaire</li>
                <li>- corriger les mefaits du vieillissements</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="colTitle">Bilans personnalisés adaptés à chacun :</div>
                        <ul>
                            <div class="listTitle">POUR LES DYSFONCTIONS</div>
                            <li>- Questionnaire spécifique</li>
                            <li>- Test pharmacologique avec échographie</li>
                            <li>- Bilan psychologique MMPI</li>
                            <li>- Étude biologique</li>
                            <li>- Cavernoscanner</li>
                        </ul>
                        <ul>
                            <div class="listTitle">DÉPISTAGE CARDIO VASCULAIRE ET MÉTABOLIQUE</div>
                            <li>- Oligoscan et étude biologique</li>
                            <li>- Mesure de l’intima media</li>
                            <li>- Endopath</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <?php if (has_posts()): ?>
            <ul class="items">
                <?php posts(); ?>
                <li>
                    <article class="wrap">
                        <time
                            datetime="<?php echo date(DATE_W3C, article_time()); ?>"><?php echo relative_time(article_time()); ?></time>
                        <?php if (count(article_title()) > 1): ?>
                            <h1>
                                <a href="<?php echo article_url(); ?>"
                                   title="<?php echo article_title(); ?>"><?php echo article_title(); ?></a>
                            </h1>
                        <?php endif; ?>
                        <div class="content">
                            <?php echo article_markdown(); ?>
                        </div>

                        <footer>
                            Auteur : <?php echo article_author(); ?>
                        </footer>
                    </article>
                </li>
                <?php $i = 0;
                while (posts()): ?>
                    <?php $bg = sprintf('background: hsl(215, 28%%, %d%%);', round(((++$i / posts_per_page()) * 20) + 20)); ?>
                    <li style="<?php echo $bg; ?>">
                        <article class="wrap">
                            <h2>
                                <a href="<?php echo article_url(); ?>"
                                   title="<?php echo article_title(); ?>"><?php echo article_title(); ?></a>
                            </h2>
                        </article>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php if (has_pagination()): ?>
                <nav class="pagination">
                    <div class="wrap">
                        <?php echo posts_prev(); ?>
                        <?php echo posts_next(); ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php else: ?>
            <p>Aucun article.</p>
        <?php endif; ?>

    </section>

<?php theme_include('footer'); ?>