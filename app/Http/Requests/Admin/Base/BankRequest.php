<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'title' => 'required|between:3,1000',
            'name' => 'required|between:3,1000',
            'account_number' => 'required',
            'account_card' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'نام بانک',
            'name' => 'نام صاحب حساب',
            'account_number' => 'شماره حساب',
            'account_card' => 'شماره کارت',
        ];
    }
}
