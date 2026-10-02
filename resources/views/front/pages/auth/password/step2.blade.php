@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="register_part1">
                    <div class="box_shadow_style1 mt30">
                        <div class="title_style7"><span>فرم ثبت نام</span></div>
                        <div class="unit_style1 mt30">
                            <ul class="step no_bullet flex">
                                <li class="item checked"><!-- has class = 'checked' 'active' -->
                                    <a href="#" title="" class="link">
                                        <div class="num">1.</div>
                                        <div class="title">ارسال شماره همراه</div>
                                    </a>
                                </li>
                                <li class="item active">
                                    <a href="#" title="" class="link">
                                        <div class="num">2.</div>
                                        <div class="title">دریافت کد تایید</div>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" title="" class="link">
                                        <div class="num">3.</div>
                                        <div class="title">تغییر رمز عبور</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="form_style2">
                            {!! Form::open([
                                'url'=>route('front.auth.password.mobile.do.confirm'),
                                'data-ajax',
                                'data-type'=>'json',
                                'data-on-success'=>'redirect',
                                'data-on-error'=>'inline-message',
                                'data-clear'=>'true'
                            ]) !!}
                                <ul class="frm_step flex no_bullet">
                                    <li class="frm_item flex not_empty">
                                        <a href="{{route('front.auth.resend_sms',Session::get('hashed'))}}" class="resend_sms"><i class="i-warning-sign"></i>ارسال مجدد کد ثبت نام</a>
                                        {!! Form::hidden('hashed',Session::get('hashed')) !!}
                                        <input type="text" class="frm_input" name="code" placeholder="کد::" data-valid-required>
                                        <div class="frm_title">کد ارسال شده را وارد نمایید.</div>
                                    </li>
                                    <li class="frm_item">
                                        <button class="btn_style2 flex">
                                            <span class="icon"><i class="i-007-arrow-2"></i></span>
                                            <span class="text">مرحله بعدی</span>
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