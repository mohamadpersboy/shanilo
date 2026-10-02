@extends('front.master')

@section('section')

<header class="header_style1">
    <div style="display: none;" class="header_part2">
        <ul class="step no_bullet flex">
            <li class="item"><a href="{{ route('front.home.index') }}" class="link"><span>صفحه اصلی </span></a></li>
            <li class="item"><a href="{{ route('front.guide.index') }}" class="link"><span>راهنمای سایت </span></a></li>
            <li class="item"><a href="{{ route('front.about.index') }}" class="link"><span>درباره ما </span></a></li>
            <li class="item"><a href="{{ route('front.contact.index') }}" class="link"><span>تماس با ما </span></a></li>
            <li class="item"><a href="{{ route('front.faq.index') }}" class="link"><span>پرسش و پاسخ متداول </span></a>
            </li>
            <li class="item"><a href="{{ route('front.policy.index') }}" class="link"><span>قوانین و سیاست ها
                    </span></a></li>
            <li class="item search"><a href="#" class="link"><span><i class="i-search"></i></span></a></li>
        </ul>
    </div>
    <div class="header_part3">
        <div class="container">

            <div class="personal_detail_style1">
                <div class="user_navigation box_shadow_style1 header_part3__main-nav">

                    <div class="list_menu">
                        <ul class="no_bullet flex main-menu-slider">
                            <li class="item"><a href="#" title="" class="link">کالای دیجیتالی</a></li>
                            <li class="item"><a href="#" title="" class="link">خودرو و لوازم جانبی</a></li>
                            <li class="item"><a href="#" title="" class="link">تزئینات ساختمانی</a>
                            </li>
                            <li class="item"><a href="#" title="" class="link">ابزارآلات و الکترونیک</a>
                            </li>
                            <li class="item"><a href="#" title="" class="link">ورزش و تندرستی</a></li>
                            <li class="item"><a href="#" title="" class="link">مد و لباس</a></li>
                            <li class="item"><a href="#" title="" class="link">آرایشی و بهداشتی</a></li>

                        </ul>
                    </div><!-- list_menu -->

                </div>

                <div class="home-slider">
                    @if ($sliders->count() > 0)
                    <div class="slide_style-m hide" id="homeSlider">
                    </div>
                    @endif
                    @if (!empty($min_image))
                    <div class="user_part1 flex home-social-text">
                        <div id="minImageSlider">
                            <!-- <div class="right_part user_pic" style="background-image: url({{ url('storage/app/public/' . optional($min_image)->path) }});">
                            </div> -->
                        </div>
                        <div class="left_part flex">

                            <div class="user_name flex checked">

                                <div class="name">ما را در شبکه های اجتماعی دنبال کنید</div>
                                <a href="#" title="" class="id">@shanilo_com</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

</header>
{{--<img src='http://gowebsite.ir/_images/under_label.png?ver=0.1' class='under_label'
        style='position:fixed; top:220px; right:0px; width:200px; z-index:10000;'>--}}
<section class="home_part1 z_index3">
    <div class="container">
        <div class="inner">

            <div class="socials-main flex">
                <div class="bg">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1311 47" style="enable-background:new 0 0 1311 47;" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                fill: none;
                                stroke: #000000;
                                stroke-miterlimit: 10;
                            }
                        </style>
                        <path class="st0" d="M0.5,27.5c0,0,306.1-38.5,665,0c382,41,646-18,646-18" />
                    </svg>
                </div>

                <div class="scroll-x" style="width: 100%;">
                    <ul class="socials-main__items flex" id="mainSocialNetwork"></ul>
                </div>

            </div>

        </div>
    </div>
</section>
<section class="home_part2 z_index3">
    <div class="container">
        <div class="inner">
            <div class="title_style3 flex">
                <div class="title_part flex">
                    <div class="title">پیشنهادات ویژه</div>
                    <div class="tag_part z_index2">
                        <ul class="step no_bullet flex controls">
                            <li data-filter="*" class="control item">
                                <span class="tag">همه</span>
                                <span class="icon"></span>
                            </li>
                            @foreach ($plans as $index => $plan)
                            <li data-filter=".plan-{{ $plan->id }}" class="control item">
                                <span class="tag">{{ $plan->title }}</span>
                                <span class="icon"></span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <a href="{{ route('front.specialSuggestion.index') }}" title="پیشنهادات ویژه" class="btn_part"><i class="i-link"></i></a>
            </div>
            <div class="box_style2">
                <ul class="step no_bullet flex">
                    @foreach ($firstPageSpecialSuggestions as $index => $firstPageSpecialSugesstion)
                    @include('front.partial.items.product',['productDetail'=>$firstPageSpecialSugesstion->productDetail,'class'=>'mix
                    plan-'.$firstPageSpecialSugesstion->plan_id])
                    @endforeach
                    <li class="gap"></li>
                    <li class="gap"></li>
                    <li class="gap"></li>
                </ul>
            </div>

            <div class="title_style3 flex">
                <div class="title_part flex">
                    <div class="title">فروش ویژه</div>
                </div>
                <a href="{{ route('front.specialSell.index') }}" title="" class="btn_part"><i class="i-link"></i></a>
            </div>
            @foreach ($specialSellCategories as $index => $specialSellCategory)

            <div class="subTitle_style1 flex">
                <div class="icon flex"><i class="{{ $specialSellCategory->icon }}"></i></div>
                <div class="title">{{ $specialSellCategory->title }}</div>
            </div>
            <div class="box_style2 slide_style1 hide bg3">
                @foreach ($specialSellCategory->first_page_special_sells
                ->orderBy('created_at', 'desc')
                ->limit(12)
                ->get()
                as $index => $firstPageSpecialSell)
                @include('front.partial.items.product',['productDetail'=>$firstPageSpecialSell->productDetail,'slide'=>true])
                @endforeach
            </div>
            @endforeach


        </div>
    </div>
</section>
<section class="home_part3 z_index3">
    <div class="container z_index4">
        <div class="inner">
            <div class="title_style5">برترین فروشگاه ها</div>
            <div class="box_style3 slide_style2 hide">
                @foreach ($shops as $index => $shop)
                @include('front.partial.items.shop')
                @endforeach
            </div>
            <a href="{{ route('front.shop.index') }}" title="" class="btn_style3">
                <span class="title"><i class="i-020-arrow"></i> مشاهده تمامی فروشگاه ها</span>
                <span class="bull"></span>
                <span class="bull"></span>
            </a>
        </div>
    </div>
</section>

@endsection

@section('js')


<script>
    $(document).ready(function() {

        //varibel this page
        var con_w = $('.container_style1').width();

        winSize = window.innerWidth;
        //win scroll
        $(window).scroll(function() {
            var body_sc = $(this).scrollTop();

            $('.header_style1 .bg').css({
                'width': 'calc(90vw + ' + body_sc / 7 + 'px)',
                'top': 'calc(80px + ' + body_sc / 4 + 'px)',
                'maxWidth': con_w - 24
            });
            $('.home_part1 .help_part').css({
                'bottom': 'calc(0 + ' + -body_sc / 2 + 'px)'
            });
        });

        ////////////////////////////////
        //mix it up
        var containerEl = document.querySelector('.box_style2 ');

        var mixer = mixitup(containerEl);
        /////////////////////////////////////////

        ////////////////////////////////
        //slide 1
        var slide1 = $(".slide_style1")
        slide1.on('init', function() {
            $(this).removeClass('hide');
        });
        slide1.slick({
            //            centerPadding: '250px',
            slidesToShow: 4,
            prevArrow: "<div class='arrow_style1 arrow slick-prev'><i class='z_index2 i-next'></i></div>",
            nextArrow: "<div class='arrow_style1 arrow slick-next'><i class='z_index2 i-back'></i></div>",
            autoplay: true,
            autoplaySpeed: 7000,
            pauseOnHover: true,
            speed: 1000,
            rtl: true,
            responsive: [{
                    breakpoint: 1210,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 750,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]

        });
        ////////////////////////////////
        //slide 2
        var slide2 = $(".slide_style2")
        slide2.on('init', function() {
            $(this).removeClass('hide');
        });
        slide2.slick({
            //            centerPadding: '250px',
            slidesToShow: 3,
            prevArrow: "<div class='arrow_style2 arrow slick-prev'><i class='z_index2 i-next'></i></div>",
            nextArrow: "<div class='arrow_style2 arrow slick-next'><i class='z_index2 i-back'></i></div>",
            autoplay: true,
            autoplaySpeed: 7000,
            pauseOnHover: true,
            speed: 1000,
            rtl: true,
            responsive: [{
                    breakpoint: 1210,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });


        ////////////////////////////////
        //slide 3
        var slide3 = $(".main-menu-slider")
        slide3.on('init', function() {
            $(this).removeClass('hide');
        });

        slide3.on('lazyLoaded', function(event, slick, direction) {
            console.log('edge was hit')
        });

        slide3.slick({
            //            centerPadding: '250px',
            dots: false,
            arrows: false,
            slidesToShow: 5,
            autoplay: true,
            autoplaySpeed: 3000,
            pauseOnHover: true,
            speed: 800,
            rtl: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 380,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        // socials
        const handleSocial = (title, follower, link) => {
            console.log(link)
            return ` <li class="item box_shadow_style1">
                            <a href="${link}" target="_blank">
                                <span class="title">${title}</span>
                                <span class="count">${follower}</span>
                            </a>
                        </li>`
        }
        $.ajax({
            url: "/social_network",
            type: "GET",
            cache: false,
            success: function(socials) {
                console.log(socials.social_networks);
                socials.social_networks.forEach(item => {
                    console.log(item);
                    $("#mainSocialNetwork").append(handleSocial(item.title, item.follower, item.link));
                });
            }
        });

    }); //document ready
</script>

@endsection