<footer class="z_index3">
    <div class="footer_style1">
        <div class="container container2 z_index3">
            <div class="inner z_index2 flex">
                <div class="logo_part">
                    <a href="https://shanilo.com" class="logo"></a>
                    <div class=' flex'>
                        <img src='' alt=''>
                        <a href='' target='_blank' title=""> </a>
                        <a href='' title='' target='_blank'> </a>
                    </div>
                </div>
                <div class="center_part flex">
                    <div class="news_letter">
                        <div class="title_style4 flex">
                            <span>عضویت درخبرنامه</span>
                            <div class="help_text_style1 has_tooltip">
                                <div class="help_icon"><i class="i-help"></i></div>
                                <div class="help_text tooltip_style1">
                                    کاربر گرامی ، با وارد نمودن آدرس ایمیل خود و عضویت در خبرنامه الکترونیک شانیلو می توانید سریع تر از دیگران از جدیدترین جشنواره های فروش و تخفیف های ویژه و آخرین اخبار و اطلاعات شانیلو باخبر شوید .
                                </div>
                            </div>
                        </div>
                        {!! Form::open([
                        'url'=>route('front.newsletter.store'),
                        'data-ajax',
                        'data-type'=>'json',
                        'data-on-success'=>'alert-message',
                        'data-on-error'=>'alert-message',
                        'data-clear'=>'true',
                        'class'=>'flex'
                        ]) !!}
                        <input type="text" name="email" placeholder=".::Email" data-valid-required data-valid-email>
                        <button></button>
                        {!! Form::close() !!}
                    </div>
                    <div class="link_part">
                        <ul class="step no_bullet flex">
                            <li class="item"><a href="{{route('front.home.index')}}" class="link"><span>صفحه اصلی </span></a></li>
                            <li class="item"><a href="{{route('front.guide.index')}}" class="link"><span>راهنمای سایت </span></a></li>
                            <li class="item"><a href="{{route('front.about.index')}}" class="link"><span>درباره ما </span></a></li>
                            <li class="item"><a href="{{route('front.contact.index')}}" class="link"><span>تماس با ما </span></a></li>
                            <li class="item"><a href="{{route('front.faq.index')}}" class="link"><span>پرسش و پاسخ متداول </span></a></li>
                            <li class="item"><a href="{{route('front.policy.index')}}" class="link"><span>قوانین و سیاست ها </span></a></li>
                            <li class="item"><a href="{{route('front.sitemap.index')}}" class="link"><span>نقشه سایت</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="elogo_part flex">
                    <div class="elogo1 elogo"><a href="#" title="" class="link">
                            <a target="_blank" href="https://trustseal.enamad.ir/?id=169308&amp;Code=qlWHDFluZFfsMAdWaXdx"><img src="https://Trustseal.eNamad.ir/logo.aspx?id=169308&amp;Code=qlWHDFluZFfsMAdWaXdx" alt="" style="cursor:pointer" id="qlWHDFluZFfsMAdWaXdx"></a>
                    </div>
                    {{--<div class="elogo2 elogo"><a href="#" title="" class="link"><img src="_images/bg/elogo.png" alt=""></a></div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="goto_top"><i class="i-up-arrow"></i></div>
</footer>
<div class="modal_style1 search_modal w800">
    <div class="modal_scroll flex">
        <div class="close_bg"></div>
        <div class="wrapper">
            <div class="wrapper_box">
                <div class="close_btn"><i class="i-cancel"></i></div>
                <div class="search_form">
                    <form id="search-form" action="{{route('front.search')}}" class="flex">
                        <input id="search-input" type="text" placeholder="جستجو کنید ...">
                        <div class="loading">
                            <div class="loading_img"></div>
                        </div>
                    </form>
                </div>
                <div id="search-result" class="search_result">
                    <div class="have_scroll_y scroll_style1">
                        <ul class="step no_bullet">

                        </ul>
                    </div>
                </div>
                {{-- <div class="search_box_style">
                    <div class="box_style4">
                        <div class="more_loading"></div>
                        <a href="" class="see_more_style1"><span>مشاهده بیشتر</span></a>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
</div>
<div class="compare_style1" style="display:{{Comparison::count()?'block':'none'}};">
    <div class="wrapper">
        <div class="top_part flex">
            <div class="title flex"><span>لیست مقایسه محصول</span>
                <div id="comparison-count" class="count">{{Comparison::count()}}</div>
            </div>
            <div class="down_btn active"><i class="i-resize-full"></i></div>
        </div>
        <div class="bottom_part flex" style="display: none;">
            <ul class="step no_bullet flex">
                @include('front.partial.ajax.comparison')
            </ul>
            <a href="{{route('front.comparison.index')}}" title="" class="compare_btn flex"><span>مقایسه محصولات</span></a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.compare_style1 .top_part .down_btn').click(function() {
            $('.compare_style1 .bottom_part').slideToggle(300);
            $(this).toggleClass('active');
        });

        ////////////////////////////////
        //slider main

        setTimeout(() => {
            var slide3 = $(".slide_style-m")
            slide3.on('init', function() {
                $(this).removeClass('hide');
            });

            slide3.on('lazyLoaded', function(event, slick, direction) {
                console.log('edge was hit')
            });

            slide3.slick({
                //            centerPadding: '250px',
                dots: true,
                slidesToShow: 1,
                prevArrow: "<div class='arrow_style-main slick-prev arrow'><i class='z_index2 i-next'></i></div>",
                nextArrow: "<div class='arrow_style-main slick-next'><i class='z_index2 i-back'></i></div>",
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: true,
                speed: 800,
                rtl: true,
                adaptiveHeight: false
            });
            $('.home-slider .slick-dots li button').html("");

        }, 1000);

        // gallery
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            observer: true,
            observeParents: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            },
            zoom: true
        });
        var galleryTop = new Swiper('.product-gallery-mobile', {
            spaceBetween: 10,
            observer: true,
            observeParents: true,
        });

    }); //document ready
</script>