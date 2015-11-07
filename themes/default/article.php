<?php theme_include('header');
theme_include('page_utils'); ?>
    <div class="articleContainer col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 col-sm-offset-0">
        <section class="content wrap" id="article-<?php echo article_id(); ?>">

            <h1 class=""><?php echo article_title(); ?></h1>

			<?php
			echo "<time class='date' datetime=" . date(DATE_W3C, article_time()) . ">" . date('d F o', article_time()) . "</time>";
			?>

            <article>
                <?php echo article_markdown(); ?>
            </article>

            <section class="footnote">
                <!-- Unfortunately, CSS means everything's got to be inline. -->
                <!--				<p>This article is my -->
                <?php //echo numeral(total_articles()); ?><!-- oldest. It is -->
                <?php //echo count_words(article_markdown()); ?><!-- words long-->
                <?php //if(comments_open()): ?><!--, and it’s got -->
                <?php //echo total_comments() . pluralise(total_comments(), ' comment'); ?><!-- for now.-->
                <?php //endif; ?><!-- --><?php //echo article_custom_field('attribution'); ?><!--</p>-->
            </section>
        </section>
    </div>


<?php
//Some content to add after an article

switch (article_category_slug()) {
    case 'blog':
        break;
    case 'dossier':
        //Here, adding the summary
        displayDossierSummary(true);
        break;
    case 'publication':
        break;
}
?>


<?php /*if(comments_open()): */ ?><!--
		<section class="comments">
			<?php /*if(has_comments()): */ ?>
			<ul class="commentlist">
				<?php /*$i = 0; while(comments()): $i++; */ ?>
				<li class="comment" id="comment-<?php /*echo comment_id(); */ ?>">
					<div class="wrap">
						<h2><?php /*echo comment_name(); */ ?></h2>
						<time><?php /*echo relative_time(comment_time()); */ ?></time>

						<div class="content">
							<?php /*echo comment_text(); */ ?>
						</div>

						<span class="counter"><?php /*echo $i; */ ?></span>
					</div>
				</li>
				<?php /*endwhile; */ ?>
			</ul>
			<?php /*endif; */ ?>

			<form id="comment" class="commentform wrap" method="post" action="<?php /*echo comment_form_url(); */ ?>#comment">
				<?php /*echo comment_form_notifications(); */ ?>

				<p class="name">
					<label for="name">Your name:</label>
					<?php /*echo comment_form_input_name('placeholder="Your name"'); */ ?>
				</p>

				<p class="email">
					<label for="email">Your email address:</label>
					<?php /*echo comment_form_input_email('placeholder="Your email (won’t be published)"'); */ ?>
				</p>

				<p class="textarea">
					<label for="text">Your comment:</label>
					<?php /*echo comment_form_input_text('placeholder="Your comment"'); */ ?>
				</p>

				<p class="submit">
					<?php /*echo comment_form_button(); */ ?>
				</p>
			</form>

		</section>
		--><?php /*endif; */ ?>
<?php theme_include('mapContact'); ?>
<?php theme_include('footer'); ?>