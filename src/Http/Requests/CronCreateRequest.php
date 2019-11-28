<?php

namespace PbbgIo\TitanFramework\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CronCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('crons');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'command'   =>  'required|string',
            'cron'    =>  'required|string',
            'enabled'   =>  'sometimes|in:0,1'
        ];
    }
}
