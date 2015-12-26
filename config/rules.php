<?php

return [

    'registration' => [
        'name' => 'required|alpha_spaces|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
    ],

    'session' => [
        'email' => 'required|email',
        'password' => 'required',
    ],

    'name' => [
        'old_name' => 'required',
        'new_name' => 'required|different:old_name|alpha_spaces|max:255',
    ],

    'password' => [
        'old_pass' => 'required',
        'new_pass' => 'required|confirmed|min:6',
    ],

    'avatar' => [
        'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2000',
    ],

    'answer' => [
        'solution' => 'required',
    ],

    'category' => [
        'name' => 'required|between:4,500',
        'description' => 'required|max:1500',
    ],

    'word' => [
        'create' => [
            'word.content' => 'required|max:45',
            'category' => 'required',
            'word.level' => 'required',
            'word.answers.*.solution' => 'required|min:4',
        ],
        'update' => [
            'content' => 'required|max:45',
            'level' => 'required',
        ],
    ],

];
