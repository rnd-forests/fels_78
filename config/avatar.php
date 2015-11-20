<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Maximum Size of Avatar Picture
    |--------------------------------------------------------------------------
    |
    | This option defines the maximum size (both width and height) in pixels
    | of the picture used as avatar. The uploaded picture will be resized down
    | to 400x400 pixels (without scales) if its width, height exceeds this
    | value.
    |
    */
    'max_size' => 400,

    /*
    |--------------------------------------------------------------------------
    | Image Cache Time
    |--------------------------------------------------------------------------
    |
    | This option defines the time interval (in minutes) for image cache
    | operations.
    |
    */
    'cache_time' => 120,

    /*
    |--------------------------------------------------------------------------
    | Default Avatar Picture
    |--------------------------------------------------------------------------
    |
    */
    'default' => '/img/default-avatar.jpg',

    /*
    |--------------------------------------------------------------------------
    | Avatar Storage Location
    |--------------------------------------------------------------------------
    |
    | This option defines the location where all avatars are stored. Here we
    | provide a default location at public directory.
    |
    */
    'base_directory' => public_path() . '/img/avatars/',

];
