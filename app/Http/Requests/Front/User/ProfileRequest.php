<?php

namespace App\Http\Requests\Front\User;

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
        return \Auth::check();
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
            'email' => 'required|email|max:255|unique:users,email,'.\Auth::id(),
            'mobile'=>'required|mobile|max:255|unique:users,mobile,'.\Auth::id(),
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام',
            'family' => 'نام خانوادگی',
            'email' => 'ایمیل',
        ];
    }
}
