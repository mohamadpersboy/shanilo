@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            <div class="title_style8"><span>تنظیمات انتخابی</span></div>
                            <div class="form_style2 max_w_500">
                                <form data-valid-form>
                                    <ul class="frm_step flex no_bullet">
                                        <li class="frm_item w100 flex not_empty">
                                            <label class="check_radio_style1">
                                                <input type="checkbox" name="q" id="t5">
                                                <span class="icon"></span>
                                                با تکمیل ثبت نام موافقت خود را با کلیه قوانین و مقررات سایت اعلام مینمایم
                                            </label>
                                            <div class="frm_title">عدم نمایش پروفایل</div>
                                        </li>
                                        <li class="frm_item w100 flex not_empty">
                                            <label class="check_radio_style1">
                                                <input type="checkbox" name="q" id="t1">
                                                <span class="icon"></span>
                                                با تکمیل ثبت نام موافقت خود را با کلیه قوانین و مقررات سایت اعلام مینمایم
                                            </label>
                                            <div class="frm_title">عدم نمایش پروفایل</div>
                                        </li>
                                        <li class="frm_item w100 flex not_empty">
                                            <label class="check_radio_style1">
                                                <input type="checkbox" name="q" id="t2">
                                                <span class="icon"></span>
                                                با تکمیل ثبت نام موافقت خود را با کلیه قوانین و مقررات سایت اعلام مینمایم
                                            </label>
                                            <div class="frm_title">عدم نمایش پروفایل</div>
                                        </li>
                                        <li class="frm_item w100 flex not_empty">
                                            <label class="check_radio_style1">
                                                <input type="checkbox" name="q" id="t3">
                                                <span class="icon"></span>
                                                با تکمیل ثبت نام موافقت خود را با کلیه قوانین و مقررات سایت اعلام مینمایم
                                            </label>
                                            <div class="frm_title">عدم نمایش پروفایل</div>
                                        </li>
                                        <li class="frm_item w50">
                                            <button class="btn_style2 flex">
                                                <span class="icon"><i class="i-007-arrow-2"></i></span>
                                                <span class="text">ثبت تغییرات</span>
                                            </button>
                                        </li>
                                    </ul>
                                </form>
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