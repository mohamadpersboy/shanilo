<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        $rules=[
            'title'=>'required|max:255',
            'slug'=>'required|max:255|unique:pages,slug',
            'description'=>'required',
            'pic'=>'mimes:jpg,jpeg,png,gif'
        ];
        if($this->method()=="PATCH"){
            $rules['slug']='required|max:255|unique:pages,slug,'.$this->input('id');
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'slug'=>'اسلاگ'
        ];
    }
}
