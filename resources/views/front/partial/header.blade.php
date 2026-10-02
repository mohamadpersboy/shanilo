<div class="header_part1 flex">
    <div class="search_btn flex">
        <div class="link flex">
            <span class="text">جستجو</span>
            <span class="icon"><i class="i-search"></i></span>
        </div>
    </div>
    <div class="right_part header_btn flex">
        <a href="{{route('front.home.index')}}" title="" class="logo"><img src="_images/logo/logo1.png" alt=""></a>
        <ul class="step no_bullet flex">
            @if(Auth::check())
                <li class="item">
                    <a href="{{route('front.timeline.index')}}" class="link flex">
                        <span class="icon"><i class="i-shop"></i></span>
                    </a>
                </li>
                <li class="item have_sub user_item" style="">
                    <div class="link flex">
                        <span class="icon"><span class="user_pic"
                                                 style="background-image: url('{{Auth::user()->takeImage('avatar','60/60','user.png')}}');"></span></span>
                        <span class="text"><span class="user_name ellipsis">پروفایل کاربری</span></span>
                    </div>
                    <div class="sub_style1 sub_menu">
                        <div class="wrapper">
                            <a href="{{Auth::user()->path()}}" class="title_style1 flex">{{getUsersFullName(Auth::user())}}</a>
                            <div class="user_sub">
                                <ul class="step2 no_bullet flex">
                                    <li class="item2">
                                        <a href="{{route('front.profile.order.index','self')}}" class="link2">پنل کاربری</a>
                                    </li>
                                    <li class="item2 new">
                                        <a href="{{route('front.profile.message.index')}}" class="link2">پیام های من</a>
                                    </li>
                                    <li class="item2"><a href="{{route('front.profile.shop.index')}}" class="link2">فروشگاه های من</a></li>
                                    <li class="item2"><a href="{{route('front.profile.wallet.index')}}" class="link2">کیف پول های من</a></li>
                                </ul>
                                <a href="javascript:void(0)" title="" class="logout_btn btn-logout">خروج از حساب کاربری</a>
                            </div>
                        </div>
                    </div>
                </li>
            @else
                <li class="item have_sub sign_in_btn">
                    <div class="link flex">
                        <span class="icon"><i class="i-030-user"></i></span>
                        <span class="text">ورود</span>
                    </div>
                    <div class="sub_style1 sub_menu">
                        <div class="wrapper">
                            <div class="title_style1">ورود به پنل کاربری</div>
                            <div class="form_style1">
                                {!! Form::open([
                                    'url'=>route('front.auth.login'),
                                    'data-ajax',
                                    'data-type'=>'json',
                                    'data-on-success'=>'redirect',
                                    'data-on-error'=>'inline-message',
                                    'data-clear'=>'true'
                                ]) !!}
                                <ul class="frm_step no_bullet">
                                    <li class="frm_item w100 flex">
                                        <input class="frm_input" name="mobile" type="text">
                                        <div class="frm_title">شماره موبایل</div>
                                    </li>
                                    <li class="frm_item w100 flex">
                                        <input class="frm_input" name="password" type="password">
                                        <div class="frm_title">رمز عبور</div>
                                    </li>
                                    <li class="frm_item w100">
                                        <a href="{{route('front.auth.password.request')}}" title="" class="frm_text">فراموشی
                                            رمز عبور</a>
                                    </li>
                                    <li class="frm_item w100 flex">
                                        <button class="frm_submit">ورود</button>
                                    </li>
                                </ul>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </li>
                <li class="item">
                    <a href="{{route('front.auth.register.show')}}" class="link flex">
                        <span class="icon"><i class="i-login"></i></span>
                        <span class="text">عضویت</span>
                    </a>
                </li>
            @endif
            <li class="item">
                <a href="{{route('front.product.index')}}" title="آرشیو محصولات" class="link flex">
                    <span class="icon"><i class="i-012-list"></i></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="left_part header_btn">
        <ul class="step no_bullet flex">
            @auth
                <li class="item have_sub user_message">
                    <div class="link flex">
                        <span class="text">اعلان ها</span>
                        <span class="icon"><i class="i-010-bell"></i></span>
                        @php
                            $announcementsCount=auth()->user()->announcements()->count()
                        @endphp
                        <span id="announcements-count" class="count {{$announcementsCount?'':'hide'}}">{{$announcementsCount}}</span>
                    </div>
                    <div class="sub_style1 sub_menu">
                        <div class="wrapper">
                            @if($announcementsCount)
                                <div class="box_style6">
                                    <div class="have_scroll_y scroll_style1">
                                        <ul class="step2 no_bullet">
                                            @foreach(auth()->user()->announcements as $index=>$announcement)
                                                <li class="item2 flex" style="text-align: justify;"><br>
                                                    {!! $announcement->message !!}
                                                    <div class="dlt_btn btn-seen-announcement"
                                                         data-url="{{route('front.announcement.seen',$announcement)}}">
                                                        <i class="i-cancel"></i></div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div><!-- .box_style6 -->
                            @else
                                <div class="noItem_style1 type2">
                                    <span>در حاضر هیچ اعلانی یافت نشد!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @endauth
            <li class="item have_sub cart">
                <div class="link flex">
                    <span class="text">سبد خرید</span>
                    <span class="icon"><i class="i-009-shopping-cart"></i></span>
                    @php
                    $cartCount=Cart::count();
                    @endphp
                    <span id="cart-count" class="count {{$cartCount?'':'hide'}}">{{$cartCount}}</span>
                </div>
                <div class="sub_style1 sub_menu">
                    <div id="cart-container" class="wrapper">
                        @include('front.partial.parts.cart')
                    </div>
                </div>
            </li>
            <li class="item have_sub fav">
                <div class="link flex">
                    <span class="text">علاقه مندی ها</span>
                    <span class="icon"><i class="i-048-bookmark"></i></span>
                    <span id="favorite-count" class="count {{Favorite::count()?'':'hide'}}">{{Favorite::count()}}</span>
                </div>
                <div class="sub_style1 sub_menu">
                    <div id="favorite-container" class="wrapper">
                        @include('front.partial.ajax.favorites-list')
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="header_responsive_search"><i class="i-search"></i></div>
    <div class="header_responsive_btn"><i class="i-exclamation"></i></div>
</div>
