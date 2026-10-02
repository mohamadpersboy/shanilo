<ul class="frm_step flex no_bullet">
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('title',null,['class'=>'frm_input','placeholder'=>'نام محصول']) !!}
        <div class="frm_title">نام محصول</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        <select name="brand_id" class="frm_select select2">
            <option value="">انتخاب کنید</option>
            @foreach($brands as $index=>$brand)
                <option {{(isset($edit) && $product->brand_id==$brand->id)?'selected':''}} value="{{$brand->id}}">{{$brand->title}}</option>
            @endforeach
        </select>
        <div class="frm_title">برند</div>
    </li>
    <li class="frm_item w100 flex not_empty">
        <select class="frm_select" name="shop_id">
            @if(!isset($edit))
                <option value="">انتخاب فروشگاه</option>
            @endif
            @foreach($shops as $index=>$shop)
                <option {{(isset($edit) && $product->shop_id==$shop->id)?'selected':''}} value="{{$shop->id}}">{{$shop->title}}</option>
            @endforeach
        </select>
        <div class="frm_title">انتخاب فروشگاه</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        <select class="frm_select select-auto-fill" data-url="{{route('front.getChildren.productCategory')}}"
                data-child="#second-level-categories" name="category_1">
            <option value="">انتخاب کنید</option>
            @foreach($firstLevelCategories as $index=>$firstLevelCategory)
                <option {{(isset($edit) && in_array($firstLevelCategory->id,$productCategoriesList))?'selected':''}} value="{{$firstLevelCategory->id}}">{{$firstLevelCategory->title}}</option>
            @endforeach
        </select>
        <div class="frm_title">دسته بندی سطح اول</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        <select id="second-level-categories" data-loading="::::> صبر کنید <::::" data-default="انتخاب کنید"
                class="frm_select select-auto-fill" data-child="#third-level-categories"
                data-url="{{route('front.getChildren.productCategory')}}" name="category_2">
            <option value="">انتخاب کنید</option>
            @if(isset($edit))
                @foreach($secondLevelCategories as $index=>$secondLevelCategory)
                    <option {{(isset($edit) && in_array($secondLevelCategory->id,$productCategoriesList))?'selected':''}} value="{{$secondLevelCategory->id}}">{{$secondLevelCategory->title}}</option>
                @endforeach
            @endif
        </select>
        <div class="frm_title">دسته بندی سطح دوم</div>
    </li>
    <li class="frm_item w30 flex not_empty ">
        <select id="third-level-categories" data-url="{{isset($edit)?route('front.getTechnicalSpecifications',['product'=>$product]):route('front.getTechnicalSpecifications',['product'=>"null"])}}"
                data-loading="::::> صبر کنید <::::" data-default="انتخاب کنید" class="frm_select" name="category_3">
            <option value="">انتخاب کنید</option>
            @if(isset($edit))
                @foreach($thirdLevelCategories as $index=>$thirdLevelCategory)
                    <option {{(isset($edit) && in_array($thirdLevelCategory->id,$productCategoriesList))?'selected':''}} value="{{$thirdLevelCategory->id}}">{{$thirdLevelCategory->title}}</option>
                @endforeach
            @endif
        </select>
        <div class="frm_title">دسته بندی سطح سوم</div>
    </li>
    <li class="frm_item w100 flex" {{isset($edit)?'':'style="display: none;"'}}>
        <ul id="technical-specification-container" class="frm_step flex no_bullet">
            @if(isset($edit))
            @php
                $category3=$product->productCategories()->get()->where('level',3)->first();
                $productCategoryTechnicalSpecifications=\App\Models\Specific\ProductCategoryTechnicalSpecification::where('product_category_id',$category3->id)
                ->select('product_category_technical_specifications.*')
                ->join('technical_specifications','product_category_technical_specifications.technical_specification_id','=','technical_specifications.id')
                ->orderBy('technical_specifications.position')
                ->get();
            @endphp
            @include('front.partial.ajax.product-technical-specification',[
                'productCategoryTechnicalSpecifications'=>$productCategoryTechnicalSpecifications,
                'product'=>$product
            ])
            @endif
        </ul>
        <div class="frm_title">مشخصات فنی</div>
    </li>
    <li class="frm_item w100 flex">
        <ul class="frm_step flex no_bullet">
            @if(!isset($edit) || (isset($edit) && !$product->properties->count()))
                <li class="frm_item w50 flex">
                    {!! Form::text('properties[]',"",['class'=>'frm_input','placeholder'=>'نام مشخصه (مانند سایز، نوع و...)']) !!}
                    <div class="frm_title">نام مشخصه</div>
                </li>
                <li class="frm_item w50 flex">
                    {!! Form::text('properties[]',"",['class'=>'frm_input','placeholder'=>'نام مشخصه (مانند سایز، نوع و...)']) !!}
                    <div class="frm_title">نام مشخصه</div>
                </li>
            @else
                @php
                $properties=$product->properties;
                @endphp
                @if(isset($properties[0]))
                    <li class="frm_item w50 flex">
                        <div class="add_select_part">
                            <div  class="select_item product-property-container">
                                @include('front.partial.ajax.product-property-details',['property'=>$properties[0]])
                            </div>
                            <div class="add_form">
                                <div class="flex">
                                    <input data-url="{{route('front.profile.productPropertyDetail.store')}}" type="text" placeholder="افزودن آیتم جدید">
                                    <input type="hidden" name="product_property" value="{{$properties[0]->id}}">
                                    <button class="btn-product-property-detail" type="button"><i class="i-checked"></i></button>
                                </div>
                            </div>
                        </div>
                        {!! Form::text("property_{$properties[0]->id}",$properties[0]->title,['class'=>'frm_input','placeholder'=>'نام مشخصه (مانند سایز، نوع و...)']) !!}
                        <div class="frm_title">نام مشخصه</div>
                    </li>
                @else
                    <li class="frm_item w50 flex">
                        <input type="text" name="properties[]" value="" class="frm_input" placeholder="نام مشخصه (مانند سایز، نوع و...)">
                        <div class="frm_title">نام مشخصه</div>
                    </li>
                @endif

                @if(isset($properties[1]))
                    <li class="frm_item w50 flex">
                        <div class="add_select_part">
                            <div  class="select_item product-property-container">
                                @include('front.partial.ajax.product-property-details',['property'=>$properties[1]])
                            </div>
                            <div class="add_form">
                                <div class="flex">
                                    <input data-url="{{route('front.profile.productPropertyDetail.store')}}" type="text" placeholder="افزودن آیتم جدید">
                                    <input type="hidden" name="product_property" value="{{$properties[1]->id}}">
                                    <button class="btn-product-property-detail" type="button"><i class="i-checked"></i></button>
                                </div>
                            </div>
                        </div>
                        {!! Form::text("property_{$properties[1]->id}",$properties[1]->title,['class'=>'frm_input','placeholder'=>'نام مشخصه (مانند سایز، نوع و...)']) !!}
                        <div class="frm_title">نام مشخصه</div>
                    </li>
                @else
                    <li class="frm_item w50 flex">
                        <input type="text" name="properties[]" value="" class="frm_input" placeholder="نام مشخصه (مانند سایز، نوع و...)">
                        <div class="frm_title">نام مشخصه</div>
                    </li>
                @endif
            @endif

        </ul>
        <div class="frm_title">عنوان مشخصه های قابل انتخاب</div>
    </li>
    <li class="frm_item w100 flex">
        {!! Form::textarea('description',null,['class'=>'frm_textarea','placeholder'=>'توضیحات']) !!}
        <div class="frm_title">توضیحات محصول</div>
    </li>
    <li class="frm_item w100 flex not_empty">

        <div class="side_container">

            <input type='file' class="frm_file" name='pic' data-run-cropper='' data-x='2.7' data-y='1.5' data-element='#cropper3' onChange='preview(this,$(".panel_content .form_style2 .cropper .cropper_holder"));'>
            <div class='cropper ltr' id='cropper3'>
                <span class='small_img' onClick="$('input.select_pic_user').click();">
                    @if(isset($edit))
                        <span class='pic_inner cropper_preview'
                              style="width: 270px !important;height: 150px !important; background: url('{{$product->takeImage('main','270/150')}}') no-repeat;background-size: cover;"></span>
                        @else
                        <span class='pic_inner cropper_preview'
                              style="width: 270px !important;height: 150px !important;"></span>
                    @endif

                </span>
                <div class='cropper_holder'></div>
                <input data-crop-x type='hidden' name='cropper[x]' value=''>
                <input data-crop-y type='hidden' name='cropper[y]' value=''>
                <input data-crop-w type='hidden' name='cropper[w]' value=''>
                <input data-crop-h type='hidden' name='cropper[h]' value=''>
                <input type='hidden' name='old_image' value=''>
            </div>
        </div>

        <div class="frm_title">آپلود عکس محصول</div>
    </li>
    <li class="frm_item w50">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-007-arrow-2"></i></span>
            <span class="text">{{isset($edit)?'ویرایش محصول':'ثبت تغییرات'}}</span>
        </button>
    </li>
</ul>
