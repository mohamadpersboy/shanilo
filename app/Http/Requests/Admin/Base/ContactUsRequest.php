<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'email' => 'required',
            'tel' => 'required',
            'address' => 'required',
            'content1' => 'required',
            'content2' => 'required',
        ];
    }

    public function attributes()
    {
        return [
          'email' => "ایمیل",
          'tel' => "تلفن",
          'address' => 'آدرس',
          'content1' => 'متن صفحه تماس با ما',
          'content2' => 'متن فوتر',
        ];
    }
}
