<?php
setlocale(LC_ALL, 'fr_FR');
theme_include('page_utils');
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo removeTypeofproblem(page_title('Page can’t be found')); ?> - <?php echo site_name(); ?></title>

    <meta name="description" content="<?php echo site_description(); ?>">

    <link rel="stylesheet" href="<?php echo theme_url('/css/custom_font.css'); ?>">
    <link rel="stylesheet" href="<?php echo theme_url('/css/reset.css'); ?>">
    <link rel="stylesheet" href="<?php echo theme_url('/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo theme_url('/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo theme_url('/css/small.css'); ?>" media="(max-width: 400px)">

    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo rss_url(); ?>">
    <link rel="shortcut icon" href="<?php echo theme_url('img/favicon.png'); ?>">

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script>var base = '<?php echo theme_url(); ?>';</script>
    <script src="<?php echo asset_url('/js/zepto.js'); ?>"></script>
    <script src="<?php echo theme_url('/js/main.js'); ?>"></script>

    <meta name="viewport" content="width=device-width">
    <meta name="generator" content="Anchor CMS">

    <meta property="og:title" content="<?php echo site_name(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(current_url()); ?>">
    <meta property="og:image" content="<?php echo theme_url('img/og_image.gif'); ?>">
    <meta property="og:site_name" content="<?php echo site_name(); ?>">
    <meta property="og:description" content="<?php echo site_description(); ?>">

    <?php if (customised()): ?>
        <!-- Custom CSS -->
        <style><?php echo article_css(); ?></style>

        <!--  Custom Javascript -->
        <script><?php echo article_js(); ?></script>
    <?php endif; ?>
    <link rel="stylesheet" href=<?php echo "/themes/default/css/main_overwrite.css" ?>>
</head>
<body class="<?php echo body_class(); ?>">
<div class="main-wrap">
    <header id="top">
        <div class="logo">
            <a class="logo-img" href="<?php echo Uri::to('/'); ?>">
                <img src="<?php echo asset_url('/img/CETI.png') ?>"
                     alt="Logo du site de Ronald Virag">
            </a>

            <div class="headline">Sous la direction du Docteur Ronald Virag
                <div class="underHeadline">
                    Membre de l’académie Nationale de Chirurgie
                </div>
            </div>

        </div>

        <?php if (has_menu_items()): ?>
            <nav id="main" role="navigation">
                <ul>
                    <?php while (menu_items()): ?>
                        <li <?php echo(menu_active() ? 'class="active"' : ''); ?>>
                            <a href="<?php echo menu_url(); ?>" title="<?php echo menu_title(); ?>">
                                <?php echo menu_name(); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </header>