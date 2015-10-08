<?php

use Illuminate\Support\ViewErrorBag;

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
