<?php

namespace App\Http\Requests\Front\Specific;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->merge(['uid' => trim(str_replace('@', '', $this->get('uid')))]);
        $rules = [
            'title' => 'required|max:120',
            'uid' => 'required|regex:/^[A-Za-z\d_-]+$/|unique:shops,uid|unique:users,uid',
            'city_id' => 'required',
            'email' => 'required|email|unique:shops,email',
            'background' => 'nullable|mimes:jpg,png,jpeg',
            'send_types.0' => 'required',
            'zip_code' => 'required'
        ];
        if ($this->method() == 'PATCH') {
            $rules['uid'] = "required|regex:/^[A-Za-z\d_-]+$/|unique:shops,uid," . $this->get('id') . '|unique:users,uid';
            $rules['email'] = "required|email|unique:shops,email," . $this->get('id');
            $rules['background'] = 'mimes:jpg,png,jpeg';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'background' => 'تصویر بزرگ',
            'uid' => 'ای دی فروشگاه',
            'city_id' => 'شهر فروشگاه',
            'zip_code' => 'کد پستی'
        ];
    }

    public function messages()
    {
        return [
            'uid.alpha_num' => 'ای دی فروشگاه باید فقط حاوی کارکتر انگلیسی و اعداد باشد.',
            'send_types.0.required' => 'حداقل باید یک نحوه ارسال سفارش انتخاب نمایید.'
        ];
    }
}
