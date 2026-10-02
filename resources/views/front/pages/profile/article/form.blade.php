<ul class="frm_step flex no_bullet">
    <li class="frm_item w100 flex not_empty">

        <div class="side_container article_cropper">

            <input type='file' class="frm_file" name='pic' data-run-cropper='' data-x='9' data-y='6.55'
                   data-element='#cropper3'
                   onChange='preview(this,$(".panel_content .form_style2 .cropper .cropper_holder"));'>
            <div class='cropper ltr' id='cropper3'>
                <span class='small_img' onClick="$('input.select_pic_user').click();">
                    @if(isset($edit))
                        <span class='pic_inner cropper_preview'
                              style="background-image: url('{{$article->takeImage('main','900/655')}}');background-repeat: no-repeat;background-size: cover;width: 275px !important;height: 200px !important;"></span>
                    @else
                        <span class='pic_inner cropper_preview'
                              style="width: 275px !important;height: 200px !important;"></span>
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

        <div class="frm_title">آپلود عکس مجله</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('title',null,['class'=>'frm_input','placeholder'=>'تیتر مجله']) !!}
        <div class="frm_title">تیتر مجله</div>
    </li>
    <li class="frm_item w50 flex">
        <select name="shop_id" class="frm_select" id="">
            <option value="">انتخاب کنید</option>
            @foreach($shops as $index=>$shop)
                <option {{(isset($edit) && $article->shop_id==$shop->id)?'selected':''}} value="{{$shop->id}}">{{$shop->title}}</option>
            @endforeach
        </select>
        <div class="frm_title">فروشگاه</div>
    </li>
    <li class="frm_item w50 flex">
        {!! Form::text('source',null,['class'=>'frm_input','placeholder'=>'منبع']) !!}
        <div class="frm_title">منبع</div>
    </li>
    <li class="frm_item w50 flex">
        {!! Form::text('link',null,['class'=>'frm_input tal','placeholder'=>'http://']) !!}
        <div class="frm_title">لینک منبع</div>
    </li>
    <li class="frm_item w100 flex not_empty">
        {!! Form::textarea('description',null,['class'=>'frm_textarea']) !!}
        <div class="frm_title">متن مجله</div>
    </li>
    <li class="frm_item w50">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-044-checked"></i></span>
            <span class="text">ثبت مجله</span>
        </button>
    </li>
</ul>