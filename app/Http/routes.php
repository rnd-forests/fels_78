<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'users/disabled', 'as' => 'admin.users.'], function () {
            Route::get('', 'DisabledUsersController@index')->name('disabled');
            Route::put('{users}', 'DisabledUsersController@restore')->name('disabled.restore');
            Route::delete('{users}', 'DisabledUsersController@destroy')->name('disabled.delete');
        });
        Route::resource('users', 'UsersController', ['except' => ['show', 'edit', 'update']]);
        Route::resource('categories', 'CategoriesController', ['except' => ['create', 'show']]);
        Route::resource('categories.words', 'CategoryWordController', ['only' => ['index']]);
        Route::resource('words', 'WordsController', ['except' => ['edit']]);
        Route::resource('answers', 'AnswersController', ['only' => ['update', 'destroy']]);
        Route::get('search', 'SearchController@search')->name('admin.search');
    });

    Route::group(['namespace' => 'Pages'], function () {
        Route::get('/', 'HomeController@home')->name('home');
        Route::get('help', 'PagesController@help')->name('pages.help');
        Route::get('about', 'PagesController@about')->name('pages.about');
        Route::get('members', 'MembersController@index')->name('pages.members');
        Route::get('leaderboard', 'LeaderboardController@index')->name('pages.leaderboard');
    });

    Route::group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Auth'], function () {
        Route::get('register', 'RegistrationsController@create')->name('register');
        Route::post('register', 'RegistrationsController@store')->name('register');
        Route::get('activate/{code}', 'RegistrationsController@update')->name('activate');

        Route::get('login', 'SessionsController@create')->name('login');
        Route::post('login', 'SessionsController@store')->name('login');
        Route::get('logout', 'SessionsController@logout')->name('logout');

        Route::get('password/email', 'PasswordController@getEmail');
        Route::post('password/email', 'PasswordController@postEmail');
        Route::get('password/reset/{token}', 'PasswordController@getReset');
        Route::post('password/reset', 'PasswordController@postReset');
    });

    Route::group(['namespace' => 'User'], function () {
        Route::get('users/{users}/learned-words', 'WordsController@learned')->name('users.learned.words');
        Route::post('users/{users}/learned-words', 'WordsController@export')->name('users.learned.words');
        Route::patch('users/{users}/name', 'ProfilesController@changeName')->name('users.name');
        Route::patch('users/{users}/avatar', 'ProfilesController@changeAvatar')->name('users.avatar');
        Route::patch('users/{users}/password', 'ProfilesController@changePassword')->name('users.password');
        Route::resource('users', 'ProfilesController', ['only' => ['show', 'edit', 'destroy']]);

        Route::resource('words', 'WordsController', ['only' => ['index']]);
        Route::resource('users.followers', 'FollowersController', ['only' => ['index']]);
        Route::resource('users.following', 'FollowingsController', ['only' => ['index']]);
        Route::resource('follows', 'RelationshipsController', ['only' => ['store', 'destroy']]);
    });

    Route::group(['namespace' => 'Category'], function () {
        Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show']]);
        Route::resource('categories.lessons', 'LessonsController', ['only' => ['store', 'show', 'update']]);
    });

    Route::group(['prefix' => 'oauth', 'as' => 'oauth.', 'namespace' => 'Auth'], function () {
        Route::get('github', 'OAuthController@authenticateWithGithub')->name('github');
        Route::get('facebook', 'OAuthController@authenticateWithFacebook')->name('facebook');
        Route::get('google', 'OAuthController@authenticateWithGoogle')->name('google');
    });
});
