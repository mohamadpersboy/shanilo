<?php

namespace App\Http\Requests\Front\Specific;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $shops=implode(',',\Auth::user()->shops->pluck('id')->toArray());
        $rules= [
            'title'=>'required|max:60',
            'shop_id'=>"required|in:{$shops}",
            'brand_id'=>'required|exists:brands,id',
            'category_1'=>'required',
            'category_2'=>'required',
            'category_3'=>'required',
            'description'=>[function($attr,$value,$fail){
                if($value == '' && count(array_filter($this->technicalSpecificationValues)) == 0){
                    return $fail('یکی از موارد توضیح کالا یا باید  مشخصات فنی کالا باید تکمیل شود ');
                }
            }],
            'pic'=>'required|mimes:jpg,jpeg,png|max:5120'
        ];
        if($this->method()=='PATCH'){
            $rules['pic']="mimes:jpg,jpeg,png|max:5120";
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'shop_id'=>'فروشگاه',
            'brand_id'=>'برند',
            'category_1'=>'دسته بندی سطح اول',
            'category_2'=>'دسته بندی سطح دوم',
            'category_3'=>'دسته بندی سطح سوم',
        ];
    }
}
