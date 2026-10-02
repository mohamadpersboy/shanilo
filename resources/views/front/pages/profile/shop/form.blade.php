<ul class="frm_step flex no_bullet">
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('title',null,['class'=>'frm_input','placeholder'=>'نام فروشگاه']) !!}
        <div class="frm_title">نام فروشگاه</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('uid',null,[
            'class'=>'frm_input single-validation',
            'placeholder'=>'آی دی فروشگاه',
            'data-url'=>route('front.singleField.validation'),
            'data-field'=>'uid',
            'data-table'=>'shops',
            'data-rules'=>'required|regex:/^[A-Za-z\d_-]+$/u|unique:users,uid|unique:shops,uid'.(isset($edit)?','.$shop->id:'').'|unique:users,uid',
        ]) !!}
        <div class="frm_title">آی دی فروشگاه (بدون @)</div>
    </li>
    <li class="frm_item w50 flex">
        {!! Form::text('phone',null,['class'=>'frm_input','placeholder'=>'شماره تماس']) !!}
        <div class="frm_title">شماره تماس</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('email',null,['class'=>'frm_input','placeholder'=>'ایمیل']) !!}
        <div class="frm_title">ایمیل</div>
    </li>
    <li class="frm_item w100 flex">
        {!! Form::text('address',null,['class'=>'frm_input','placeholder'=>'آدرس']) !!}
        <div class="frm_title">آدرس</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('zip_code',null,['class'=>'frm_input','placeholder'=>'کد پستی']) !!}
        <div class="frm_title">کد پستی</div>
    </li>
    <li class="frm_item w50 flex">
        {!! Form::text('work_time',null,['class'=>'frm_input','placeholder'=>'ساعات کاری']) !!}
        <div class="frm_title">ساعات کاری</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        <select class="select2" data-ajax="true" data-url="{{route('front.home.search-for-cities')}}" name="city_id">
            @if(isset($edit))
                <option value="{{$shop->city_id}}">{{$shop->city->name." ({$shop->city->state->name})"}}</option>
            @endif
        </select>
        <div class="frm_title">شهر فروشگاه</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        <select class="select2" name="send_types[]" multiple>
            @foreach($sendTypes as $index=>$sendType)
                <option value="{{$sendType->id}}" {{(isset($edit) && in_array($sendType->id,$shopSendTypes))?'selected':''}}>{{$sendType->title}}</option>
            @endforeach
        </select>
        <div class="frm_title">نحوه ارسال محصول</div>
    </li>
   {{-- <li class="frm_item w50 flex">
        <select class="select2" data-ajax="true" data-url="{{route('front.home.search-for-cities')}}" name="cities[]"
                multiple>
         @if(isset($edit))
                @foreach($shop->cities as $index=>$city)
                    <option value="{{$city->id}}" selected>{{$city->name." ({$city->state->name})"}}</option>
                @endforeach
        @endif
        </select>
        <div class="frm_title">ارسال به شهرهای (در صورتی که به کل نقاط کشور خدمات میدهید این قسمت را خالی بگذارید.)
        </div>
    </li>--}}

    <li class="frm_item w100 flex">
        {!! Form::textarea('description',null,['class'=>'frm_textarea type2','placeholder'=>'درباره فروشگاه']) !!}
        <div class="frm_title">درباره فروشگاه</div>
    </li>
    <li class="frm_item w100 flex not_empty">
        <div class="side_container">
            <input type='file' class="frm_file" name='background' data-run-cropper='' data-x='1.2' data-y='0.5'
                   data-element='#cropper3'
                   onChange='preview(this,$(".panel_content .form_style2 .cropper .cropper_holder"));'>
            <div class='cropper ltr' id='cropper3'>
                <span class='small_img' onClick="$('input.select_pic_user').click();">
                    @if(isset($edit))
                        <span class='pic_inner shop cropper_preview' style="background-image: url('{{$shop->takeImage('background','1200/500')}}');background-repeat: no-repeat;background-size: cover;width: 300px!important;height: 125px!important;"></span>
                        @else
                       <span class='pic_inner shop cropper_preview' style="width: 300px!important;height: 125px!important"></span>
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

        <div class="">آپلود عکس محصول</div>
    </li>
    <li class="frm_item w50">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-007-arrow-2"></i></span>
            <span class="text">ثبت اطلاعات</span>
        </button>
    </li>
</ul>
