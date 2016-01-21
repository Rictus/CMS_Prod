<?php


Route::collection(array('before' => 'auth'), function () {

    /**
     * Main page
     */
    Route::get('admin/accueil', function () {
        $currentPageCategoryId = getCurrentPageCategoryId('accueil');
        $biopage = Page::slug('biographie');
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['page'] = Registry::get('posts_page');
        $vars['biopage'] = $biopage;
        $vars['team'] = array();
        $vars['accroche'] = false;
        $postsAccueil = Post::where('category', '=', $currentPageCategoryId)->sort('created','asc')->get();
        for ($i = 0; $i < count($postsAccueil); $i++) {
            $memberId = $postsAccueil[$i]->data["id"];
            $teammembername_extend = Extend::value(Extend::field('post', 'teammembername', $memberId));
            $teammemberjob_extend = Extend::value(Extend::field('post', 'teammemberjob', $memberId));
            $catchphrase_extend = Extend::value(Extend::field('post', 'catchphrase', $memberId));
            $catchimage_extend = Extend::value(Extend::field('post', 'catchimage', $memberId));
            if (!is_null($teammembername_extend) && !is_null($teammemberjob_extend)) {
                $postsAccueil[$i]->data['teammembername'] = $teammembername_extend;
                $postsAccueil[$i]->data['teammemberjob'] = $teammemberjob_extend;
                $vars['team'][] = $postsAccueil[$i];
            } else if (!is_null($catchimage_extend) && !is_null($catchphrase_extend)) {
                $postsAccueil[$i]->data['catchphrase'] = $catchphrase_extend;
                $postsAccueil[$i]->data['catchimage'] = $catchimage_extend;
                $vars['accroche'] = $postsAccueil[$i];
            }
        }

        $vars['bioimage'] = Extend::value(Extend::field('page', 'bioimage', $biopage->id));
        $vars['biofirstpart'] = Extend::value(Extend::field('page', 'biofirstpart', $biopage->id));
        $vars['biosecondpart'] = Extend::value(Extend::field('page', 'biosecondpart', $biopage->id));
        $vars['biothirdpart'] = Extend::value(Extend::field('page', 'biothirdpart', $biopage->id));

        return View::create('accueil/index', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

    /**
     * Team Member
     */
    Route::get('admin/accueil/addTeamMember', function () {
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

        return View::create('accueil/addTeamMember', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });


    Route::post('admin/accueil/addTeamMember', function () {
        $currentPageCategoryId = getCurrentPageCategoryId('accueil');
        $user = Auth::user();
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'category', 'status', 'comments'));

        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['status'] = 'published';
        $input['title'] = "";
        $input['description'] = "";
        $input['css'] = "";
        $input['html'] = "";
        $input['js'] = "";
        $input['slug'] = slug($input['slug']);
        $input['comments'] = 0;
        $input['author'] = $user->id;
        $input['category'] = $currentPageCategoryId;

        do {
            //Check for duplication
            $isDuplicate = Post::where('slug', '=', $input['slug'])->count() > 0;
            if ($isDuplicate) {
                $input['slug'] = slug(noise(10));
            }
        } while ($isDuplicate);


        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) {
            return Post::where('slug', '=', $str)->count() == 0;
        });

        $validator->check('slug')
            ->not_regex('#^[0-9_-]+$#', __('posts.slug_invalid'));


        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);

            return Response::redirect('admin/posts/addTeamMember');
        }

        if (empty($input['created'])) {
            $input['created'] = Date::mysql('now');
        }
        $post = Post::create($input);

        Extend::process('post', $post->id);

        Notify::success(__('accueil.TeamMemberCreated'));

        return Response::redirect('admin/accueil');
    });

    Route::get('admin/accueil/editTeamMember/(:num)', function ($id) {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['member'] = Post::find($id);
        $vars['page'] = Registry::get('posts_page');

        // extended fields
        $vars['fields'] = Extend::fields('post', $id);

        $vars['statuses'] = array(
            'published' => __('global.published'),
            'draft' => __('global.draft'),
            'archived' => __('global.archived')
        );


        return View::create('accueil/editTeamMember', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

    Route::post('admin/accueil/editTeamMember/(:num)', function ($id) {
        $currentPageCategoryId = getCurrentPageCategoryId('accueil');
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'category', 'status', 'comments'));


        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['status'] = 'published';
        $input['title'] = "";
        $input['description'] = "";
        $input['css'] = "";
        $input['html'] = "";
        $input['js'] = "";
        $input['comments'] = 0;
        $input['category'] = $currentPageCategoryId;

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

            return Response::redirect('admin/accueil/editTeamMember/' . $id);
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

        Notify::success(__('accueil.teamMemberUpdated'));

        return Response::redirect('admin/accueil/editTeamMember/' . $id);
    });

    Route::get('admin/accueil/deleteTeamMember/(:num)', function ($id) {
        Post::find($id)->delete();

        Comment::where('post', '=', $id)->delete();

        Query::table(Base::table('post_meta'))->where('post', '=', $id)->delete();

        Notify::success(__('accueil.teamMemberDeleted'));

        return Response::redirect('admin/accueil');
    });


    /**
     * Accroche
     */
    Route::get('admin/accueil/addCatch', function () {
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

        return View::create('accueil/addCatch', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

    Route::post('admin/accueil/addCatch', function () {
        $currentPageCategoryId = getCurrentPageCategoryId('accueil');
        $user = Auth::user();
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'category', 'status', 'comments'));

        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['status'] = 'published';
        $input['title'] = "";
        $input['description'] = "";
        $input['css'] = "";
        $input['html'] = "";
        $input['js'] = "";
        $input['slug'] = slug($input['slug']);
        $input['comments'] = 0;
        $input['author'] = $user->id;
        $input['category'] = $currentPageCategoryId;

        do {
            //Check for duplication
            $isDuplicate = Post::where('slug', '=', $input['slug'])->count() > 0;
            if ($isDuplicate) {
                $input['slug'] = slug(noise(10));
            }
        } while ($isDuplicate);


        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) {
            return Post::where('slug', '=', $str)->count() == 0;
        });

        $validator->check('slug')
            ->not_regex('#^[0-9_-]+$#', __('posts.slug_invalid'));


        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);

            return Response::redirect('admin/posts/addCatch');
        }

        if (empty($input['created'])) {
            $input['created'] = Date::mysql('now');
        }
        $post = Post::create($input);

        Extend::process('post', $post->id);

        Notify::success(__('accueil.created_catch'));

        return Response::redirect('admin/accueil');
    });

    Route::get('admin/accueil/editCatch/(:num)', function ($id) {
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

        $vars['categories'] = Category::dropdown();

        return View::create('accueil/editCatch', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer')
            ->partial('editor', 'partials/editor');
    });

    Route::post('admin/accueil/editCatch/(:num)', function ($id) {
        $currentPageCategoryId = getCurrentPageCategoryId('accueil');
        $input = Input::get(array('title', 'slug', 'description', 'created',
            'html', 'css', 'js', 'category', 'status', 'comments'));


        /** Valeurs en dur **/
        $input['comments'] = 0;
        $input['status'] = 'published';
        $input['title'] = "";
        $input['description'] = "";
        $input['css'] = "";
        $input['html'] = "";
        $input['js'] = "";
        $input['comments'] = 0;
        $input['category'] = $currentPageCategoryId;

        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) use ($id) {
            return Post::where('slug', '=', $str)->where('id', '<>', $id)->count() == 0;
        });

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

            return Response::redirect('admin/accueil/editCatch/' . $id);
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

        Notify::success(__('accueil.catchUpdated'));

        return Response::redirect('admin/accueil/editCatch/' . $id);
    });


    /**
     * Bio
     */
    Route::get(array('admin/accueil/addBio', 'admin/accueil/editBio'), function () {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['page'] = Registry::get('posts_page');
        $biopage = Page::slug('biographie');
        $vars['biopage'] = $biopage;

        // extended fields
        $vars['fields'] = Extend::fields('post');
        $vars['page_fields'] = array();
        $vars['page_fields']['bioimage'] = Extend::field('page', 'bioimage', $biopage->id);
        $vars['page_fields']['biofirstpart'] = Extend::field('page', 'biofirstpart', $biopage->id);
        $vars['page_fields']['biosecondpart'] = Extend::field('page', 'biosecondpart', $biopage->id);
        $vars['page_fields']['biothirdpart'] = Extend::field('page', 'biothirdpart', $biopage->id);

        $vars['statuses'] = array(
            'published' => __('global.published'),
            'draft' => __('global.draft'),
            'archived' => __('global.archived')
        );

        $vars['categories'] = Category::dropdown();

        return View::create('accueil/editBio', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });


    Route::post(array('admin/accueil/addBio', 'admin/accueil/editBio'), function () {
        $page = Page::slug('biographie');

        Extend::process('page', $page->id);

        Notify::success(__('accueil.updated_bio'));

        return Response::redirect('admin/accueil');
    });

    /**
     * Person infos
     */
    Route::get('admin/accueil/editInfo/(:any)', function ($key) {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();

        $vars['variableInfo'] = Query::table(Base::table('meta'))->where('key', '=', $key)->fetch();

        return View::create('accueil/editInfo', $vars)
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });

    Route::post('admin/accueil/editInfo/(:any)', function ($key) {
        $input = Input::get(array('value'));

        Query::table(Base::table('meta'))->where('key', '=', $key)->update($input);

        Notify::success(__('accueil.updated_info'));

        return Response::redirect('admin/accueil');
    });

});