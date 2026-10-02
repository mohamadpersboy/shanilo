{!! Form::hidden('product_id',$product->id) !!}
{!! Form::hidden('product_sid',bcrypt($product->id)) !!}
<ul class="frm_step flex no_bullet">
    <li class="frm_item w50 flex not_empty">
        <select class="frm_select color_select_style1" name="color_id">
            <option value="" data-color="">انتخاب رنگ</option>
            <option {{(isset($edit) && $productDetail->color_id==$noColor->id)?'selected':''}} value="{{$noColor->id}}">{{$noColor->title}}</option>
            @foreach($colors as $index=>$color)
                <option {{(isset($edit) && $productDetail->color_id==$color->id)?'selected':''}} data-color="#{{$color->code}}" value="{{$color->id}}">{{$color->title}}</option>
            @endforeach
        </select>
        <div class="color"></div>
        <div class="frm_title">انتخاب رنگ</div>
    </li>
    <li class="frm_item w50 flex">
        {!! Form::text('feature',null,['placeholder'=>'مشخصه (سایز، اندازه، حجم، وزن...) ','class'=>'frm_input']) !!}
        <div class="frm_title">مشخصه (مشخصه ای مانند اندازه یا سایز که قیمت متفاتی دارد)</div>
    </li>
    <li class="frm_item w100 flex not_empty">
        {!! Form::text('price',null,['placeholder'=>'قیمت ','class'=>'frm_input']) !!}
        <div class="frm_title">قیمت (تومان)</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('discount',null,['placeholder'=>'تخفیف','class'=>'frm_input']) !!}
        <div class="frm_title">تخفیف (درصد)</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('count',null,['placeholder'=>'موجودی','class'=>'frm_input']) !!}
        <div class="frm_title">موجودی</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        {!! Form::text('weight',null,['placeholder'=>'وزن','class'=>'frm_input']) !!}
        <div class="frm_title">وزن (کیلوگرم)</div>
    </li>
    <li class="frm_item w50 flex not_empty">
        <select class="frm_select" name="index">
            <option value="0" {{(isset($edit) && $productDetail->index=="0"?'selected':'')}}>خیر</option>
            <option value="1" {{(isset($edit) && $productDetail->index=="1"?'selected':'')}}>بله</option>
        </select>
        <div class="frm_title">این محصول به عنوان پیش فرض انتخاب شود</div>
    </li>
    <li class="frm_item w50">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-007-arrow-2"></i></span>
            <span class="text">{{isset($edit)?'ویرایش زیر محصول':'ثبت زیر محصول'}}</span>
        </button>
    </li>
</ul>