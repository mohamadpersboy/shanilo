<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|between:3,1000',
            'family' => 'required|between:3,1000',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('content.tbl_name'),
            'family' => __('content.tbl_family_name'),
            'email' => __('content.tbl_email'),
            'password' => __('content.tbl_password'),
        ];
    }
}
