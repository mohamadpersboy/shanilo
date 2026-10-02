<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name' => 'required',
            'side' => 'required',
            'member_category_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
          'name' => "نام و نام خانوادگی",
          'side' => "سمت",
          'member_category_id' => "دسته بندی",
        ];
    }
}
