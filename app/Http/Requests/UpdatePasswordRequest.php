<?php

namespace FELS\Http\Requests;

class UpdatePasswordRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_pass' => 'required',
            'new_pass' => 'required|confirmed|min:6',
        ];
    }
}
