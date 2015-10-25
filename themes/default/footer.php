<footer id="bottom">
    <ul>
        <?php if (has_menu_items()): ?>
        <div class="row">

            <ul>
                <?php while (menu_items()): ?>
                    <li <?php echo(menu_active() ? 'class="active"' : ''); ?>>
                        <a href="<?php echo menu_url(); ?>" title="<?php echo menu_title(); ?>">
                            <?php echo menu_name(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>

        </div>
        <div class="row">
            <ul>
                <li>
                    <a href="">Info éditeur</a>
                </li>
                <li>
                    <a href="">Mentions legales</a>
                </li>
                <li>
                    <a href="">Credits</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <ul>
                <li>
                    <a href="">Plan du site</a>
                </li>
                <li>
                    <a href="">Reseaux sociaux</a>
                </li>
            </ul>

        </div>
        <!-- /*
        <li><a href="<?php echo rss_url(); ?>">RSS DESC</a></li>
        <?php if (twitter_account()): ?>
            <li><a href="<?php echo twitter_url(); ?>">@<?php echo twitter_account(); ?></a></li>
        <?php endif; ?>
        <?php endif; ?>

        <li><a href="<?php echo base_url('admin'); ?>" title="Administer your site!">Admin">Home</a></li>
        //*/ -->
    </ul>
</footer>
</div>

</div>
</body>
</html>