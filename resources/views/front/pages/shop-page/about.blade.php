@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
                <div class="container">
                    <div class="inner">
                        @include('front.partial.market-page-menu')
                        <div class="personal_detail_style2">
                            <div class="user_about_page">
                                <p id="field-description" class="content">{{$shop->description}}</p>
                                @if(canEditShop($shop))
                                <div class="edit_part edit_form_style1 flex">
                                    <div class="edit_icon"><i class="i-pencil"></i></div>
                                    <div class="edit_form">
                                        {!! Form::open([
                                          'url'=>route('front.shop-page.update-field',$shop),
                                          'data-ajax',
                                          'method'=>'patch',
                                          'data-on-error'=>'hide-alert-message',
                                          'data-on-success'=>'hide-update',
                                          'data-field'=>'#field-description',
                                          'data-type-json',
                                          'class'=>'flex'
                                          ]) !!}
                                        {!! Form::hidden('id',$shop->id) !!}
                                        {!! Form::hidden('_sid',bcrypt($shop->id)) !!}
                                        {!! Form::hidden('field','description') !!}
                                            <textarea class="form_type" name="value"></textarea>
                                            <button><i class="i-check-square-o"></i></button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div><!-- personal_detail_style2 -->
                    </div><!-- .inner -->
                </div><!-- .container -->
        </div><!-- .user_page -->
    </section>


    @if(canEditShop($shop))
        @include('front.partial.upload-img-profile-shop')
        @include('front.partial.upload-img-shop')
    @endif
    @include('front.partial.shop-page-modals')
@endsection

@section('js')


    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection
