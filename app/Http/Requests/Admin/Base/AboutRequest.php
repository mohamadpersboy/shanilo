<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::guard('admins')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|max:255',
            /*'subtitle' => 'required|max:255',*/
            'description' => 'required',
           // 'pic' => 'required|mimes:jpg,jpeg,png,svg'
        ];
        if ($this->method() == "PATCH") {
            unset($rules['pic']);
        }
        return $rules;
    }
}
