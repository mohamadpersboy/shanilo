<div class="personal_detail_style1">
    <div class="user_navigation box_shadow_style1">
        <a class="responsive_menu_btn">منوی فروشگاه</a>
        <a class="responsive_search_btn">جستجو در فروشگاه</a>
        <div class="list_menu">
            <ul class="step no_bullet flex">
                <li class="item {{$activeMenu=='index'?'active':''}}"><a href="{{$shop->path()}}" title="" class="link">فروشگاه</a></li>
                <li class="item {{$activeMenu=='products'?'active':''}}"><a href="{{$shop->path('products')}}" title="" class="link">لیست محصولات</a></li>
                <li class="item {{$activeMenu=='specialSuggestions'?'active':''}}"><a href="{{$shop->path('specialSuggestions')}}" title="" class="link">پیشنهاد ویژه</a>
                </li>
                <li class="item {{$activeMenu=='specialSells'?'active':''}}"><a href="{{$shop->path('specialSells')}}" title="" class="link">فروش ویژه</a>
                </li>
                <li class="item {{$activeMenu=='clients'?'active':''}}"><a href="{{$shop->path('clients')}}" title="" class="link">لیست مشتریان</a></li>
                <li class="item {{$activeMenu=='articles'?'active':''}}"><a href="{{$shop->path('articles')}}" title="" class="link">مجلات</a></li>
                <li class="item {{$activeMenu=='about'?'active':''}}"><a href="{{$shop->path('about')}}" title="" class="link">درباره فروشگاه</a></li>
                <li class="item  search_item">
                    <div class="link"><i class="i-search"></i> جستجو</div>
                </li>
            </ul>
        </div><!-- list_menu -->
        <div class="sub_search">
            <div class="search_style1">
                <form action="{{$shop->path('products')}}" class="flex">
                    <input type="text" name="search" placeholder="جستجو کنید...">
                    <button><i class="i-search"></i>جستجو کنید</button>
                </form>
            </div>
        </div>
    </div>
    <a href="{{$shop->takeImage('background','1200/500')}}" class="fancybox user_background" style="background-image: url('{{$shop->takeImage('background','1200/500')}}');"></a>
    @if(canEditShop($shop))
    <div class="change_pic_btn flex">
        <div class="text"><span>تغییر دادن عکس</span></div>
        <div class="icon"><i class="i-047-camera"></i></div>
    </div>
    @endif
    <div class="user_part1 flex">
        <div class="right_part user_pic {{canEditShop($shop)?'change_pic_profile_btn':''}}" style="background-image: url('{{$shop->takeImage('avatar','172/172','shop-thumbnail.jpg')}}');"></div>
        <div class="left_part flex">
            <div class="user_follow flex">
                @auth
                <div class="btn_style5 have_sub flex">
                    <span class="icon"><i class="i-widget"></i></span>
                    <div class="sub_style2">
                        <ul class="step2 no_bullet">
                            @if(canEditShop($shop))
                            <li class="item2">
                                <a href="{{route('front.profile.shop.edit',$shop)}}" class="link2">ویرایش
                                    فروشگاه</a>
                            </li>
                            @else
                            <li class="item2">
                                @if($shop->isReportedByAuth())
                                <a href="javascript:void(0)" class="link2 reported">
                                    <span>گزارش شد</span>
                                </a>
                                @else
                                <a href="javascript:void(0)" data-url="{{route('front.report.create',['shop',$shop->id])}}" class="link2 btn-create-report modal_btn">
                                    <span>گزارش</span>
                                </a>
                                @endif
                            </li>
                            <li class="item2">
                                <a href="javascript:void(0)" data-url="{{route('front.notifylist.toggle',['shop',$shop->id])}}" class="link2 btn-notify-list {{auth()->user()->hasItInNotifyLists($shop)?'active':''}}">
                                    <span class="text">{{auth()->user()->hasItInNotifyLists($shop)?'موجود در اطلاع رسانی':'اطلاع رسانی'}}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endauth
                @if(canFollowOrBlock($shop))
                @if(inFollowingList($shop))
                <a href="javascript:void(0)" data-url="{{route('front.shop-page.toggleFollow',$shop)}}" title="" class="btn_style5 btn-follow red flex">
                    <span class="text">unfollow</span>
                </a>
                @else
                <a href="javascript:void(0)" data-url="{{route('front.shop-page.toggleFollow',$shop)}}" title="" class="btn_style5 btn-follow green flex">
                    <span class="text">follow</span>
                </a>
                @endif
                <a href="#" title="ارسال پیام" data-url="{{route('front.message.create',['shop',$shop->id])}}" class="btn_style5 orange modal_btn flex btn-send-message">
                    <span class="icon" style="margin-left: 10px;"><i class="i-chat"></i></span>
                    <span class="text">ارسال پیام</span>
                </a>
                @endif

            </div>
            <div class="user_name flex checked">
                <!-- add " checked " class -->
                <div class="name">{{$shop->title}}</div><!-- maximo lenght = 36 -->
                <a href="{{$shop->path()}}" title="" class="id">{{ $shop->username }}</a>
            </div>
        </div>
    </div>
    <div class="socials-main user_part2 flex">
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

            <ul class="socials-main__items flex">
                <li class="item box_shadow_style1">
                    <div class="link show_more_btn modal_btn btn-comments flex" data-url="{{route('front.comment.index',['shop',$shop->id])}}">
                        <span class="title">امتیاز فروشگاه</span>
                        <span class="count">
                            <div class="rate_style1 pointer_event">
                                @include('front.partial.items.rate',['rate'=>$shop->rate])
                            </div>
                        </span>
                    </div>
                </li>
                <li class="item box_shadow_style1">
                    <div class="link flex follower_btn modal_btn" data-url="{{route('front.shop-page.getFollowers',$shop)}}">
                        <span class="title">followers</span>
                        <span class="count">{{calculateFollowersCount($shop->followers->count())}}</span>
                    </div>
                </li>
                <li class="item box_shadow_style1">
                    <a href="{{$shop->path('clients')}}" class="link flex">
                        <span class="title">مشتریان</span>
                        <span class="count">{{$shop->customers->count()}}</span>
                    </a>
                </li>
                <li class="item box_shadow_style1">
                    <a href="{{$shop->path('products')}}" class="link flex">
                        <span class="title"> محصولات</span>
                        <span class="count">{{$shop->products->count()}}</span>
                    </a>
                </li>
                <li class="item box_shadow_style1">
                    <a href="{{$shop->path('articles')}}" class="link flex">
                        <span class="title">مجلات</span>
                        <span class="count">{{$shop->articles_count}}</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <div class="user_part3 have_map">
        <!-- this section has class "have_map" for map -->
        <a href="{{$shop->user->path()}}" class="maker_style1 flex">
            <div class="user_pic" style="background-image: url('{{$shop->user->takeImage('avatar','172/172','user.png')}}');"></div>
            <div class="user_name ellipsis">{{getUsersFullName($shop->user)}}</div>
        </a>
        <div class="title_style4">اطلاعات تماس</div>
        <ul class="step no_bullet">
            <li class="item flex">
                <div class="icon"><i class="i-phone-reciever"></i></div>
                <div id="field-phone" class="content">{{$shop->phone}}</div>
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
                        'data-field'=>'#field-phone',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$shop->id) !!}
                        {!! Form::hidden('_sid',bcrypt($shop->id)) !!}
                        {!! Form::hidden('field','phone') !!}
                        <input class="form_type" type="text" placeholder="" name="value">
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
            <li class="item flex">
                <div class="icon"><i class="i-019-placeholder"></i></div>
                <div id="field-address" class="content">{{$shop->address}}</div>
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
                        'data-field'=>'#field-address',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$shop->id) !!}
                        {!! Form::hidden('_sid',bcrypt($shop->id)) !!}
                        {!! Form::hidden('field','address') !!}
                        <textarea class="form_type" name="value"></textarea>
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
            <li class="item flex">
                <div class="icon"><i class="i-019-placeholder"></i></div>
                <div class="content"> ارسال به
                    {{$shop->cityList}}
                </div>
                @if(canEditShop($shop))
                <div class="edit_part edit_form_style1 flex">
                    <a href="{{route('front.profile.shop.edit',$shop)}}">
                        <div class="edit_icon"><i class="i-pencil"></i></div>
                    </a>
                </div>
                @endif
            </li>
            <li class="item flex">
                <div class="icon"><i class="i-027-clock"></i></div>
                <div id="field-work_time" class="content">{{$shop->work_time}}</div>
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
                        'data-field'=>'#field-work_time',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$shop->id) !!}
                        {!! Form::hidden('_sid',bcrypt($shop->id)) !!}
                        {!! Form::hidden('field','work_time') !!}
                        <input class="form_type" type="text" placeholder="" name="value">
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
            <li class="item flex">
                <div class="icon"><i class="i-017-mail"></i></div>
                <div id="field-email" class="content">{{$shop->email}}</div>
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
                        'data-field'=>'#field-email',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$shop->id) !!}
                        {!! Form::hidden('_sid',bcrypt($shop->id)) !!}
                        {!! Form::hidden('field','email') !!}
                        <input class="form_type" type="text" placeholder="" name="value">
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
        </ul>
        {{--<div class="market_map map_modal_btn modal_btn">
            <div id="map" class="google-map" data-lat="35.763490110196116" data-long="51.32009738715817"></div>
        </div>--}}
    </div>
</div><!-- .personal_detail_style1 -->


<script>
    $(document).ready(function() {
        /////////////////////////////
        //responsive menu
        $(".user_navigation .responsive_menu_btn").click(function(e) {
            $(this).toggleClass("active");
            $(".user_navigation .list_menu").toggleClass("active");
            $(".user_navigation .sub_search, .user_navigation .responsive_search_btn").removeClass("active");
            e.stopPropagation();
        });
        $(".user_navigation .responsive_search_btn").click(function(e) {
            $(this).toggleClass("active");
            $(".user_navigation .sub_search").toggleClass("active");
            $(".user_navigation .list_menu, .user_navigation .responsive_menu_btn").removeClass("active");
            e.stopPropagation();
        });
        $("body").click(function() {
            $(".user_navigation .list_menu, .user_navigation .responsive_menu_btn").removeClass("active");
            $(".user_navigation .sub_search, .user_navigation .responsive_search_btn").removeClass("active");
        });
        $(".user_navigation .list_menu,.user_navigation .sub_search").click(function(e) {
            e.stopPropagation();
        });

        /////////////////////////////
        //show contact info
        $('.personal_detail_style1 .user_part3 .title_style4').click(function() {
            var t4 = $(this);
            t4.siblings('.step').siblings('.modal_btn').css('opacity', '1');
            if (t4.hasClass('active')) {
                t4.removeClass('active');
                t4.siblings('.step').stop(true, false).slideUp(200);
                t4.siblings('.step').siblings('.modal_btn').fadeOut(200);
            } else {
                t4.addClass('active');
                t4.siblings('.step').stop(true, false).slideDown(200);
                t4.siblings('.step').siblings('.modal_btn').fadeIn(200);
            }
        });

        /////////////////////////////////
        //open edit form
        $('.edit_form_style1 .edit_icon').click(function() {
            var sww = $(this).parent('.edit_form_style1').siblings('.content').text();
            $('.edit_form_style1 .edit_form').fadeOut(200);
            $(this).siblings('.edit_form').fadeIn(300);
            $(this).siblings('.edit_form').find('.form_type').val(sww);
            $(this).siblings('.edit_form').find('form > [name="value"]').trigger('focus');
        });
        /*$("body").click(function (e) {
            if (!$(e.target).is(".edit_form_style1") && !$(e.target).is(".edit_form_style1 *")) {
                $('.edit_form_style1 .edit_form').fadeOut(200);
            }
        });//body click*/
        $('[name="value"]').on('blur', function(e) {
            e.stopPropagation();
            $(this).closest('form').submit();
        });
        /////////////////////////////////
        //add active class
        $('.personal_detail_style1 .user_part2').addClass('active');
        /////////////////////////////
        //sub2
        $('.have_sub').click(function() {
            var sub = $(this).find('.sub_style2');
            var sub_display = $(this).find('.sub_style2').css('display');

            if (sub_display == 'none') {
                sub.fadeIn(300);
                $(this).addClass('active');
            } else {
                sub.fadeOut(300);
            }

        });
        $("body").click(function(e) {
            if (!$(e.target).is(".have_sub") && !$(e.target).is(".have_sub *")) {
                $('.sub_style2').fadeOut(300);
            }
        }); //body click
        /////////////////////////////////
        // map
        mapStyles = [{
            "featureType": "administrative.locality",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "visibility": "on"
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#bbd7c0"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#e8bdaf"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#c2795a"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#ffffff"
            }]
        }, {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry.stroke",
            "stylers": [{
                "visibility": "on"
            }]
        }, {
            "featureType": "road.local",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#ac98a1"
            }]
        }];
        image = '_images/icon/location.png';

        maps = [], markers = [];
        $.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyDZaZOS9IPKn3EhAlGWW0O7Hf43FKaH4Yw", function() {
            var maps = $('.google-map');
            $.each(maps, function() {
                var $this = this,
                    latLng = {
                        lat: parseFloat($($this).data('lat')),
                        lng: parseFloat($($this).data('long'))
                    };
                var map = new google.maps.Map($this, {
                    zoom: 14,
                    center: latLng,
                    styles: mapStyles
                });
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: image,
                });
                maps.push(map);
                markers.push(marker);
            });
        });

        /////////////////////////////////
        //open product search (just for market)
        $('.personal_detail_style1 .user_navigation .item.search_item').click(function() {
            $('.personal_detail_style1 .user_navigation .search_style1').fadeIn(200);
        });
        $("body").click(function(e) {
            if (!$(e.target).is(".personal_detail_style1 .user_navigation") && !$(e.target).is(".personal_detail_style1 .user_navigation *")) {
                $('.personal_detail_style1 .user_navigation .search_style1').fadeOut(200);
            }
        }); //body click


    }); //document ready
</script>
