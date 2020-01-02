<?php

namespace PbbgIo\Titan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $char = request()->route()->parameter('character');

        $rules = [];
        $rules['display_name'] = 'required|max:255|min:3';
        $rules['area_id'] = 'required|exists:areas,id';

        if($char)
            $rules['display_name'] = 'required|max:255|min:3|unique:characters,display_name,' . $char->id;

        return $rules;
    }
}
