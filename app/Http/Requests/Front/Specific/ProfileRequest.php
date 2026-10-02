<?php

namespace App\Http\Requests\Front\Specific;

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
        $rules=[
            'name'=>'required|max:60',
            'family'=>'required|max:60',
            'uid'=>'required|regex:/^[A-Za-z\d_-]+$/|unique:users,uid,'.\Auth::id().'|unique:shops,uid',
            'email'=>'required|email|unique:users,email,'.\Auth::id(),
            'mobile'=>'required|mobile|unique:users,mobile,'.\Auth::id(),
            'national_code'=>'Nullable|national_code|unique:users,national_code,'.\Auth::id(),
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'uid.regex'=>'نام کاربری فقط باید حاوی کاراکتر انگلیسی و اعداد باشد.'
        ];
    }

    public function attributes()
    {
        return [
            'uid'=>'نام کاربری'
        ];
    }

}
