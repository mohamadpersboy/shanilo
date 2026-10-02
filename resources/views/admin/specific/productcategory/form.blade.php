<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">دسته بندی والد:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="parent_id" id="parent_id" class="js-example-basic-single">
                    <option value="">انتخاب کنید</option>
                    @foreach($parentCategories as $index=>$parentCategory)
                        <option data-level="{{$parentCategory->level}}" value="{{$parentCategory->id}}" {{(isset($edit) && $parentCategory->id==$productCategory->parent_id)?'selected':''}}>{{$parentCategory->title}} - (level {{$parentCategory->level}})</option>
                    @endforeach
                </select>
            </div>
        </li>
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">عنوان :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('title',null,['placeholder'=>'عنوان دسته بندی را وارد نمایید.']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">آیکن :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('icon',null,['placeholder'=>'آیکن دسته بندی را وارد نمایید.']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">مشخصات فنی:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="technical_specifications[]" id="technical_specifications[]" class="js-example-basic-single" {{((isset($edit) && $productCategory->level<3) || !isset($edit))?'disabled':''}} multiple>
                    @foreach($technicalSpecifications as $index=>$technicalSpecification)
                        <option value="{{$technicalSpecification->id}}" {{(isset($edit) && in_array($technicalSpecification->id,$selectedTechnicalSpecifications))?'selected':''}}>{{$technicalSpecification->title}}</option>
                    @endforeach
                </select>
            </div>
        </li>
    </ul>
    <hr class="hr_style1 marginb20 margint20">
    <div class="btn_group_style1">
        <ul class="list clearfix">
            <li class="item {{__('content.float')}}">
                <input type="submit" name="submit" value="{{__('content.submit')}}" class="btn_style2 green">
            </li>
        </ul>
    </div>
</div>
