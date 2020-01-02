<?php

namespace PbbgIo\Titan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        $id = request()->route()->user ?? null;

        $rules = [
            'name'  =>  'required|string',
            'email' =>  ['required', 'email', Rule::unique('users')->ignore($id)],
        ];

        if(request()->route()->uri === 'admin/users' && request()->route()->methods[0] === 'POST')
        {
            $rules['password'] = 'required|string';
        }

        return $rules;
    }
}
