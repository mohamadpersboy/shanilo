@extends('front.master')
@section('v2-front-style')
<meta name="product_id" content="{{ $productDetail->id }}">
<meta name="product_name" content="{{ optional($productDetail->product)->title }}">
<meta name="product_price" content="{{ $productDetail->price }}">
<meta property="og:image" content="{{ $productDetail->product->takeImage('main','560/290') }}">
@endsection
@section('v1-front-style')

<style>
    .show-short-link-input {
        width: 100%;
        padding: 10px;
        border: solid 1px #ffffff;
        border-radius: 5px;
        margin: 10px;
        text-align: center;
        background-color: #ffffff;
    }
</style>
@endsection
@section('section')

<section class="other_page">
    <div class="container">
        <div class="inner">
            <div class="filter_style2 flex">
                <div class="category_select">
                    <div class="category_btn flex">
                        <span class="icon"><i class="i-012-list"></i></span>
                        {{--<span class="text tooltip top">دسته بندی</span>--}}
                    </div>
                </div><!-- category_select -->
                <div class="filtering_show">
                    <div class="filter_selected">
                        <ul class="step no_bullet flex">
                            @foreach($productDetail->breadcrumbs as $index=>$breadcrumb)
                            <li class="item"><a href="{{$breadcrumb->path()}}" title="" class="link">{{$breadcrumb->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- filtering_show -->
            </div><!-- filter_style2 -->
            <div id="pjax-container">
                @if(($productDetail->specialSuggestion && $productDetail->specialSuggestion->firstPageSpecialSuggestion) || ($productDetail->specialSell && $productDetail->firstPageSpecialSell))
                <div style="display: none;" id="special-suggestion" data-date="{{$productDetail->specialSuggestion->firstPageSpecialSuggestion->expires_at}}" class="off_style1 flex">
                    <div class="title z_index2">پیشنهاد شگفت انگیز</div>
                    <div class="timer z_index2 flex">

                        <div class="time_box flex"><span id="months"></span><span class="text">ماه</span></div>
                        <div class="time_box flex"><span id="days"></span><span class="text">روز</span></div>
                        <div class="time_box flex"><span id="hours"></span><span class="text">ساعت</span></div>
                        <div class="time_box flex"><span id="minutes"></span><span class="text">دقیقه</span>
                        </div>
                        <div class="time_box flex"><span id="seconds"></span><span class="text">ثانیه</span>
                        </div>

                    </div>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 3275.7 1183.2" style="enable-background:new 0 0 3275.7 1183.2;" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                opacity: 0.2;
                                fill: url(#SVGID_1_);
                            }

                            .st1 {
                                opacity: 0.2;
                                fill: url(#SVGID_2_);
                            }

                            .st2 {
                                opacity: 0.2;
                                fill: url(#SVGID_3_);
                            }
                        </style>
                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="2096.5481" y1="875.6239" x2="2096.5481" y2="1.583862e-02">
                            <stop offset="0" style="stop-color:#FFFFFF;stop-opacity:0"></stop>
                            <stop offset="1" style="stop-color:#FFFFFF"></stop>
                        </linearGradient>
                        <path class="st0" d="M1918,873.7c598.9,26.5,1048-231.1,1238-585.7c54.1-101,82.2-199.5,94.9-288H1197.1
	c-76.1,214.3-148.9,363.5-254.9,531.8C1281.2,768,1495.2,855,1918,873.7z"></path>
                        <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="471.084" y1="1183.1841" x2="471.084" y2="149.0251">
                            <stop offset="0" style="stop-color:#FFFFFF;stop-opacity:0"></stop>
                            <stop offset="1" style="stop-color:#FFFFFF"></stop>
                        </linearGradient>
                        <path class="st1" d="M312.8,1183.2C523,1064.1,707.2,875.7,794.9,750.9c56.2-79.9,104.4-151,147.2-219.1
	c-71.3-49.7-147.8-105.6-233.4-169.3C478.6,191.1,221,128.1,0,155v1028.2H312.8z"></path>
                        <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="1794.2656" y1="1340.0159" x2="1794.2657" y2="544.0963">
                            <stop offset="0" style="stop-color:#FFFFFF;stop-opacity:0"></stop>
                            <stop offset="1" style="stop-color:#FFFFFF"></stop>
                        </linearGradient>
                        <path class="st2" d="M1918,873.7C1495.2,855,1281.2,768,942.2,531.8c-42.9,68.1-91.1,139.2-147.2,219.1
	c-87.7,124.8-272,313.2-482.1,432.3h2962.9V0h-24.8c-12.7,88.6-40.8,187-94.9,288C2966,642.7,2516.9,900.3,1918,873.7z"></path>
                    </svg>
                </div>
                @endif
                <div class="product_detail flex">
                    <div class="right_part">
                        <div class="pic_part product-gallery-desktop">
                            <div class="big_pic flex">
                                <div class="loading_style1"></div>
                                <img class="xzoom4" id="xzoom-fancy" src="{{$productDetail->product->takeImage('main','560/290')}}" xoriginal="{{$productDetail->product->takeImage('main')}}">
                            </div>
                            <div class="xzoom-thumbs flex">
                                <a class="flex small_pic" href="{{$productDetail->product->takeImage('main')}}">
                                    <img class="xzoom-gallery4" width="80" src="{{$productDetail->product->takeImage('main','100/50')}}" xpreview="{{$productDetail->product->takeImage('main')}}" title="{{$productDetail->product->title}}">
                                </a>
                                @foreach($productDetail->product->attachments->where('slug','gallery') as $index=>$gallery)
                                <a class="flex small_pic" href="{{$productDetail->product->takeImageWithName($gallery->file_name)}}"><img class="xzoom-gallery4" width="80" src="{{$productDetail->product->takeImageWithName($gallery->file_name,'100/50')}}" xpreview="{{$productDetail->product->takeImageWithName($gallery->file_name)}}" title="{{$productDetail->product->title}}"></a>
                                @endforeach
                            </div>
                        </div>

                        <!-- <div class="product-gallery-mobile flex">
                            <div class="item">
                                <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImage('main')}}">
                            </div>
                            @foreach($productDetail->product->attachments->where('slug','gallery') as $index=>$gallery)
                            <div class="item">
                                <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImageWithName($gallery->file_name)}}">
                            </div>
                            @endforeach
                        </div> -->

                        <div class="swiper-container product-gallery-mobile">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide" style="background-image:url(./images/nature-1.jpg)">
                                    <div class="swiper-zoom-container">
                                        <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImage('main')}}">
                                    </div>
                                </div>
                                @foreach($productDetail->product->attachments->where('slug','gallery') as $index=>$gallery)
                                <div class="swiper-slide">
                                    <div class="swiper-zoom-container">

                                        <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImageWithName($gallery->file_name)}}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>

                    </div>
                    <div class="left_part">

                        <div class="title_part flex">

                            <div class="name">{{$productDetail->product->title}}</div>
                            <div class="product_action">
                                <ul class="step flex no_bullet">
                                    <li id="show-tooltip-li" class="item short-link-li">
                                        <div class="link">
                                            <i class="i-link"></i>
                                            <span class="tooltip tooltip_style2">دریافت لینک محصول</span>
                                        </div>
                                    </li>
                                    <li data-url="{{route('front.favorite.toggle',$productDetail)}}" class="item btn-favorite in-details {{Favorite::has($productDetail)?'active':''}}">
                                        <div class="link">
                                            <i class="i-048-bookmark"></i>
                                            @if(Favorite::has($productDetail))
                                            <span class="tooltip tooltip_style2">موجود در علاقه مندی</span>
                                            @else
                                            <span class="tooltip tooltip_style2">افزودن به علاقه مندی ها</span>
                                            @endif
                                        </div>
                                    </li>
                                    @auth
                                    @if(!auth()->id()!=$productDetail->product->shop->user_id)
                                    @php
                                    $inNotifyList=auth()->user()->hasItInNotifyLists($productDetail);
                                    @endphp
                                    <li data-url="{{route('front.notifylist.toggle',['productDetail',$productDetail->id])}}" class="item in-details btn-notify-list {{$inNotifyList?'active':''}}">
                                        <div class="link">
                                            <i class="i-010-bell"></i>
                                            <span class="tooltip tooltip_style2">{{$inNotifyList?'موجود در اطلاع رسانی':'اطلاع رسانی'}}</span>
                                        </div>
                                    </li>
                                    @if($productDetail->product->isReportedByAuth())
                                    <li class="item reported">
                                        <div class="link">
                                            <i class="i-warning-sign"></i>
                                            <span class="tooltip tooltip_style2">گزارش شد</span>
                                        </div>
                                    </li>
                                    @else
                                    <li data-url="{{route('front.report.create',['product',$productDetail->product_id])}}" class="item btn-create-report modal_btn">
                                        <div class="link">
                                            <i class="i-warning-sign"></i>
                                            <span class="tooltip tooltip_style2">گزارش خرابی</span>
                                        </div>
                                    </li>
                                    @endif

                                    @endif
                                    <li class="item share_style1_btn">
                                        <div class="link">
                                            <i class="i-036-share"></i>
                                            <span class="tooltip tooltip_style2">ارسال برای دوستان</span>
                                        </div>
                                        <div class="share_style1">
                                            <div class="title_style8"><span>ارسال برای دوستان</span></div>
                                            <div class="search_style1" style="display: block;">
                                                {!! Form::open([
                                                'url'=>route('front.share-with-friends'),
                                                'data-ajax',
                                                'data-type'=>'json',
                                                'data-on-success'=>'alert-message',
                                                'data-on-error'=>'alert-message',
                                                'data-clear'=>'true',
                                                'class'=>'flex',
                                                'id'=>'frm-send-to-friends'
                                                ]) !!}
                                                {!! Form::hidden('users','') !!}
                                                {!! Form::hidden('product_detail_id',$productDetail->id) !!}
                                                {!! Form::hidden('product_detail_sid',bcrypt($productDetail->id)) !!}
                                                <input data-url="{{route('front.friends-to-share')}}" type="text" placeholder="نام کاربری دوست خود را وارد کنید">
                                                <div class="loading hide"></div>
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="search_result_style1">
                                                <div class="have_scroll_y scroll_style1">
                                                    <ul id="share-friend-list" class="step2 no_bullet">

                                                    </ul>
                                                </div>
                                                <button class="btn_style2">ارســـال</button>
                                            </div>
                                        </div>
                                    </li>
                                    @endauth
                                </ul>
                            </div>


                        </div>
                        <div id="show-short-link" style="display: none">
                            <input class="show-short-link-input" id="show-tooltip" value="">
                        </div>
                        <div class="creator_part flex">
                            <div class="pic_part">
                                <div class="market_part">
                                    <a href="{{$productDetail->shop->path()}}" title="" class="link flex">
                                        <div class="pic" style="background-image: url('{{$productDetail->shop->takeImage('avatar','172/172','user.png')}}');"></div>
                                        <div class="name user_name_style1 ">{{$productDetail->shop->title}}</div>
                                    </a>
                                </div>
                                <div class="user_part">
                                    <a href="{{$productDetail->user->path()}}" title="" class="link flex">
                                        <div class="pic" style="background-image: url('{{$productDetail->user->takeImage('avatar','172/172','user.png')}}');"></div>
                                        <div class="name user_name_style1 {{$productDetail->user->confirmed_by_admin?'checked':''}}">{{getUsersFullName($productDetail->user)}}</div>
                                    </a>
                                </div>
                            </div>
                            <div class='rate_style1 pointer_event'>
                                @include('front.partial.items.rate',['rate'=>$productDetail->product->rate])
                                <div class="rate_text">امتیاز ثبت شده میان
                                    <span>{{$productDetail->product->comments()->confirmed()->parents()->count()}}</span>
                                    نفر
                                </div>
                            </div><!-- rate_style1 -->
                        </div>
                        <div class="info_part">
                            <ul class="step flex no_bullet">
                                <li class="item flex">
                                    <span class="icon"><i class="i-011-eye"></i></span>
                                    <span class="text">تعداد بازدید: <span>{{$productDetail->product->views}}</span></span>
                                </li>
                                <li class="item flex">
                                    <span class="icon"><i class="i-027-clock"></i></span>
                                    <span class="text">تاریخ انتشار: <span>{{$productDetail->product->created_at->diffForHumans()}}</span></span>
                                </li>
                                <li class="item flex">
                                    <span class="icon"><i class="i-009-shopping-cart"></i></span>
                                    <span class="text">تعداد خریداری شده: <span>{{$productDetail->product->sell_count}}</span></span>
                                </li>
                            </ul>
                        </div>
                        <div class="location_part flex">
                            <div class="market_pin flex"><i class="i-019-placeholder icon"></i> ارسال از
                                <span>{{$productDetail->shop->city->name}}</span> به
                                <div class="help_text_style1">
                                    <div class="help_icon"><i class="i-help"></i></div>
                                    <div class="help_text tooltip_style1 loading" style="display: none;">کاربر گرامی
                                        ، در حال حاضر فروشگاه مورد نظر صرفا به شهر های زیر امکان سرویس دهی دارد .
                                    </div>
                                </div>
                            </div>
                            <div class="market_send">
                                {{$productDetail->product->shop->cityList}}
                            </div>
                        </div>
                        <div class="filter_style1">
                            <ul class="step no_bullet flex">
                                @foreach($productDetail->product->properties as $index=>$property)
                                <li class="item">
                                    <div class="select_part">
                                        <select name="properties[]">
                                            <option value="">{{$property->title}}</option>
                                            @foreach($property->details as $index=>$propertyDetail)
                                            <option value="{{$propertyDetail->id}}">{{$propertyDetail->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="color_select flex">
                            {{-- <div class="title">انتخاب رنگ :</div>--}}
                            <div class="color_part">
                                <ul class="step no_bullet flex">
                                    @foreach($productDetail->product->details as $index=>$detail)
                                    <li class="item">
                                        <label class="check_radio_style2 flex">
                                            <span class="name">{{$detail->feature?$detail->feature.' ':''}}{{$detail->color->code!=='#00NANNAN'?$detail->color->title:''}}</span>
                                            <input data-url="{{$detail->path()}}" class="rdo-product-color" type="radio" name="color" value="{{$detail->id}}" {{$productDetail->id==$detail->id?'checked':''}}>
                                            <span class="color" style="background-color:{{$detail->color->code}};"></span>
                                        </label>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <div class="price_part flex">
                            <div class="price_style1 flex">
                                @if($productDetail->count <= 0) <span style="font-size: 35px">{!! trans('messageShop.unavailable-product') !!}</span>
                                    @elseif($productDetail->discount)
                                    <span class="org_price price">{{showPrice($productDetail->price,null,null)}}</span>
                                    <span class="off_price price">{{showPrice($productDetail->pure_price,null,null)}}</span>
                                    @else
                                    <span class="off_price price">{{showPrice($productDetail->pure_price,null,null)}}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="btn_part flex">
                            <div data-url="{{route('front.product.clients',$productDetail)}}" class="user_shoped btn-clients modal_btn flex">
                                <div class="icon"><i class="i-tag"></i></div>
                                <div class="text">مشاهده خریداران این محصول</div>
                            </div>
                            @php
                            $inCart=Cart::has($productDetail);
                            @endphp
                            @if($productDetail->count > 0)
                            <a href="javascript:void(0)" data-url="{{route('front.cart.toggle',$productDetail)}}" class="btn_style2 btn-toggle-cart {{$inCart?'in_cart':''}} flex z_index4">
                                <!-- disable btn class === .disable -->
                                <span class="icon"><i class="i-009-shopping-cart"></i></span>
                                <span class="text">{{$inCart?'حذف از سبد خرید':'افزودن به سبد خرید'}}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_detail_part2 flex">
                <div class="left_part box_shadow_style1">
                    <div class="tab_style1">
                        <div class="top_part">
                            <ul class="step no_bullet flex">
                                <li class="item title_style7 
                                    {{ $productDetail->product->description   ? 'active' : ''  }}
                                    " data-tab="tab1">
                                    <span>توضیحات فنی</span>
                                </li>
                                <li class="item title_style7 
                                    {{ !$productDetail->product->description && $productDetail->product->productCategoryTechnicalSpecifications->count() ? 'active' : '' }}" data-tab="tab2"><span>مشخصات فنی</span></li>
                            </ul>
                        </div>
                        <div class="bottom_part">
                            <ul class="step no_bullet">
                                <li class="item " data-tab="tab1" @if(!$productDetail->product->description) style="display:none" @endif>
                                    <article class="content_style1 line-break">
                                        {!! $productDetail->product->description !!}
                                    </article>
                                </li>
                                <li class="item" data-tab="tab2" @if(!$productDetail->product->productCategoryTechnicalSpecifications->count() || $productDetail->product->description) style="display:none" @else style="display:list-item" @endif>
                                    <div class="table_style2">
                                        <table>
                                            @foreach($productDetail->product->productCategoryTechnicalSpecifications as $index=>$productCategoryTechnicalSpecification)
                                            <tr>
                                                <td>{{$productCategoryTechnicalSpecification->technicalSpecification->title}}</td>
                                                <td class="tright">{{$productCategoryTechnicalSpecification->pivot->value}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="right_part box_shadow_style1">
                    <div class="title_style7 z_index3"><span class="title">نظرات</span></div>
                    {{--<div class="no_item"><div class="icon"><i class="i-016-bubble"></i></div><div class="text">تاکنون هیچ نظری ثبت نشده!</div></div>--}}
                    <div class="comment_style1">

                        <div class="list">
                            @if($comments->count())
                            <ul class="step1 no_bullet">
                                @foreach($comments->take(4) as $index=>$comment)
                                @include('front.partial.items.comment',['canAnswer'=>false,'noButton'=>true])
                                @endforeach
                            </ul>
                            <!--close .step1-->
                            @else
                            <div class="noItem_style2 flex">در حال حاضر هیچ نظری ثبت نشده است!</div>
                            @endif
                        </div>
                        <!--close .list-->
                        <div data-url="{{route('front.comment.index',['product',$productDetail->product_id])}}" class="show_more_btn btn-comments modal_btn flex">مشاهده نظرات بیشتر<i class="i-search"></i></div>
                    </div>
                    @auth
                    <div data-url="{{route('front.comment.index',['product',$productDetail->product_id])}}" class="btn_style6 btn-comments z_index3 violet show_more_btn modal_btn">ثبت نظر
                    </div>
                    @endauth
                </div>
            </div>
            <div class="product_detail_part3 mt70">
                {{--<div class="title_style3 flex">
                        <div class="title_part flex">
                            <div class="title">محصولات مرتبط</div>
                        </div>
                        <a href="#" title="" class="btn_part"><i class="i-link"></i></a>
                    </div>--}}
                <div class="title_style8"><span>محصولات مرتبط</span></div>
                <div class="box_style2">
                    <ul class="step no_bullet flex">
                        @foreach($productDetail->relatedProducts()->latest()->limit(4)->get() as $index=>$relatedProduct)
                        @include('front.partial.items.product',['productDetail'=>$relatedProduct])
                        @endforeach


                        <li class="gap"></li>
                        <li class="gap"></li>
                        <li class="gap"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal_style3 gallery_modal w800">
    <div class="modal_scroll flex">
        <div class="close_bg"></div>
        <div class="wrapper">
            <div class="wrapper_box">
                <div class="close_btn"><i class="i-cancel"></i></div>
                <!-- <div class="product-gallery-mobile flex">
                    <div class="item">
                        <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImage('main')}}">
                    </div>
                    @foreach($productDetail->product->attachments->where('slug','gallery') as $index=>$gallery)
                    <div class="item">
                        <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImageWithName($gallery->file_name)}}">
                    </div>
                    @endforeach
                </div> -->



                <!-- Swiper -->
                <div class="swiper-container gallery-top">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image:url(./images/nature-1.jpg)">
                            <div class="swiper-zoom-container">
                                <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImage('main')}}">
                            </div>
                        </div>
                        @foreach($productDetail->product->attachments->where('slug','gallery') as $index=>$gallery)
                        <div class="swiper-slide">
                            <div class="swiper-zoom-container">

                                <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImageWithName($gallery->file_name)}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                </div>
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image:url(./images/nature-1.jpg)">
                            <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImage('main')}}">
                        </div>
                        @foreach($productDetail->product->attachments->where('slug','gallery') as $index=>$gallery)
                        <div class="swiper-slide">
                            <img class="product-gallery-mobile__img" src="{{$productDetail->product->takeImageWithName($gallery->file_name)}}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('front.plugins.comment-modal')
@include('front.plugins.user-modal')
@include('front.plugins.report-modal')

@endsection

@section('js')

<!-- zoom -->
<script type="text/javascript" src="_plugins/xZoom-master/dist/xzoom.min.js"></script>
<link rel="stylesheet" type="text/css" href="_plugins/xZoom-master/dist/xzoom.css?ver=32" media="all" />
<!-- zoom fancy box -->
{{-- <link type="text/css" rel="stylesheet" media="all" href="fancybox/source/jquery.fancybox.css" />
     <script type="text/javascript" src="fancybox/source/jquery.fancybox.js"></script>--}}

<script>
    $(document).ready(function() {

        ///////////////////////////////////////////
        //tab style1
        $('.tab_style1 .top_part .item').click(function() {
            ////////border
            var bg = $(this).attr('data-tab');
            $(this).addClass('active');
            $(this).siblings('.item').removeClass('active');
            ////////tab slide
            var target = $(this).attr('data-tab');
            var target_bottom = $('.tab_style1 .bottom_part .item[data-tab=' + target + ']');
            if (target_bottom.css('display') != 'block') {
                $('.tab_style1 .bottom_part .item').removeClass('active').fadeOut(200);
                target_bottom.stop().fadeIn(300);
            } else {
                target_bottom.stop().fadeIn(0, function() {
                    $(this).addClass('active');
                });
            }
            ////////tab height
            var item_height = $('.tab_style1 .bottom_part').find(target_bottom).height();
            $('.tab_style1 .bottom_part').stop(true, false).animate({
                'height': item_height
            }, 600);
        }); //END tab style 1
        //first view
        $(window).load(function() {
            var item_height = $('.tab_style1 .bottom_part .item');
            var firstItem = (item_height.eq(0).height());
            var twoItem = (item_height.eq(1).height());
            console.log(firstItem);
            console.log();
            $('.tab_style1 .bottom_part').height(twoItem > firstItem ? twoItem : firstItem);
        });
        ///////////////////////////////////////////
        //share style1
        $(document.body).on('click', '.share_style1_btn .link', function() {
            $('.share_style1').fadeToggle(250);
        });

        $('body').click(function(e) {
            if (!$(e.target).is('.share_style1_btn , .share_style1') && !$(e.target).is('.share_style1_btn * , .share_style1 *')) {
                $('.share_style1').fadeOut(200);
            }
        }); //body click

    }); //document ready

    getShortLink('show-tooltip');

    $(document).on('click', '#show-tooltip-li', function() {
        $('#show-short-link').toggle(300);
        setTimeout(function() {
            var copyText = document.getElementById('show-tooltip');
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand('copy');
            swal({
                title: 'لینک برای شما کپی شد',
                text: '',
                icon: 'success',
                buttons: {
                    confirm: 'متوجه شدم'
                }
            });
        }, 500);

    });

    //product mobile gallery
    // var slide3 = $(".product-gallery-mobile")
    // slide3.on('init', function() {
    //     $(this).removeClass('hide');
    // });

    // // slide3.on('lazyLoaded', function(event, slick, direction) {
    // //     console.log('edge was hit')
    // // });

    // slide3.slick({
    //     //            centerPadding: '250px',
    //     dots: true,
    //     // arrows: false,
    //     prevArrow: "<div class='arrow_style-main slick-prev arrow'><i class='z_index2 i-next'></i></div>",
    //     nextArrow: "<div class='arrow_style-main slick-next'><i class='z_index2 i-back'></i></div>",
    //     slidesToShow: 1,
    //     speed: 400,
    //     rtl: true,
    //     adaptiveHeight: true,

    // });

    $('.product-gallery-mobile .slick-dots li button').html("");
</script>

@endsection