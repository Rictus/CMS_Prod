<?php

/**
 * Important pages
 */
$home_page = Registry::get('home_page');
$posts_page = Registry::get('posts_page');
/**
 * The Home page
 */
if ($home_page->id != $posts_page->id) {
    Route::get(array('/', $home_page->slug), function () use ($home_page) {
        Registry::set('page', $home_page);
        return new Template('page');
    });
}

/**
 * Post listings page
 */
$routes = array($posts_page->slug, $posts_page->slug . '/(:num)');

if ($home_page->id == $posts_page->id) {
    array_unshift($routes, '/');
}

Route::get($routes, function ($offset = 1) use ($posts_page) {
    $catch = array();
    $team = array();
    if ($offset > 0) {
        // get public listings
        list($total, $posts) = Post::listing(null, $offset, $per_page = Config::meta('posts_per_page'));
    } else {
        return Response::create(new Template('404'), 404);
    }

    // get the last page
    $max_page = ($total > $per_page) ? ceil($total / $per_page) : 1;

    // stop users browsing to non existing ranges
    if (($offset > $max_page) or ($offset < 1)) {
        return Response::create(new Template('404'), 404);
    }


    list($nbPosts, $postsAccueil) = Post::listing(Category::slug('accueil'), $offset, 1000);


    for ($i = 0; $i < count($postsAccueil); $i++) {
        $postId = $postsAccueil[$i]->data["id"];
        $teammembername_extend = Extend::value(Extend::field('post', 'teammembername', $postId));
        $teammemberjob_extend = Extend::value(Extend::field('post', 'teammemberjob', $postId));
        $catchphrase_extend = Extend::value(Extend::field('post', 'catchphrase', $postId));
        $catchimage_extend = Extend::value(Extend::field('post', 'catchimage', $postId));

        //Get team
        if (!is_null($teammembername_extend) && !is_null($teammemberjob_extend)) {
            $postsAccueil[$i]->data['teammembername'] = $teammembername_extend;
            $postsAccueil[$i]->data['teammemberjob'] = $teammemberjob_extend;
            $team[] = $postsAccueil[$i];
        } //Get catch
        else if (!is_null($catchimage_extend) && !is_null($catchphrase_extend)) {
            $catch['catchphrase'] = $catchphrase_extend;
            $catch['catchimage'] = $catchimage_extend;
        }
    }

    // get books
    list($nbPubli, $publications) = Post::listing(Category::slug('publication'), 1, 1000);
    $books = array();
    for ($i = 0; $i < $nbPubli; $i++) {
        $publiId = $publications[$i]->data['id'];
        $typeOfPublication = Extend::value(Extend::field('post', 'typeofpublication', $publiId));
        if ($typeOfPublication == "book") {
            $publications[$i]->data['bookimage'] = Extend::value(Extend::field('post', 'bookimage', $publiId));
            $publications[$i]->data['externallink'] = Extend::value(Extend::field('post', 'externallink', $publiId));
            $books[] = $publications[$i];
        }
    }

    //get biographie infos
    $biopage = Page::slug('biographie');
    Registry::set('bioimage', Extend::value(Extend::field('page', 'bioimage', $biopage->id)));
    Registry::set('biofirstpart', Extend::value(Extend::field('page', 'biofirstpart', $biopage->id)));
    Registry::set('biosecondpart', Extend::value(Extend::field('page', 'biosecondpart', $biopage->id)));
    Registry::set('biothirdpart', Extend::value(Extend::field('page', 'biothirdpart', $biopage->id)));

    // get last post from blog
    list($nbBlogPost, $blogPosts) = Post::listing(Category::slug('blog'), 1, 1000);
    if($nbBlogPost>0)
        $lastBlogPost = $blogPosts[0]; //Normally, the first one should be the most recent article cause ::listing search in db and sort result
    else
        $lastBlogPost = false;

    $posts = new Items($posts);

    Registry::set('books', $books);
    Registry::set('team', $team);
    Registry::set('posts', $posts);
    Registry::set('catch', $catch);
    Registry::set('lastBlogPost', $lastBlogPost);
    Registry::set('total_posts', $total);
    Registry::set('page', $posts_page);
    Registry::set('page_offset', $offset);

    return new Template('posts');
});

/**
 * View posts by category
 */
Route::get(array('category/(:any)', 'category/(:any)/(:num)'), function ($slug = '', $offset = 1) use ($posts_page) {
    if (!$category = Category::slug($slug)) {
        return Response::create(new Template('404'), 404);
    }

    // get public listings
    list($total, $posts) = Post::listing($category, $offset, $per_page = Config::meta('posts_per_page'));

    // get the last page
    $max_page = ($total > $per_page) ? ceil($total / $per_page) : 1;

    // stop users browsing to non existing ranges
    if (($offset > $max_page) or ($offset < 1)) {
        return Response::create(new Template('404'), 404);
    }

    $posts = new Items($posts);

    Registry::set('posts', $posts);
    Registry::set('total_posts', $total);
    Registry::set('page', $posts_page);
    Registry::set('page_offset', $offset);
    Registry::set('post_category', $category);

    return new Template('posts');
});

/**
 * Redirect by article ID
 */
Route::get('(:num)', function ($id) use ($posts_page) {
    if (!$post = Post::id($id)) {
        return Response::create(new Template('404'), 404);
    }

    return Response::redirect($posts_page->slug . '/' . $post->data['slug']);
});


/**
 * View article
 */
Route::get($posts_page->slug . '/(:any)', function ($slug) use ($posts_page) {
    if (!$post = Post::slug($slug)) {
        return Response::create(new Template('404'), 404);
    }

    $dossierCategory = Category::slug('dossier');

    if ($post->data['category'] == $dossierCategory->data["id"]) {
        list($nbPosts, $posts) = Post::listing($dossierCategory, 1, 10000);
        //Get all extends for each post
        for ($i = 0; $i < count($posts); $i++) {
            $e = Extend::fields('post', $posts[$i]->id);
            $newExtendObj = array();
            for ($j = 0; $j < count($e); $j++) {
                $key = $e[$j]->key;
                if (property_exists($e[$j]->value, 'text')) {
                    $value = $e[$j]->value->text;
                    $newExtendObj[$key] = $value;
                }
            }
            $posts[$i]->extends = $newExtendObj;
        }
        Registry::set('posts', $posts);
    }

    Registry::set('page', $posts_page);
    Registry::set('article', $post);
    Registry::set('category', Category::find($post->category));

    return new Template('article');
});

/**
 * Post a comment
 */
Route::post($posts_page->slug . '/(:any)', function ($slug) use ($posts_page) {
    if (!$post = Post::slug($slug) or !$post->comments) {
        return Response::create(new Template('404'), 404);
    }

    $input = filter_var_array(Input::get(array('name', 'email', 'text')), array(
        'name' => FILTER_SANITIZE_STRING,
        'email' => FILTER_SANITIZE_EMAIL,
        'text' => FILTER_SANITIZE_SPECIAL_CHARS
    ));

    $validator = new Validator($input);

    $validator->check('email')
        ->is_email(__('comments.email_missing'));

    $validator->check('text')
        ->is_max(3, __('comments.text_missing'));

    if ($errors = $validator->errors()) {
        Input::flash();

        Notify::error($errors);

        return Response::redirect($posts_page->slug . '/' . $slug . '#comment');
    }

    $input['post'] = Post::slug($slug)->id;
    $input['date'] = Date::mysql('now');
    $input['status'] = Config::meta('auto_published_comments') ? 'approved' : 'pending';

    // remove bad tags
    $input['text'] = strip_tags($input['text'], '<a>,<b>,<blockquote>,<code>,<em>,<i>,<p>,<pre>');

    // check if the comment is possibly spam
    if ($spam = Comment::spam($input)) {
        $input['status'] = 'spam';
    }

    $comment = Comment::create($input);

    Notify::success(__('comments.created'));

    // dont notify if we have marked as spam
    if (!$spam and Config::meta('comment_notifications')) {
        $comment->notify();
    }

    return Response::redirect($posts_page->slug . '/' . $slug . '#comment');
});

/**
 * Rss feed
 */
Route::get(array('rss', 'feeds/rss'), function () {
    $uri = 'http://' . $_SERVER['HTTP_HOST'];
    $rss = new Rss(Config::meta('sitename'), Config::meta('description'), $uri, Config::app('language'));

    $query = Post::where('status', '=', 'published')->sort(Base::table('posts.created'), 'desc');

    foreach ($query->get() as $article) {
        $rss->item(
            $article->title,
            Uri::full(Registry::get('posts_page')->slug . '/' . $article->slug),
            $article->description,
            $article->created
        );
    }

    $xml = $rss->output();

    return Response::create($xml, 200, array('content-type' => 'application/xml'));
});

/**
 * Json feed
 */
Route::get('feeds/json', function () {
    $json = Json::encode(array(
        'meta' => Config::get('meta'),
        'posts' => Post::where('status', '=', 'published')->sort(Base::table('posts.created'), 'desc')->get()
    ));

    return Response::create($json, 200, array('content-type' => 'application/json'));
});

/**
 * Search
 */
Route::get(array('search', 'search/(:any)', 'search/(:any)/(:num)'), function ($slug = '', $offset = 1) {
    // mock search page
    $page = new Page;
    $page->id = 0;
    $page->title = 'Search';
    $page->slug = 'search';

    // get search term
    $term = filter_var($slug, FILTER_SANITIZE_STRING);
    Session::put(slug($term), $term);
    //$term = Session::get($slug); //this was for POST only searches

    // revert double-dashes back to spaces
    $term = str_replace('--', ' ', $term);

    if ($offset > 0) {
        list($total, $posts) = Post::search($term, $offset, Config::meta('posts_per_page'));
    } else {
        return Response::create(new Template('404'), 404);
    }

    // search templating vars
    Registry::set('page', $page);
    Registry::set('page_offset', $offset);
    Registry::set('search_term', $term);
    Registry::set('search_results', new Items($posts));
    Registry::set('total_posts', $total);

    return new Template('search');
});

Route::post('search', function () {
    // search and save search ID
    $term = filter_var(Input::get('term', ''), FILTER_SANITIZE_STRING);

    // replace spaces with double-dash to pass through url
    $term = str_replace(' ', '--', $term);

    Session::put(slug($term), $term);

    return Response::redirect('search/' . slug($term));
});


/**
 * Dossier page
 */

/**
 * Publication Page
 */
Route::get(array('dossier', 'dossier/(:any)'), function ($pageNumber = 1) {
    $page = Page::slug('dossier');
    $category = Category::slug('dossier');
    $per_page = Config::meta('posts_per_page');

    list($total, $posts) = Post::listing($category, $pageNumber, $per_page);

//     get the last page
    $max_page = ($total > $per_page) ? ceil($total / $per_page) : 1;

    // stop users browsing to non existing ranges
    if (($pageNumber > $max_page) or ($pageNumber < 1)) {
        return Response::create(new Template('404'), 404);
    }

    //Get extend for each post
    for ($i = 0; $i < count($posts); $i++) {
        $e = Extend::fields('post', $posts[$i]->id);
        $newExtendObj = array();
        for ($j = 0; $j < count($e); $j++) {
            $key = $e[$j]->key;
            if (property_exists($e[$j]->value, 'text')) {
                $value = $e[$j]->value->text;
                $newExtendObj[$key] = $value;
            } else {
//                echo "special case h43442";
//                die();
            }
        }
        $posts[$i]->extends = $newExtendObj;
    }


    Registry::set('posts', $posts);
    Registry::set('page', $page);
    Registry::set('category', $category);
    Registry::set('total_posts', $total);
    Registry::set('maxPageNumber', $max_page);
    Registry::set('currentPageNumber', $pageNumber);

    return new Template('page');
});

/**
 * Publication Page
 */
Route::get(array('publication', 'publication/(:any)'), function ($pageNumber = 1) {
    $page = Page::slug('publication');
    $category = Category::slug('publication');
    $per_page = Config::meta('posts_per_page');
    list($total, $posts) = Post::listing($category, $pageNumber, $per_page);

//     get the last page
    $max_page = ($total > $per_page) ? ceil($total / $per_page) : 1;

    // stop users browsing to non existing ranges
    if (($pageNumber > $max_page) or ($pageNumber < 1)) {
        return Response::create(new Template('404'), 404);
    }

    //Get extend for each post
    for ($i = 0; $i < count($posts); $i++) {
        $e = Extend::fields('post', $posts[$i]->id);
        $newExtendObj = array();
        for ($j = 0; $j < count($e); $j++) {
            $key = $e[$j]->key;

            if (is_null($e[$j]->value) || !property_exists($e[$j]->value, 'text')) {
                $value = $e[$j]->value;
            } else {
                $value = $e[$j]->value->text;
            }
            $newExtendObj[$key] = $value;
        }
        $posts[$i]->extends = $newExtendObj;
    }


    Registry::set('posts', $posts);
    Registry::set('page', $page);
    Registry::set('category', $category);
    Registry::set('total_posts', $total);
    Registry::set('maxPageNumber', $max_page);
    Registry::set('currentPageNumber', $pageNumber);

    return new Template('page');
});


/**
 * Blog Page
 */
Route::get(array('blog', 'blog/(:any)'), function ($pageNumber = 1) {
    $page = Page::slug('blog');
    $category = Category::slug('blog');
    $per_page = Config::meta('posts_per_page');

    list($total, $posts) = Post::listing($category, $pageNumber, $per_page);

//     get the last page
    $max_page = ($total > $per_page) ? ceil($total / $per_page) : 1;

    // stop users browsing to non existing ranges
    if (($pageNumber > $max_page) or ($pageNumber < 1)) {
        return Response::create(new Template('404'), 404);
    }

    Registry::set('posts', $posts);
    Registry::set('page', $page);
    Registry::set('category', $category);
    Registry::set('total_posts', $total);
    Registry::set('maxPageNumber', $max_page);
    Registry::set('currentPageNumber', $pageNumber);

    return new Template('page');
});

/**
 * View pages
 */
Route::get('(:all)', function ($uri) {
    $offset = 1;
    $pageNumber = 1;
    $page = Page::slug($slug = basename($uri));
    Registry::set('page', $page);
    $category = Category::slug($slug);
    $per_page = Config::meta('posts_per_page');

    list($total, $posts) = Post::listing($category, $pageNumber, $per_page);

//     get the last page
    $max_page = ($total > $per_page) ? ceil($total / $per_page) : 1;

    // stop users browsing to non existing ranges
    if (($offset > $max_page) or ($offset < 1)) {
        return Response::create(new Template('404'), 404);
    }

//    $posts = new Items($posts);

    Registry::set('posts', $posts);
    Registry::set('total_posts', $total);
    Registry::set('page_offset', $pageNumber);
    Registry::set('pageid', $page->data['id']);
    Registry::set('category', $category);

    return new Template('page');
});