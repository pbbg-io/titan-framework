<?php

namespace PbbgIo\TitanFramework\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PbbgIo\TitanFramework\Stat;

class CreateUpdateStatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('stats');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stat'  =>  'required|min:3|max:255',
            'description'   =>  'required|min:3|max:255',
            'type'  =>  ['required', 'in:' . implode(',', Stat::AVAILABLE_TYPES)],
            'default'   =>  'required|max:255'
        ];
    }
}
