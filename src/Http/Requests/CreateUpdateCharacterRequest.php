<?php

namespace PbbgIo\TitanFramework\Http\Requests;

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
        return \Auth::user()->can('characters');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $char = request()->route()->parameter('character');
        return [
            'display_name'  =>  'required|unique:characters,display_name,' . $char->id,
            'area_id'   =>  'required|exists:areas,id'
        ];
    }
}
