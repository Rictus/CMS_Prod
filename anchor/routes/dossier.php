<?php


Route::collection(array('before' => 'auth'), function () {

    /*
        Edit post
    */
    Route::get('admin/dossiers/edit/(:num)', function ($id) {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['article'] = Post::find($id);
        $vars['page'] = Registry::get('posts_page');

        // extended fields
        $vars['fields'] = Extend::fields('post', $id);
        $vars['statuses'] = array(
            'published' => __('global.published'),
            'draft' => __('global.draft'),
            'archived' => __('global.archived')
        );

        $vars['categories'] = Category::dropdown();

        return View::create('dossiers/edit', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer')
            ->partial('editor', 'partials/editor');
    });

    Route::post('admin/dossiers/edit/(:num)', function ($id) {
        $currentPageCategoryId = getCurrentPageCategoryId('dossier');
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'category', 'status', 'comments'));


        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['category'] = $currentPageCategoryId;

        // encode title
        $input['title'] = e($input['title'], ENT_COMPAT);


        $extend = Input::get(array('extend'));
        $typeofproblem = $extend['extend']['typeofproblem'];

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
        // if there is no slug, create one from title
        if (empty($input['slug'])) {
            $input['slug'] = slug($input['title']);
        }
        // convert to ascii
        $input['slug'] = slug($input['slug']);
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

        return Response::redirect('admin/dossiers/edit/' . $id);
    });

    /*
        Add new post
    */
    Route::get('admin/dossiers/add', function () {
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

        return View::create('dossiers/add', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer')
            ->partial('editor', 'partials/editor');
    });

    Route::post('admin/dossiers/add', function () {
        $currentPageCategoryId = getCurrentPageCategoryId('dossier');
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'status', 'comments'));


        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['category'] = $currentPageCategoryId;


        // convert to ascii
        $input['slug'] = slug($input['slug']);

        // encode title
        $input['title'] = e($input['title'], ENT_COMPAT);

        $extend = Input::get(array('extend'));
        $typeofproblem = $extend['extend']['typeofproblem'];

        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) {
            return Post::where('slug', '=', $str)->count() == 0;
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
        // if there is no slug try and create one from title
        if (empty($input['slug'])) {
            $input['slug'] = slug($input['title']);
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
            ->not_regex('#^[0-9_-]+$#', __('posts.slug_invalid'));


        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);

            return Response::redirect('admin/dossiers/add');
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

        Notify::success(__('posts.created'));

        return Response::redirect('admin/dossiers');
    });

    /*
        Preview post
    */
    Route::post('admin/dossiers/preview', function () {
        $html = Input::get('html');

        // apply markdown processing
        $md = new Markdown;
        $output = Json::encode(array('html' => $md->transform($html)));

        return Response::create($output, 200, array('content-type' => 'application/json'));
    });

    /*
        Delete post
    */
    Route::get('admin/dossiers/delete/(:num)', function ($id) {
        Post::find($id)->delete();

        Comment::where('post', '=', $id)->delete();

        Query::table(Base::table('post_meta'))->where('post', '=', $id)->delete();

        Notify::success(__('posts.deleted'));

        return Response::redirect('admin/dossiers');
    });
    /*
    Upload a image
    */
    Route::post('admin/(pages|posts)/upload', function () {
        $uploader = new Uploader(PATH . 'content', array('png', 'jpg', 'bmp', 'gif'));
        $file = $_FILES['upload'];
        $filepath = $uploader->upload($file);

        //        $uri = Config::app('url', '/') . '/content/' . basename($filepath);
        $uri = '/content/' . basename($filepath);
        $output = array('uploaded' => 1, 'url' => $uri, 'fileName' => $file['name']);

        return Response::json($output);
    });


    /*
        List all posts and paginate through them
    */
    Route::get(array('admin/dossiers', 'admin/dossiers/(:num)', 'admin/dossiers/(:num)/(:any)'), function ($page = 1, $lang = 'all') {
        $lang = ($lang == 'fr' || $lang == 'en' || $lang = 'all') ? $lang : 'all';
        $currentPageCategoryId = getCurrentPageCategoryId('dossier');
        $url = Uri::to('admin/dossiers');
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

        return View::create('dossiers/index', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

});
//
//
//{
//	"uploaded": 1,
//    "fileName": "foo.jpg",
//    "url": "/files/foo.jpg"
//}