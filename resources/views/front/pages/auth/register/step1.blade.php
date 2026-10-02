@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="register_part1">
                    <div class="text_style1">{{mainSetting('registerPage')}}</div>
                    <div class="box_shadow_style1 mt30">
                        <div class="title_style7"><span>فرم ثبت نام</span></div>
                        <div class="unit_style1 mt30">
                            <ul class="step no_bullet flex">
                                <li class="item active"><!-- has class = 'checked' 'active' -->
                                    <a href="#" title="" class="link">
                                        <div class="num">1.</div>
                                        <div class="title">ثبت اطلاعات</div>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" title="" class="link">
                                        <div class="num">2.</div>
                                        <div class="title">دریافت کد تایید</div>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" title="" class="link">
                                        <div class="num">3.</div>
                                        <div class="title">انتخاب علاقه مندی</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="form_style2">
                                {!! Form::open([
                                'url'=>route('front.auth.register'),
                                'data-ajax',
                                'data-type'=>'json',
                                'data-on-error'=>'inline-message',
                                'data-on-success'=>'redirect',
                                'data-clear'=>'true'
                                ]) !!}
                                <ul class="frm_step flex no_bullet">
                                    <li class="frm_item flex not_empty">
                                        <input type="text" class="frm_input" name="name" placeholder="نام">
                                        <div class="frm_title">نام</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        <input type="text" class="frm_input" name="family" placeholder="نام خانوادگی" >
                                        <div class="frm_title"> نام خانوادگی</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        <input type="text" class="frm_input single-validation" data-url="{{route('front.singleField.validation')}}" data-table="users" data-field="email" data-rules="required|email|unique:users,email"  name="email" placeholder="ایمیل">
                                        <div class="frm_title">ایمیل</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        <input type="text" class="frm_input single-validation" data-url="{{route('front.singleField.validation')}}" data-table="users" data-field="mobile" data-rules="required|mobile|unique:users,mobile" name="mobile" placeholder="شماره موبایل">
                                        <div class="frm_title">شماره موبایل</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        <input type="text" class="frm_input single-validation" data-url="{{route('front.singleField.validation')}}" data-table="users" data-field="uid" data-rules="required|regex:/^[A-Za-z\d_-]+$/|unique:users,uid|unique:shops,uid" name="uid" placeholder="نام کاربری" >
                                        <div class="frm_title">نام کاربری (بدون @)</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        <input type="password" class="frm_input" name="password" placeholder="رمز عبور" >
                                        <div class="frm_title">رمز عبور</div>
                                    </li>
                                    <li class="frm_item flex not_empty">
                                        <input type="password" class="frm_input" name="password_confirmation" placeholder="تکرار رمز عبور">
                                        <div class="frm_title">تکرار رمز عبور</div>
                                    </li>

                                    <li class="frm_item flex w100 not_empty">
                                        <label class="check_radio_style1">
                                            <input type="radio" name="agreement" id="t5" value="1">
                                            <span class="icon"></span>
                                            با تکمیل ثبت نام موافقت خود را با کلیه قوانین و مقررات سایت اعلام مینمایم
                                        </label>
                                    </li>
                                    <li class="frm_item">
                                        <button class="btn_style2 flex">
                                            <span class="icon"><i class="i-044-checked"></i></span>
                                            <span class="text">ثبت عضویت</span>
                                        </button>
                                    </li>
                                </ul>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {

        });//document ready

    </script>

@endsection
