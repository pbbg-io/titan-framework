<?php

namespace PbbgIo\Titan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  =>  'required|string|min:3|max:255|unique:characters,display_name'
        ];
    }
}
