<?php

namespace PbbgIo\Titan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannedCharRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::user()->can('ban-user');
    }

    public function rules()
    {

        return [
            'bannable_id' => 'exists:characters,id|required',
            'forever' => 'required_without:ban_until',
            'reason' => 'min_if_not_empty:5,15|string|nullable',
            'ban_until' => 'required_without:forever|date|after:today|nullable',
        ];
    }
}
