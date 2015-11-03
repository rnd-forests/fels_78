<?php

namespace FELS\Http\Requests;

class CategoryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:4,500',
            'description' => 'required|max:1500',
        ];
    }
}
