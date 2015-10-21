<?php

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'users/disabled', 'as' => 'users.'], function () {
        Route::get('', ['as' => 'disabled', 'uses' => 'DisabledUsersController@index']);
        Route::put('{users}', ['as' => 'disabled.restore', 'uses' => 'DisabledUsersController@restore']);
        Route::delete('{users}', ['as' => 'disabled.delete', 'uses' => 'DisabledUsersController@destroy']);
    });
    Route::resource('users', 'UsersController', [
        'only' => ['index', 'create', 'store', 'destroy'],
        'names' => [
            'index' => 'users',
            'create' => 'users.create',
            'store' => 'users.store',
            'destroy' => 'users.delete'
        ]
    ]);

    Route::resource('categories', 'CategoriesController', [
        'except' => ['create', 'show'],
        'names' => [
            'index' => 'categories',
            'store' => 'categories.store',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.delete'
        ]
    ]);
    Route::resource('categories.words', 'CategoryWordController', [
        'only' => ['index'],
        'names' => [
            'index' => 'categories.words'
        ]
    ]);

    Route::resource('words', 'WordsController', [
        'except' => ['show', 'edit'],
        'names' => [
            'index' => 'words',
            'create' => 'words.create',
            'store' => 'words.store',
            'update' => 'words.update',
            'destroy' => 'words.delete'
        ]
    ]);

    Route::resource('answers', 'AnswersController', [
        'only' => ['update', 'destroy'],
        'names' => [
            'update' => 'answers.update',
            'destroy' => 'answers.delete'
        ]
    ]);

    Route::get('search', ['as' => 'search', 'uses' => 'SearchController@search']);
});

Route::group(['namespace' => 'Pages'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
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
});

Route::post('follows', ['as' => 'follows.path', 'uses' => 'User\RelationshipsController@store']);
Route::delete('follows/{users}', ['as' => 'follow.path', 'uses' => 'User\RelationshipsController@destroy']);
