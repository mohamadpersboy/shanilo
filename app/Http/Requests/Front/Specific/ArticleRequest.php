<?php

namespace App\Http\Requests\Front\Specific;

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
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $shops = implode(',',\Auth::user()->shops()->pluck('id')->toArray());
        $rules = [
            'shop_id' => "Nullable|in:{$shops}",
            'title' => 'required|max:60',
            'link' => 'Nullable|url',
            'source' => 'max:60',
            'description' => 'required',
            'pic' => 'required|mimes:jpg,jpeg,png|max:5120'
        ];
        if ($this->method() == 'PATCH') {
            $rules['pic'] = 'mimes:jpg,jpeg,png|max:5120';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'shop_id'=>'فروشگاه',
            'link'=>'لینک',
            'source'=>'منبع'
        ];
    }
}
