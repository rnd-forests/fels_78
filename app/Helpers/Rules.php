<?php

namespace FELS\Helpers;

class Rules
{
    public static $name = [
        'old_name' => 'required',
        'new_name' => 'required|different:old_name|alpha_spaces|max:255',
    ];

    public static $password = [
        'old_pass' => 'required',
        'new_pass' => 'required|confirmed|min:6',
    ];

    public static $avatar = [
        'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2000',
    ];
}
