<ul class="frm_step flex no_bullet">
    <li class="frm_item w30 flex not_empty">
        {!! Form::text('name',null,['placeholder'=>'نام و نام خانوادگی','class'=>'frm_input']) !!}
        <div class="frm_title">نام و نام خانوادگی</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        {!! Form::text('mobile',null,['placeholder'=>'شماره موبایل','class'=>'frm_input']) !!}
        <div class="frm_title">شماره موبایل</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        {!! Form::text('phone',null,['placeholder'=>'تلفن ثابت','class'=>'frm_input']) !!}
        <div class="frm_title">شماره تلفن ثابت</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        <select class="frm_select valid select-auto-fill" name="state_id" data-child="#city_id" data-url="{{route('front.autoselect.getcities')}}">
            <option value="">انتخاب استان</option>
            @foreach($states as $index=>$state)
                <option {{isset($edit) && $address->state_id==$state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
            @endforeach
        </select>
        <div class="frm_title">انتخاب استان</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        <select class="frm_select valid" name="city_id" id="city_id" data-loading=":: منتظر بمانید ::" data-default="انتخاب شهر">
            <option value="">انتخاب شهر</option>
            @if(isset($edit))
                @foreach($address->state->cities as $index=>$city)
                    <option {{$address->city_id==$city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            @endif
        </select>
        <div class="frm_title">انتخاب شهر</div>
    </li>
    <li class="frm_item w30 flex not_empty">
        {!! Form::text('zip_code',null,['placeholder'=>'کدپستی','class'=>'frm_input']) !!}
        <div class="frm_title">کد پستی</div>
    </li>
    <li class="frm_item w100 flex not_empty">
        {!! Form::textarea('address',null,['class'=>'frm_textarea']) !!}
        <div class="frm_title">آدرس</div>
    </li>
    <li class="frm_item">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-044-checked"></i></span>
            <span class="text">ثبت</span>
        </button>
    </li>
</ul>
