@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.user-page-menu')
                    <div class="personal_detail_style2">
                        <div class="user_about_page">
                            <p id="field-description" class="content">{{$user->description}}</p>
                            @if(canEditUser($user))
                            <div class="edit_part edit_form_style1 flex">
                                <div class="edit_icon"><i class="i-pencil"></i></div>
                                <div class="edit_form">
                                    {!! Form::open([
                                   'url'=>route('front.user-page.update-field',$user),
                                   'data-ajax',
                                   'method'=>'patch',
                                   'data-on-error'=>'hide-alert-message',
                                   'data-on-success'=>'hide-update',
                                   'data-field'=>'#field-description',
                                   'data-type-json',
                                   'class'=>'flex'
                                   ]) !!}
                                    {!! Form::hidden('id',$user->id) !!}
                                    {!! Form::hidden('_sid',bcrypt($user->id)) !!}
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

    @if(canEditUser($user))
    @include('front.partial.upload-img-profile')
    @include('front.partial.upload-img')
    @endif
    @include('front.partial.user-page-modals')
@endsection

@section('js')


    <script>

        $(document).ready(function () {
            /////////////////////////////
            //add active class
            $('.personal_detail_style1 .user_part2').addClass('active');
            /////////////////////////////
            //sub2
            $('.have_sub').click(function () {
                var sub = $(this).find('.sub_style2');
                var sub_display = $(this).find('.sub_style2').css('display');

                if (sub_display == 'none') {
                    sub.fadeIn(300);
                    $(this).addClass('active');
                } else {
                    sub.fadeOut(300);
                }

            });
            $("body").click(function (e) {
                if (!$(e.target).is(".have_sub") && !$(e.target).is(".have_sub *")) {
                    $('.sub_style2').fadeOut(300);
                }
            });//body click


        });//document ready

    </script>

@endsection
