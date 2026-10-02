<?php

namespace App\Http\Requests\Front\Specific;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductDetailRequest extends FormRequest
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
        $rules = [
            'color_id' => [
                'required'
            ],
            'product_id' => 'required|exists:products,id',
            'product_sid' => 'required|check_hash:' . $this->get('product_id'),
            'price' => 'required|numeric|max:1000000000',
            'discount' => 'Nullable|numeric|max:100|min:0',
            'count' => 'required|numeric|max:100000|min:0',
            'index' => 'Nullable|in:0,1'
        ];
        if ($this->method() == 'PATCH') {
           if($this->get('color_id')==6){
               $rules['color_id'] = [
                   'required'
               ];
           }else{
              $rules['color_id']=[
                  'required'
              ];
           }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'product_id.required' => 'اطلاعات ارسال شده نامعتبر است',
            'product_id.exists' => 'اطلاعات ارسال شده نامعتبر است',
            'product_sid.required' => 'اطلاعات ارسال شده نامعتبر است',
            'product_sid.check_hash' => 'اطلاعات ارسال شده نامعتبر است',
        ];
    }

    public function attributes()
    {
        return ['color_id' => 'رنگ'];
    }
}
