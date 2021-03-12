<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from'          =>'required|date_format:Y-m-d',
            'to'            =>'required|date_format:Y-m-d',
            'reason'        =>'max:100',
        ];
    }

    /**
     * Get the messages for the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'from.required'             => 'Please enter from date!',
            'from.date_format'          => 'From must be in yyyy-mm-dd format!',
            'to.required'               => 'Please enter to date',
            'to.date_format'            => 'To must be in yyyy-mm-dd format!',
            'reason.max'                => 'You have reached the maximum characters (100) for reason.',
        ];
    }
}
