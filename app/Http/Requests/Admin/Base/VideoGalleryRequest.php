<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class VideoGalleryRequest extends FormRequest
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
            'title' => 'required|max:120',
            'video_pic' => 'required',
        ];
        if($this->method()=='PATCH'){
            unset($rules['video_pic']);
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => __('messages.title'),
            'video_pic'=>'required'
        ];
    }
}
