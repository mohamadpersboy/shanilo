<?php

namespace App\Http\Requests\Front\Specific;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        return [
          /*  'place_type'=>'required|in:home,office',*/
            'name'=>'required|max:255',
          /*  'family'=>'required|max:255',
            'email'=>'required|email|max:255',*/
            'mobile'=>'required|mobile|max:255',
            'phone'=>'required|max:255',
            'city_id'=>'required',
            'state_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
          /*  'latitude'=>'required',
            'longitude'=>'required'*/
        ];
    }

    public function attributes()
    {
        return [
            'place_type'=>'نوع موقعیت',
            'state_id'=>'استان',
            'city_id'=>'شهر',
            'zip_code'=>'کد پستی',
            'latitude'=>'مختصات جغرافیایی',
            'longitude'=>'مختصات جغرافیایی'
        ];
    }
}
