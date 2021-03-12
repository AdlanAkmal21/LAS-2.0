<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationPostRequest extends FormRequest
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
            'leave_type_id' =>'required',
            'from'          =>'required|date_format:Y-m-d',
            'to'            =>'required|date_format:Y-m-d',
            'reason'        =>'max:100',
            'file'          =>'mimes:jpeg,png,jpg,pdf,docx,xsl,xlsx|max:5120',
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
            'leave_type_id.required'    => 'Please enter leave type!',
            'from.required'             => 'Please enter from date!',
            'from.date_format'          => 'From must be in yyyy-mm-dd format!',
            'to.required'               => 'Please enter to date',
            'to.date_format'            => 'To must be in yyyy-mm-dd format!',
            'reason.max'                => 'You have reached the maximum characters (100) for reason.',
            'file.mimes'                => 'Uploaded file must be in the format of JPEG,JPG,PNG,PDF,DOCX,XSL or XSL.',
            'file.max'                  => 'Uploaded file cannot be more than 5MB.',
        ];
    }
}
