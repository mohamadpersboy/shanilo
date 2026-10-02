@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.user-page-menu')
                    <div class="personal_detail_style2">
                        <div class="title_style5"><span>مجلات من</span></div>
                        <div class="box_style7">
                            @if($articles->count())
                                <ul id="article-container" class="step flex no_bullet">
                                    @include('front.partial.items.articles')
                                    <li class="gap before-list"></li>
                                    <li class="gap"></li>
                                    <li class="gap"></li>
                                </ul>
                                @if(hasMorePage($articles))
                                    <a data-url="{{$user->path('articles')}}"
                                       data-parent="#article-container"
                                       data-item=".before-list"
                                       data-page="1" href="javascript:void(0)"
                                       class="see_more_style1 btn-load-more type2">
                                        <span>مشاهده بیشتر</span>
                                    </a>
                                @endif
                            @else
                                <div class="noItem_style2 flex">هیچ مجله ای یافت نشد!</div>
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

            //////////////////////////////////////////////////////////////////


        });//document ready

    </script>

@endsection
