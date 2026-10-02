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
                                        {!! Form::open([
                                            'url'=>route('front.profile.shop.store'),
                                            'data-ajax',
                                            'data-type'=>'json',
                                            'data-on-error'=>'inline-message',
                                            'data-on-success'=>'redirect',
                                            'data-clear'=>true,
                                        ]) !!}
                                        @include('front.pages.profile.shop.form')
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
    @include('front.plugins.market-client-modal')

@endsection

@section('js')

    @include('front.plugins.city-select-2')
    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection
