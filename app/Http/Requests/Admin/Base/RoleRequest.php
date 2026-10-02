<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles',
            'slug' => 'required|unique:roles',
            'add_permission' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('messages.title'),
            'slug' => __('messages.slug'),
            'add_permission' => __('messages.permission'),
        ];
    }
}
