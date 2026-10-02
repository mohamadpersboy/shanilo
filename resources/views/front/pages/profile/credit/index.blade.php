@extends('front.master')

@section('section')
    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>
                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            @include('front.partial.parts.wallet-header')
                            <div class="title_style8"><span>افزایش موجودی</span></div>
                            <div class="panel_cart_give_money flex">
                                <div class="form_style2">
                                        {!! Form::open([
                                        'url'=>route('front.profile.credit.store'),
                                                                           ]) !!}
                                        <ul class="frm_step flex no_bullet">
                                            <li class="frm_item flex w50 not_empty">
                                                <input type="text" class="frm_input currency" name="price"
                                                       placeholder="مبلغ مورد نظر خود را وارد نمایید.">
                                                <div class="frm_title">مبلغ (تومان)</div>
                                            </li>
                                            <li class="frm_item w100 row_flex flex">
                                                <button class="btn_style2 flex">
                                                    <span class="icon"><i class="i-044-checked"></i></span>
                                                    <span class="text">پــرداخت</span>
                                                </button>
                                            </li>
                                        </ul>
                                  {!! Form::close() !!}
                                </div>
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