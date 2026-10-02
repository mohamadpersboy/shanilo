<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => 'required|check_hash:'.\Auth::user()->getAuthPassword().',true',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => 'رمز قدیم',
            'password' => 'رمز جدید',
        ];
    }

    public function messages()
    {
        return [
            'current_password.check_hash'=>'رمز عبور فعلی صحیح نمی باشد.'
        ];
    }
}
