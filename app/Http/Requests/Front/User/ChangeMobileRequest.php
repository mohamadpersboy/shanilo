<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMobileRequest extends FormRequest
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
            'current_password' => 'required|min:6',
            'mobile' => 'required|min:11|max:11',
            'newMobile' => 'required|min:11|max:11',
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => 'رمز عبور',
            'mobile' => 'موبایل قدیم',
            'newMobile' => 'موبایل جدید',
        ];
    }
}
