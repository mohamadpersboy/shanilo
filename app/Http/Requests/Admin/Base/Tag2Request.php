<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class Tag2Request extends FormRequest
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
            'parent_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
          'name' => __('messages.title'),
          'parent_id' => "گروه اصلی",
        ];
    }
}
