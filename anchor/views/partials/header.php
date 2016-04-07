<?php
header("X-XSS-Protection: 0");
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <?php
    echo '<title>' . __('global.manage') . " " . Config::meta('sitename') . '</title>';

    addScriptTag('anchor/views/assets/js/zepto.js');
    addStylesheetTag('anchor/views/assets/css/reset.css');
    addStylesheetTag('anchor/views/assets/css/login.css');
    addStylesheetTag('anchor/views/assets/css/notifications.css');
    addStylesheetTag('anchor/views/assets/css/bootstrap-datepicker.min.css');
    addStylesheetTag('anchor/views/assets/css/bootstrap.min.css');
    addStylesheetTag('anchor/views/assets/css/small.css', '(max-width: 980px), (max-device-width: 480px)');
    addStylesheetTag('anchor/views/assets/css/admin.css');
    addStylesheetTag('anchor/views/assets/css/forms.css');
    ?>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=600">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="<?php echo Auth::guest() ? 'login' : 'admin'; ?>">

<header class="top">
    <div class="wrap">
        <?php if (Auth::user()):
            //Old version of menu
            $menu = array('posts', 'comments', 'pages', 'categories', 'users', 'extend');
            //Current version
            $menu = array('accueil', 'dossiers', 'blog', 'publications');

            $nav = "<nav><ul>";

            foreach ($menu as $url) {
                $li = "<li " . (strpos(Uri::current(), $url) !== false ? "class=active" : "") . ">";
                $li .= "<a href='" . Uri::to('admin/' . $url) . "'>" . ucfirst(__($url . '.' . $url)) . "</a>";
                $li .= "</li>";
                $nav .= $li;
            }

            $nav .= "</ul></nav>";

            echo $nav;
            ?>
            <?php
            echo Html::link('admin/logout', __('global.logout'), array('class' => 'btn'));
            $home = Registry::get('home_page');
//            echo Html::link('admin/en/', __('global.choose_language'), array('class' => 'btn'));
            echo Html::link($home->slug, __('global.visit_your_site'), array('class' => 'btn', 'target' => '_blank'));
            ?>

        <?php else: ?>
            <!--<aside class="">
                <a href="<?php /*echo Uri::to('admin/users/login'); */ ?>"><h1>Se Connecter</h1></a>
            </aside>-->
        <?php endif; ?>
    </div>
</header>