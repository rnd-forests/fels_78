<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'users/disabled', 'as' => 'admin.users.'], function () {
        Route::get('', ['as' => 'disabled', 'uses' => 'DisabledUsersController@index']);
        Route::put('{users}', ['as' => 'disabled.restore', 'uses' => 'DisabledUsersController@restore']);
        Route::delete('{users}', ['as' => 'disabled.delete', 'uses' => 'DisabledUsersController@destroy']);
    });
    Route::resource('users', 'UsersController', ['except' => ['show', 'edit', 'update']]);
    Route::resource('categories', 'CategoriesController', ['except' => ['create', 'show']]);
    Route::resource('categories.words', 'CategoryWordController', ['only' => ['index']]);
    Route::resource('words', 'WordsController', ['except' => ['edit']]);
    Route::resource('answers', 'AnswersController', ['only' => ['update', 'destroy']]);
    Route::get('search', ['as' => 'admin.search', 'uses' => 'SearchController@search']);
});

Route::group(['namespace' => 'Pages'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('leaderboard', ['as' => 'pages.leaderboard', 'uses' => 'LeaderboardController@index']);
    Route::get('members', ['as' => 'pages.members', 'uses' => 'MembersController@index']);
    Route::get('about', ['as' => 'pages.about', 'uses' => 'StaticPagesController@about']);
    Route::get('help', ['as' => 'pages.help', 'uses' => 'StaticPagesController@help']);
    Route::get('faq', ['as' => 'pages.faq', 'uses' => 'StaticPagesController@faq']);
});

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Auth'], function () {
    Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
    Route::get('activate/{code}', ['as' => 'activate', 'uses' => 'AuthController@getActivate']);
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    Route::get('password/email', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');
    Route::get('password/reset/{token}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');
});

Route::group(['prefix' => '{users}', 'as' => 'user.', 'namespace' => 'User'], function () {
    Route::get('profile', ['as' => 'profile.show', 'uses' => 'ProfilesController@show']);
    Route::get('profile/edit', ['as' => 'profile.edit', 'uses' => 'ProfilesController@edit']);
    Route::get('following', ['as' => 'following.show', 'uses' => 'RelationshipsController@following']);
    Route::get('followers', ['as' => 'followers.show', 'uses' => 'RelationshipsController@followers']);
    Route::delete('', ['as' => 'profile.destroy', 'uses' => 'ProfilesController@destroy']);
    Route::patch('name', ['as' => 'profile.name', 'uses' => 'ProfilesController@changeName']);
    Route::patch('password', ['as' => 'profile.password', 'uses' => 'ProfilesController@changePassword']);
    Route::get('learned', ['as' => 'learned.words', 'uses' => 'WordsController@learned']);
});

Route::resource('words', 'User\WordsController', ['only' => ['index']]);

Route::group(['namespace' => 'Category'], function () {
    Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show']]);
    Route::resource('categories.lessons', 'LessonsController', ['only' => ['store', 'show', 'update']]);
});

Route::resource('follows', 'User\RelationshipsController', ['only' => ['store', 'destroy']]);

Route::group(['prefix' => 'oauth', 'as' => 'oauth.', 'namespace' => 'Auth'], function () {
    Route::get('github', ['as' => 'github', 'uses' => 'OAuthController@authenticateWithGithub']);
    Route::get('facebook', ['as' => 'facebook', 'uses' => 'OAuthController@authenticateWithFacebook']);
    Route::get('google', ['as' => 'google', 'uses' => 'OAuthController@authenticateWithGoogle']);
});

Route::post('queue/subscribe', 'App\QueuesController@subscribe');
