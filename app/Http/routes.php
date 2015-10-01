<?php

Route::group(['namespace' => 'Pages'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
});