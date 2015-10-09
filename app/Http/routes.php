<?php

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'users/disabled', 'as' => 'users.'], function () {
        Route::get('', ['as' => 'disabled', 'uses' => 'DisabledUsersController@index']);
        Route::put('{users}', ['as' => 'disabled.restore', 'uses' => 'DisabledUsersController@restore']);
        Route::delete('{users}', ['as' => 'disabled.delete', 'uses' => 'DisabledUsersController@destroy']);
    });
    Route::resource('users', 'UsersController', [
        'only' => ['index', 'destroy'],
        'names' => [
            'index' => 'users',
            'destroy' => 'users.delete'
        ]
    ]);
});

Route::group(['namespace' => 'Pages'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
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
    Route::get('profile/edit', ['as' => 'profile.edit', 'uses' => 'ProfilesController@edit']);
    Route::delete('', ['as' => 'profile.destroy', 'uses' => 'ProfilesController@destroy']);
    Route::patch('name', ['as' => 'profile.name', 'uses' => 'ProfilesController@changeName']);
    Route::patch('password', ['as' => 'profile.password', 'uses' => 'ProfilesController@changePassword']);
});
