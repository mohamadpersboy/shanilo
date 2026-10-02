<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            'phone'=>'required|max:255',
           /* 'support_phone'=>'required|max:255',*/
            /*'fax'=>'required|max:255',*/
            /*'mobile'=>'required|max:255',*/
            'email'=>'required|max:255',
            'address'=>'required|max:255',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
        ];
    }
}
