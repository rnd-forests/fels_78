<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Maximum Number of Words per Lesson
    |--------------------------------------------------------------------------
    |
    | This option controls the maximum number of words that a lesson may have.
    |
    */
    'max_words' => 20,

    /*
    |--------------------------------------------------------------------------
    | Minimum Number of Words per Lesson
    |--------------------------------------------------------------------------
    |
    | This option controls the minimum number of words that a lesson may have.
    |
    */
    'min_words' => 5,

    /*
    |--------------------------------------------------------------------------
    | Time per Question
    |--------------------------------------------------------------------------
    |
    | This option controls the average time needed to process a question of a
    | lesson (in milliseconds). This value is used to calculate for the maximum
    | time required to complete a lesson (multiply this value with the number
    | of questions) or so-called lesson's duration.
    |
    */
    'time_per_word' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Maximum Unprocessed Time Interval
    |--------------------------------------------------------------------------
    |
    | This option defines the time interval (in days) that an unprocessed
    | lesson may take (its lifetime). If an unprocessed lesson's lifetime
    | exceeds this value, it will be queued for deletion (by a cron job).
    |
    */
    'max_unprocessed_time' => 7,

];
