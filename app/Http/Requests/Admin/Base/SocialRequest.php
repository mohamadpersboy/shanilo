<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
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
            'telegram' => 'required',
            'instagram' => 'required',
        ];
    }

    public function attributes()
    {
        return [
          'telegram' => "آدرس تلگرام",
          'instagram' => "آدرس اینستاگرام",
        ];
    }
}
