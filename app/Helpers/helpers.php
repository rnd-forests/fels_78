<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

if (!function_exists('short_time')) {
    /**
     * Return a short format of a timestamp.
     *
     * @param $timestamp
     * @return string
     */
    function short_time($timestamp)
    {
        return Carbon::parse($timestamp)->format('Y/m/d');
    }
}

if (!function_exists('full_time')) {
    /**
     * Return a full format of a timestamp.
     *
     * @param $timestamp
     * @return string
     */
    function full_time($timestamp)
    {
        return Carbon::parse($timestamp)->format('Y/m/d, H:i:s');
    }
}

if (!function_exists('humans_time')) {
    /**
     * Return the human-friendly difference time interval.
     *
     * @param $timestamp
     * @return string
     */
    function humans_time($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }
}

if (!function_exists('remaining_days')) {
    /**
     * Get the difference in days between a specified
     * timestamp and current time.
     *
     * @param $finish
     * @return string
     */
    function remaining_days($finish)
    {
        $count = (int)Carbon::now()->diffInDays(Carbon::parse($finish));

        return $count . ' ' . str_plural('day', $count) . ' remaining';
    }
}

if (!function_exists('error_text')) {
    /**
     * Utility function to print out the error in forms.
     *
     * @param ViewErrorBag $errors
     * @param $field
     * @return mixed
     */
    function error_text(ViewErrorBag $errors, $field)
    {
        if ($errors->has($field)) {
            return $errors->first($field, '<span class="help-block form-error-text">:message</span>');
        }
    }
}

if (!function_exists('plural')) {
    /**
     * Plural a word using the associated counter value.
     *
     * @param $pattern
     * @param $counter
     * @return string
     */
    function plural($pattern, $counter)
    {
        if (!is_numeric($counter)) {
            throw new InvalidArgumentException();
        }

        return $counter . ' ' . str_plural($pattern, $counter);
    }
}

if (!function_exists('plural2')) {
    /**
     * Plural a word using the associated counter
     * value with a middle pattern.
     *
     * @param $pattern
     * @param $middle
     * @param $counter
     * @return string
     */
    function plural2($pattern, $middle, $counter)
    {
        if (!is_numeric($counter)) {
            throw new InvalidArgumentException();
        }

        return $counter . ' ' . $middle . ' ' . str_plural($pattern, $counter);
    }
}

if (!function_exists('counting')) {
    /**
     * Count the total number of instances inside a collection or a
     * paginated collection.
     *
     * @param $object
     * @return int
     */
    function counting($object)
    {
        if (!($object instanceof Collection || $object instanceof LengthAwarePaginator)) {
            throw new InvalidArgumentException();
        }

        if ($object instanceof LengthAwarePaginator) {
            return $object->total();
        }

        return $object->count();
    }
}

if (!function_exists('blank')) {
    /**
     * Check if a collection or a paginated
     * collection is empty or not.
     *
     * @param $object
     * @return bool
     */
    function blank($object)
    {
        if (!($object instanceof Collection || $object instanceof LengthAwarePaginator)) {
            throw new InvalidArgumentException();
        }

        return $object->isEmpty();
    }
}

if (!function_exists('paginate')) {
    /**
     * Generate the pagination URL. There two cases:
     *  - The normal case with no query string.
     *  - And the paginate with some associated query strings.
     *
     * @param $collection
     * @param array|null $queries
     * @return string
     */
    function paginate($collection, array $queries = null)
    {
        if (!$queries) {
            return '<div class="text-center">' . $collection->render() . '</div>';
        } else {
            return '<div class="text-center">' . $collection->appends($queries)->render() . '</div>';
        }
    }
}

if (!function_exists('validate_query_string')) {
    /**
     * Check if the current query string is in the allowed set of
     * query strings.
     *
     * @param $current
     * @param array $possible
     * @return bool
     */
    function validate_query_string($current, array $possible)
    {
        if (!$current || !in_array($current, $possible)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('verify_session_key')) {
    /**
     * Check if a session key exists and equal to a vlue.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    function verify_session_key($key, $value)
    {
        if (!session()->has($key)) {
            return false;
        }

        if (session($key) === $value) {
            return true;
        }

        return false;
    }
}

if (!function_exists('option')) {
    /**
     * Pick on of two options.
     *
     * @param $option
     * @param $default
     */
    function option($option, $default)
    {
        return isset($option) ? $option : $default;
    }
}

if (!function_exists('array_random_val')) {
    /**
     * Generate random values from a given array.
     *
     * @param array $arr
     * @return mixed
     */
    function array_random_val(array $arr)
    {
        return $arr[array_rand($arr)];
    }
}
