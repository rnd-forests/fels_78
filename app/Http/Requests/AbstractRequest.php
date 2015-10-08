<?php

namespace FELS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    /**
     * Because we use middleware to control accesses to
     * different paths of the application, we simply return
     * truthy value here.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
