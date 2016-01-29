<?php
theme_include('header');
switch (page_slug()) {
    case 'blog':
        echo page_content();
        displayBlogPostsPreview();
        break;
    case 'dossier':
        echo page_content();
        displayDossierSummary(false);
        break;
    case 'publication':
        echo page_content();
        theme_include("publication");
        break;
}

theme_include('mapContact');
theme_include('footer');
?>