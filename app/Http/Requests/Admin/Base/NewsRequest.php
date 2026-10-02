<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        $rules= [
            'title' => 'required',
            'description' => 'required',
            'summery' => 'required',
            'pic'=>'required|mimes:jpeg,jpg,png,gif'
        ];
        if($this->method()=="PATCH"){
            unset($rules['pic']);
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => __('messages.title'),
            'description' => __('messages.description'),
            'summery' => __('messages.summery'),
            'pic'=>'News Image'
        ];
    }
}
