<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class AppLinkRequest extends FormRequest
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
            'android_link' => 'required',
            'ios_link' => 'required',
            'forum_link' => 'required',
        ];
    }

    public function attributes()
    {
        return [
          'android_link' => "لینک اپلیکیشن اندروید",
          'ios_link' => "لینک اپلیکیشن ios",
          'forum_link' => "لینک انجمن",
        ];
    }
}
