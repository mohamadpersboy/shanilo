<ul class="frm_step flex no_bullet">
    <li class="frm_item flex w100 not_empty">
        {!! Form::text('sheba_no',null,['placeholder'=>'شماره شبا','class'=>'frm_input']) !!}
        <div class="frm_title">شماره شبا</div>
    </li>
    <li class="frm_item flex w100 not_empty">
        {!! Form::text('cart_no',null,['placeholder'=>'شماره کارت','class'=>'frm_input']) !!}
        <div class="frm_title">شماره کارت</div>
    </li>
    <li class="frm_item flex w70 not_empty">
        {!! Form::text('owner',null,['placeholder'=>'نام صاحب کارت','class'=>'frm_input']) !!}
        <div class="frm_title">نام صاحب کارت</div>
    </li>
    <li class="frm_item flex w70 not_empty">
        <div class="frm_input_flex flex">
            {!! Form::text('expire_month',null,['placeholder'=>'ماه','class'=>'frm_input','maxlength'=>2]) !!}
            /
            {!! Form::text('expire_year',null,['placeholder'=>'سال','class'=>'frm_input','maxlength'=>2]) !!}
            <div class="frm_title"></div>
        </div>
        <div class="frm_title">انقضا کارت</div>
    </li>
    @if(isset($edit))
    <li class="frm_item w100 row_flex flex">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-044-checked"></i></span>
            <span class="text">ویرایش کیف پول</span>
        </button>
       {{-- <a href="javascript:void(0)" data-block=".wrapper_box" data-url="{{route('front.profile.bankCart.destroy',$bankCart)}}" class="dlt_btn btn-delete"><i class="i-031-trash"></i>حذف کارت</a>--}}
    </li>
    @else
        <li class="frm_item w100 row_flex flex">
            <button class="btn_style2 flex">
                <span class="icon"><i class="i-044-checked"></i></span>
                <span class="text">ثبت کیف پول جدید</span>
            </button>
        </li>
    @endif
</ul>