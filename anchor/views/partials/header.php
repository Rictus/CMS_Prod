<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <?php
    echo '<title>' . __('global.manage') . " " . Config::meta('sitename') . '</title>';

    addScriptTag('anchor/views/assets/js/zepto.js');
    addStylesheetTag('anchor/views/assets/css/reset.css');
    addStylesheetTag('anchor/views/assets/css/admin.css');
    addStylesheetTag('anchor/views/assets/css/login.css');
    addStylesheetTag('anchor/views/assets/css/notifications.css');
    addStylesheetTag('anchor/views/assets/css/forms.css');
    addStylesheetTag('anchor/views/assets/css/bootstrap-datepicker.min.css');
    addStylesheetTag('anchor/views/assets/css/bootstrap.min.css');
    addStylesheetTag('anchor/views/assets/css/small.css', '(max-width: 980px), (max-device-width: 480px)');
    ?>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=600">
</head>
<body class="<?php echo Auth::guest() ? 'login' : 'admin'; ?>">

<header class="top">
    <div class="wrap">
        <?php if (Auth::user()): ?>
            <nav>
                <ul>
                    <li class="logo">
                        <a href="<?php echo Uri::to('admin/posts'); ?>">
                            <img src="<?php asset('anchor/views/assets/img/CETI.png') ?>"
                                 alt="Logo du site de Ronald Virag">
                        </a>
                    </li>

                    <?php
                    //Old version of menu
                    $menu = array('posts', 'comments', 'pages', 'categories', 'users', 'extend');
                    //Current version
                    $menu = array('accueil', 'dossiers', 'blog', 'publications');

                    foreach ($menu as $url): ?>
                        <li <?php if (strpos(Uri::current(), $url) !== false) echo 'class="active"'; ?>>
                            <a href="<?php echo Uri::to('admin/' . $url); ?>">
                                <?php echo ucfirst(__($url . '.' . $url)); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <?php
            echo Html::link('admin/logout', __('global.logout'), array('class' => 'btn'));
            $home = Registry::get('home_page');
            echo Html::link($home->slug, __('global.visit_your_site'), array('class' => 'btn', 'target' => '_blank'));
            ?>

        <?php else: ?>
            <aside class="logo">
                <a href="<?php echo Uri::to('admin/users/login'); ?>">Anchor CMS</a>
            </aside>
        <?php endif; ?>
    </div>
</header>