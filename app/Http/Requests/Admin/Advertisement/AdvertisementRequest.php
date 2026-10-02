<?php

namespace App\Http\Requests\Admin\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
            'ad_plan_id' => 'required',
            'ad_time_id' => 'required',
            'link' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'ad_plan_id' => 'پلن',
            'ad_time_id' => 'زمان',
            'link' => 'لینک',
        ];
    }
}
