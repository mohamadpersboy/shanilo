@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.user-page-menu')
                    <div class="personal_detail_style2">
                        <div class="title_style5"><span>فروشگاه های من</span></div>
                        <div class="box_style5">
                            @if($shops->count())
                            <ul class="step flex no_bullet">
                                @foreach($shops as $index=>$shop)
                                    <li class="item">
                                        <a href="{{$shop->path()}}" title="" class="pic_part">
                                            <div class="pic"
                                                 style="background-image: url('{{$shop->takeImage('background','278/180')}}');"></div>
                                            <div class="pic_btn flex"><i class="i-search"></i><span>مشاهده</span></div>
                                        </a>
                                        <div class="box_link box_shadow_style1">
                                            <ul class="step2 no_bullet flex">
                                                @if(canEditShop($shop))
                                                    <li class="item2">
                                                        <a href="{{route('front.profile.shop.edit',$shop)}}" title=""
                                                           class="link2 flex">
                                                            <div class="icon"><i class="i-045-mark"></i></div>
                                                            <div class="tooltip right tooltip_style2">ویرایش فروشگاه
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif
                                              {{--  @if(!canEditShop($shop))
                                                    <li class="item2">
                                                        <a href="#" title="" class="link2 flex">
                                                            <div class="icon"><i class="i-048-bookmark"></i></div>
                                                            <div class="tooltip right tooltip_style2">افزودن به علاقه
                                                                مندی
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endif--}}
                                                <li data-model="{{\App\Models\Specific\Shop::class}}" data-id="{{$shop->id}}" class="item2 share_btn">
                                                    <a   href="javascript:void(0)" title="" class="link2 flex">
                                                        <div class="icon"><i class="i-036-share"></i></div>
                                                        <div class="tooltip right tooltip_style2">ارسال برای دوستان
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="item2">
                                                    <a data-url="{{route('front.comment.index',['shop',$shop->id])}}" href="javascript:void(0)" title="" class="link2 modal_btn btn-comments show_more_btn flex">
                                                        <div class="icon"><i class="i-016-bubble"></i></div>
                                                        <div class="tooltip  right tooltip_style2">مشاهده نظرات</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="{{$shop->path()}}" class="name ellipsis">{{$shop->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                             @elseif(canEditUser($user))
                                @include('front.partial.parts.build-new-shop')
                             @else
                                <div class="noItem_style2 flex">موردی اضافه نشده!</div>
                            @endif
                        </div>

                    </div><!-- personal_detail_style2 -->
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.share-modal')
    @include('front.plugins.comment-modal')
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
            ////////////////////////////////////////////////
            //open edit form

            //////////////////////////////////////////////////////////////////


        });//document ready

    </script>

@endsection
