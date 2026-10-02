@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
                <div class="container">
                    <div class="inner">
                        @include('front.partial.user-page-menu')
                        @include('front.partial.items.article-detail')
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

                if( sub_display == 'none'){
                    sub.fadeIn(300);
                    $(this).addClass('active');
                } else{
                    sub.fadeOut(300);
                }

            });
            $("body").click(function (e) {
                if (!$(e.target).is(".have_sub") && !$(e.target).is(".have_sub *")) {
                    $('.sub_style2').fadeOut(300);
                }
            });//body click

            //////////////////////////////////////////////////////////////////



        });//document ready

    </script>

@endsection
