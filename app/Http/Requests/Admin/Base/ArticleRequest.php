<?php

namespace App\Http\Requests\Admin\Base;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        return [
            'title' => 'required',
        //    'article_category_id' => 'required|numeric',
            'description' => 'required',
            'summery'=>'required',
            'pic'=>'required|mimes:jpeg,jpg,png,gif'
        ];
    }

    public function attributes()
    {
        return [
            'title' => __('messages.title'),
            'article_category_id' => __('messages.article_category'),
            'description' => __('messages.content'),
            'summery'=>__('messages.summery')
        ];
    }
}
