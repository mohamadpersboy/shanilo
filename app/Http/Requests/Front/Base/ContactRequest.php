<?php

namespace App\Http\Requests\Front\Base;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|between:3,1000|max:255',
            'email' => 'required|email',
            /*'subject'=>'required',
            'mobile' => 'mobile',*/
            'description' => 'required',
        ];





    }

    public function attributes()
    {
        return [
            'subject'=>'موضوع'
        ];
    }
}
