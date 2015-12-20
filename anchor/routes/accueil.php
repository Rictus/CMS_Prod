<?php


Route::collection(array('before' => 'auth'), function () {


    Route::get('admin/accueil', function () {
        $vars['messages'] = Notify::read();
        $vars['token'] = Csrf::token();
        $vars['page'] = Registry::get('posts_page');
        $currentPageCategoryId = getCurrentPageCategoryId('accueil');
        $vars['team'] = Post::where('category', '=', $currentPageCategoryId)->get();
        for ($i = 0; $i < count($vars['team']); $i++) {
            $memberId = $vars['team'][$i]->data["id"];
            $vars['team'][$i]->data['teammembername'] = Extend::value(Extend::field('post', 'teammembername', $memberId));
            $vars['team'][$i]->data['teammemberjob'] = Extend::value(Extend::field('post', 'teammemberjob', $memberId));
        }
        return View::create('accueil/index', $vars)//can add $vars a parameter to pass values to index page
        ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });


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

    /*
           Delete post
       */
    Route::get('admin/accueil/deleteTeamMember/(:num)', function ($id) {
        Post::find($id)->delete();

        Comment::where('post', '=', $id)->delete();

        Query::table(Base::table('post_meta'))->where('post', '=', $id)->delete();

        Notify::success(__('accueil.teamMemberDeleted'));

        return Response::redirect('admin/accueil');
    });


});