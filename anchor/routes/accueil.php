<?php


Route::collection(array('before' => 'auth'), function () {

    /**
     * Get page for :
     *  - Current catch phrase
     *  - Current catch image
     *  - Current Ronald data
     *  - Current team
     */
    Route::get('admin/accueil', function () {
        return View::create('accueil/index') //can add $vars a parameter to pass values to index page
            ->partial('header', 'partials/header')
            ->partial('footer', 'partials/footer');
    });
});