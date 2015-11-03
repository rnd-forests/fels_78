<?php

namespace FELS\Http\Requests;

class UpdateNameRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_name' => 'required',
            'new_name' => 'required|different:old_name|alpha_spaces|max:255',
        ];
    }
}
