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
                                    'url'=>route('front.profile.article.store'),
                                    'data-ajax',
                                    'data-type'=>'json',
                                    'data-on-success'=>'alert-message',
                                    'data-on-error'=>'inline-message',
                                    'data-clear'=>'true'
                                  ]) !!}
                                    @include('front.pages.profile.article.form')
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