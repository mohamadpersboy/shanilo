<?php

namespace App\Http\Requests\Admin\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class AdSectionRequest extends FormRequest
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
            'title' => 'required',
            'width' => 'required',
            'height' => 'required',
            'name' => 'required',
            'max_count' => 'required',
        ];
    }

    public function attributes()
    {
        return [
          'title' => __('content.title_adsection'),
          'width' => __('content.width_adsection'),
          'height' => __('content.height_adsection'),
          'name' => __('content.name_adsection'),
          'max_count' => __('content.max_count_adsection'),
        ];
    }
}
