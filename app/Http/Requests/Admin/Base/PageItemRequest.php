<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class PageItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('admins')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page_id'=>'required|exists:pages,id',
            'title'=>'required|max:63',
            'icon'=>auth()->guard('admins')->user()->role_id==1?'required':'Nullable',
            'link'=>'Nullable|url'
        ];
    }

    public function attributes()
    {
        return [
            'link'=>'لینک'
        ];
    }
}
