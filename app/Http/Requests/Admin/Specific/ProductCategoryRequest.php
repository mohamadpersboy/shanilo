<?php

namespace App\Http\Requests\Admin\Specific;

use App\Models\Specific\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
            'title'=>'required|max:60',
            'icon'=>'required_without:parent_id'
        ];
        if($parentId=$this->get('parent_id')){
            $parentCategory=ProductCategory::find($parentId);
            if($parentCategory->level==2){
                $rules['technical_specifications.0']="required";
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'icon.required_without'=>'فیلد آیکن در صورتی که والدی انتخاب نشده باشد الزامیست.',
            'technical_specifications.0.required'=>'حداقل یک مشخصه فنی انتخاب نمایید.'
        ];
    }
}
