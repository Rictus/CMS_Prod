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


    /*
        Add new book
    */
    Route::get('admin/publications/addBook', function () {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['page'] = Registry::get('posts_page');

        // extended fields
        $vars['fields'] = Extend::fields('post');


        $vars['statuses'] = array(
            'published' => __('global.published'),
            'draft' => __('global.draft'),
            'archived' => __('global.archived')
        );

        $vars['categories'] = Category::dropdown();

        return View::create('publications/addBook', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer')
            ->partial('editor', 'partials/editor');
    });


    Route::post('admin/publications/addBook', function () {
        $currentPageCategoryId = getCurrentPageCategoryId('publication');
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'status', 'comments'));

        $extends = Input::get(array('extend'));

        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['category'] = $currentPageCategoryId;


        // convert to ascii
        $input['slug'] = slug($input['slug']);

        // encode title
        $input['title'] = e($input['title'], ENT_COMPAT);

        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) {
            return Post::where('slug', '=', $str)->count() == 0;
        });

        if (is_null($input['description']) || empty($input['description'])) {
            $input['description'] = " ";
        }
        if (is_null($input['html']) || empty($input['html'])) {
            $input['html'] = " ";
        }
        if (is_null($input['css']) || empty($input['css'])) {
            $input['css'] = " ";
        }
        if (is_null($input['js']) || empty($input['js'])) {
            $input['js'] = " ";
        }
        // if there is no slug try and create one from title
        if (empty($input['slug'])) {
            $input['slug'] = $input['title'];
        }
        // convert to ascii
        $input['slug'] = slug($input['slug']);

        do {
            //Check for duplication
            $isDuplicate = Post::where('slug', '=', $input['slug'])->count() > 0;
            if ($isDuplicate) {
                $input['slug'] = slug(noise(10));
            }
        } while ($isDuplicate);

        $validator->check('slug')
            ->not_regex('#^[0-9_-]+$#', __('publications.slug_invalid'));


        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);

            return Response::redirect('admin/publications/addBook');
        }

        if (empty($input['created'])) {
            $input['created'] = Date::mysql('now');
        }

        $user = Auth::user();

        $input['author'] = $user->id;

        if (is_null($input['comments'])) {
            $input['comments'] = 0;
        }


        $post = Post::create($input);

        Extend::process('post', $post->id);
        Notify::success(__('publications.created_book'));

        return Response::redirect('admin/publications');
    });


});