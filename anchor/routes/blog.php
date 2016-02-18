<?php

Route::collection(array('before' => 'auth'), function () {

    /*
        List all posts and paginate through them
    */
    Route::get(array('admin/blog', 'admin/blog/(:num)', 'admin/blog/(:num)/(:any)'), function ($page = 1, $lang = 'all') {
        $lang = ($lang == 'fr' || $lang == 'en' || $lang = 'all') ? $lang : 'all';
        $currentPageCategoryId = getCurrentPageCategoryId('blog');
        $url = Uri::to('admin/blog');
        $perpage = Config::meta('posts_per_page');
        $allPosts = Post::where('category', '=', $currentPageCategoryId)->sort('created', 'asc')->get();
        $allPostsSelectedLanguage = [];
        $curPagePosts = [];
        $indexFirstOk = ($page - 1) * $perpage;
        $indexLastOk = $indexFirstOk + $perpage;

        for ($i = 0; $i < count($allPosts); $i++) { //Getting all posts for selected language
            $allPosts[$i]->targetlanguage = Extend::value(Extend::field('post', 'targetlanguage', $allPosts[$i]->id));
            if ($lang == 'all' || $allPosts[$i]->targetlanguage == $lang) {
                $allPostsSelectedLanguage[] = $allPosts[$i];
            }
        }

        $i = $indexFirstOk;
        while ($i < count($allPostsSelectedLanguage) && $i < $indexLastOk) { //Getting all posts for current page
            $curPagePosts[] = $allPostsSelectedLanguage[$i];
            $i++;
        }
        $pagination = new Paginator($curPagePosts, count($allPostsSelectedLanguage), $page, $perpage, $url, $lang);
        $vars['messages'] = Notify::read();
        $vars['posts'] = $pagination;
        $vars['categories'] = Category::sort('title')->get();
        $vars['choosenlanguage'] = $lang;

        return View::create('blog/index', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

    /*
        Add new blog post
    */
    Route::get('admin/blog/add', function () {
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

        return View::create('blog/add', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer')
            ->partial('editor', 'partials/editor');
    });
    Route::post('admin/blog/add', function () {
        $currentPageCategoryId = getCurrentPageCategoryId('blog');
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
            ->not_regex('#^[0-9_-]+$#', __('blog.slug_invalid'));


        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);

            return Response::redirect('admin/blog/add');
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
        Notify::success(__('blog.created'));

        return Response::redirect('admin/blog');
    });


    /*
           Delete post
       */
    Route::get('admin/blog/delete/(:num)', function ($id) {
        Post::find($id)->delete();

        Comment::where('post', '=', $id)->delete();

        Query::table(Base::table('post_meta'))->where('post', '=', $id)->delete();

        Notify::success(__('posts.deleted'));

        return Response::redirect('admin/blog');
    });


    /*
        Edit post
    */
    Route::get('admin/blog/edit/(:num)', function ($id) {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['post'] = Post::find($id);
        $vars['page'] = Registry::get('posts_page');

        // extended fields
        $vars['fields'] = Extend::fields('post', $id);

        $vars['statuses'] = array(
            'published' => __('global.published'),
            'draft' => __('global.draft'),
            'archived' => __('global.archived')
        );

        return View::create('blog/edit', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer')
            ->partial('editor', 'partials/editor');
    });

    Route::post('admin/blog/edit/(:num)', function ($id) {
        $currentPageCategoryId = getCurrentPageCategoryId('blog');
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'category', 'status', 'comments'));


        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['category'] = $currentPageCategoryId;

        // encode title
        $input['title'] = e($input['title'], ENT_COMPAT);

        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) use ($id) {
            return Post::where('slug', '=', $str)->where('id', '<>', $id)->count() == 0;
        });


        if (is_null($input['description']) || empty($input['description'])) {
            $input['description'] = " ";
        }
        if (is_null($input['css']) || empty($input['css'])) {
            $input['css'] = " ";
        }
        if (is_null($input['js']) || empty($input['js'])) {
            $input['js'] = " ";
        }

        $input['slug'] = slug($input['title']);
        do {
            //Check for duplication
            $isDuplicate = Post::where('slug', '=', $input['slug'])->where('id', '<>', $id)->count() > 0;
            if ($isDuplicate) {
                $input['slug'] = slug(noise(10));
            }
        } while ($isDuplicate);

        $validator->check('slug')
            ->not_regex('#^[0-9_-]+$#', __('posts.slug_invalid'));

        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);

            return Response::redirect('admin/dossiers/edit/' . $id);
        }

        if ($input['created']) {
            $input['created'] = Date::mysql($input['created']);
        } else {
            unset($input['created']);
        }

        if (is_null($input['comments'])) {
            $input['comments'] = 0;
        }

        Post::update($id, $input);

        Extend::process('post', $id);

        Notify::success(__('posts.updated'));

        return Response::redirect('admin/blog/edit/' . $id);
    });


});