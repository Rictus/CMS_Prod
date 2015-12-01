<?php

Route::collection(array('before' => 'auth'), function () {

    /*
        List all posts and paginate through them
    */
    Route::get(array('admin/publications', 'admin/publications/(:num)'), function ($page = 1) {
        $currentPageCategoryId = getCurrentPageCategoryId('publication');
        $perpage = Config::meta('posts_per_page');
        $total = Post::where('category', '=', $currentPageCategoryId)->count();
        $posts = Post::where('category', '=', $currentPageCategoryId)->sort('created', 'desc')->take($perpage)->skip(($page - 1) * $perpage)->get();
        $url = Uri::to('admin/publications');

        //Doing something
        $pagination = new Paginator($posts, $total, $page, $perpage, $url);

        $vars['messages'] = Notify::read();
        $vars['posts'] = $pagination;
        $vars['categories'] = Category::sort('title')->get();

        return View::create('publications/index', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

});