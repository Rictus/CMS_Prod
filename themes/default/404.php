<?php theme_include('header'); ?>

    <section class="content wrap">
        <h1>Page not found</h1>

        <p>Unfortunately, the page <code>/<?php echo current_url(); ?></code> could not be found. Your best bet is
            either to try the <a href="<?php echo base_url(); ?>">homepage</a>
    </section>

<?php
theme_include('mapContact');
theme_include('footer');
?>