<?php

namespace PbbgIo\TitanFramework\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateItemRequest extends FormRequest
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
            'name'  =>  'required|string|min:3|max:255',
            'description'   =>  'string',
            'item_category_id'   =>  'required|exists:item_categories,id',
            'equippable'    =>  'nullable|in:0,1',
            'consumable'    =>  'nullable|in:0,1',
            'consumable_uses'    =>  'nullable|integer|min:0',
            'buyable'    =>  'nullable|in:0,1',
            'cost'    =>  'nullable|integer|min:0',
            'stackable'    =>  'nullable|in:0,1',
        ];
    }
}
