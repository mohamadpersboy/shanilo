@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>
                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            <div class="product_edit flex">
                                <div class="form_style2">
                                    @include('front.partial.parts.product-detail-form-header')
                                    {!! Form::open([
                                        'url'=>route('front.profile.productDetail.store',$product),
                                        'data-ajax',
                                        'data-type'=>'json',
                                        'data-on-success'=>'alert-message',
                                        'data-on-error'=>'inline-message',
                                        'data-clear'=>'clear'
                                    ]) !!}

                                        @include('front.pages.profile.product_detail.form')
                                    {!! Form::close() !!}
                                </div>
                                @include('front.partial.parts.side-product-info')
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
            //Select color
            $('.color_select_style1').change(function(){
                var color = $('.color_select_style1 option:selected').attr('data-color');
                $('.color_select_style1 ~ .color').css('background-color',color);
            })

        });//document ready
    </script>
@endsection