<?php

namespace PbbgIo\TitanFramework\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateItemCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('items');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  =>  'required|min:3|max:255',
            'equippable'    =>  'nullable|in:0,1',
            'consumable'    =>  'nullable|in:0,1',
            'consumable_uses'    =>  'nullable|integer|min:0',
            'buyable'    =>  'nullable|in:0,1',
            'stackable'    =>  'nullable|in:0,1',
        ];
    }
}
