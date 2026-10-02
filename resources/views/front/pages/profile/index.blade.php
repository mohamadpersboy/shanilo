@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')

                        <div class='panel_content'>
                            <div class="form_style2">
                                {!! Form::model($user,[
                                    'url'=>route('front.profile.update'),
                                    'data-ajax',
                                    'method'=>'patch',
                                    'data-type'=>'json',
                                    'data-on-success'=>'alert-message',
                                    'data-on-error'=>'inline-message',
                                ]) !!}
                                <ul class="frm_step flex no_bullet">
                                    <li class="frm_item flex not_empty">
                                        {!! Form::text('name',null,['class'=>'frm_input','placeholder'=>'نام']) !!}
                                        <div class="frm_title">نام</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        {!! Form::text('family',null,['class'=>'frm_input','placeholder'=>'نام خانوادگی']) !!}
                                        <div class="frm_title">نام خانوادگی</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        {!! Form::text('email',null,[
                                        'class'=>'frm_input single-validation checked',
                                        'placeholder'=>'ایمیل',
                                        'data-url'=>route('front.singleField.validation'),
                                        'data-field'=>'email',
                                        'data-table'=>'users',
                                        'data-rules'=>'required|email|unique:users,email,'.$user->id
                                        ]) !!}
                                        <div class="frm_title">ایمیل</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        {!! Form::text('mobile',null,
                                        ['class'=>'frm_input single-validation checked',
                                        'placeholder'=>'شماره همراه',
                                        'data-url'=>route('front.singleField.validation'),
                                        'data-field'=>'mobile',
                                        'data-table'=>'users',
                                        'data-rules'=>'required|mobile|unique:users,mobile,'.$user->id
                                        ])!!}
                                        <div class="frm_title">شماره موبایل</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        {!! Form::text('uid',null,
                                        ['class'=>'frm_input single-validation checked',
                                        'placeholder'=>'نام کاربری',
                                        'data-url'=>route('front.singleField.validation'),
                                        'data-field'=>'uid',
                                        'data-table'=>'users',
                                        'data-rules'=>'required|regex:/^[A-Za-z\d_-]+$/|unique:users,uid,'.$user->id.'|unique:shops,id'
                                        ]) !!}
                                        <div class="frm_title">نام کاربری</div>
                                    </li>
                                    <li class="frm_item flex">
                                        {!! Form::text('national_code',null,[
                                        'class'=>"frm_input single-validation ".($user->national_code?'checked':''),
                                        'placeholder'=>'کد ملی',
                                        'data-url'=>route('front.singleField.validation'),
                                        'data-field'=>'national_code',
                                        'data-table'=>'users',
                                        'data-rules'=>'Nullable|national_code|unique:users,national_code,'.$user->id
                                        ]) !!}
                                        <div class="frm_title">کد ملی</div>
                                    </li>

                                    <li class="frm_item flex not_empty">
                                        <div class="select_flex flex">
                                            <select class="frm_select w30" name="birth_day">
                                                <option value="">روز</option>
                                                @for($i=1;$i<=31;$i++)
                                                    <option {{($user->birth_date && \MyJdate\jdate('d',strtotime($user->birth_date))==$i)?'selected':''}} value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select> /
                                            <select class="frm_select w30" name="birth_month">
                                                @php
                                                    $userMonth=$user->birth_date?\MyJdate\jdate('m',strtotime($user->birth_date)):null;
                                                @endphp
                                                <option value="">ماه</option>
                                                <option {{($userMonth && $userMonth=='01')?'selected':''}} value="01">فروردین</option>
                                                <option {{($userMonth && $userMonth=='02')?'selected':''}} value="02">اردیبهشت
                                                </option>
                                                <option {{($userMonth && $userMonth=='03')?'selected':''}} value="03">خرداد</option>
                                                <option {{($userMonth && $userMonth=='04')?'selected':''}} value="04">تیر</option>
                                                <option {{($userMonth && $userMonth=='05')?'selected':''}} value="05">مرداد</option>
                                                <option {{($userMonth && $userMonth=='06')?'selected':''}} value="06">شهریور</option>
                                                <option {{($userMonth && $userMonth=='07')?'selected':''}} value="07">مهر</option>
                                                <option {{($userMonth && $userMonth=='08')?'selected':''}} value="08">آبان</option>
                                                <option {{($userMonth && $userMonth=='09')?'selected':''}} value="09">آذر</option>
                                                <option {{($userMonth && $userMonth=='10')?'selected':''}} value="10">دی</option>
                                                <option {{($userMonth && $userMonth=='11')?'selected':''}} value="11">بهمن</option>
                                                <option {{($userMonth && $userMonth=='12')?'selected':''}} value="12">اسفند</option>
                                            </select> /
                                            <select class="frm_select w30" name="birth_year">
                                                <option value="">سال</option>
                                                @php
                                                    $yearNow=\MyJdate\jdate('Y',strtotime(\Carbon\Carbon::now()->copy()->year));
                                                    $year=$yearNow-70;
                                                @endphp
                                                @for($i=$year;$i<=$yearNow;$i++)
                                                    <option {{($user->birth_date && \MyJdate\jdate('Y',strtotime($user->birth_date))==$i)?'selected':''}} value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="frm_title">تاریخ تولد</div>
                                    </li>
                                    <li class="frm_item flex w100">
                                        <label class="check_radio_style1">
                                            <input type="checkbox" name="show_info" id="t5" value="1" {{$user->show_info?'checked':''}}>
                                            <span class="icon"></span>
                                            شماره تلفن همراه و آدرس ایمیل من نمایش داده شود.
                                        </label>
                                    </li>
                                    <li class="frm_item w100">
                                        <button class="btn_style2 flex">
                                            <span class="icon"><i class="i-044-checked"></i></span>
                                            <span class="text">ثبت تغییرات</span>
                                        </button>
                                    </li>
                                </ul>
                                {!! Form::close() !!}
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection