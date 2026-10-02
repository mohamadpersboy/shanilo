@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
                <div class="container">
                    <div class="inner">
                        <div class='panel_style1 other_page_section'>

                            @include('front.partial.dashboard')
                            <div class='panel_content'>
                                <div class="title_style8"><span>تغییر رمز عبور</span></div>
                                <div class="form_style2 max_w_500">
                                    {!! Form::open([
                                        'url'=>route('front.profile.password.update'),
                                        'data-ajax',
                                        'data-type'=>'json',
                                        'data-on-success'=>'alert-message',
                                        'data-on-error'=>'inline-message',
                                        'data-clear'=>'true'
                                    ]) !!}
                                        {{method_field('patch')}}
                                        <ul class="frm_step flex no_bullet">
                                            <li class="frm_item w100 flex not_empty">
                                                <input type="password" class="frm_input" name="current_password" placeholder="رمز عبور فعلی" >
                                                <div class="frm_title">رمز عبور فعلی</div>
                                            </li>
                                            <li class="frm_item w100 flex not_empty">
                                                <input type="password" class="frm_input" name="password" placeholder="رمز عبور جدید">
                                                <div class="frm_title">رمز عبور جدید</div>
                                            </li>
                                            <li class="frm_item w100 flex not_empty">
                                                <input type="password" class="frm_input" name="password_confirmation" placeholder="تکرار رمز عبور جدید" >
                                                <div class="frm_title">تکرار رمز عبور جدید</div>
                                            </li>
                                            <li class="frm_item w50">
                                                <button class="btn_style2 flex">
                                                    <span class="icon"><i class="i-007-arrow-2"></i></span>
                                                    <span class="text">تغییر رمــز</span>
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