<div class='dashboard'>
    <ul class='step no_bullet'>
        <li class='item top_part clearfix'>
            <div class='right_part'>
                <div class='logout'>
                    <span class='icon'><i class='i-print'></i></span>
                    <span class='text btn-logout'>خروج</span>
                </div>
                <div class='user_pic change_pic_profile_btn modal_btn' style="background-image: url('{{Auth::user()->takeImage('avatar','60/60','user.png')}}');"></div>
                <div class='user_name ellipsis'>{{getUsersFullName(Auth::user())}}</div>
                <div class='user_cash'>موجودی : <span class="price">{{showPrice(Auth::user()->credit,0,'')}}</span></div>
            </div><!--close .right_part-->
            <div class='left_part'>
                <ul class='step2 no_bullet clearfix'>
                    <li class='item2 btn'>
                        <a href="{{$user->path()}}" target="_blank" title="" class="link2 flex">
                            <span class="icon"><i class="i-020-arrow"></i></span>
                            <span class="text">مشاهده صفحه شخصی</span>
                        </a>
                    </li>
                    <li class='item2 btn'>
                        <a href="{{route('front.profile.product.create')}}" title="" class="link2 flex">
                            <span class="icon"><i class="i-049-add"></i></span>
                            <span class="text">افزودن محصول جدید</span>
                        </a>
                    </li>
                    <li class='item2 btn'>
                        <a href="{{route('front.profile.shop.create')}}" title="" class="link2 flex">
                            <span class="icon"><i class="i-021-home"></i></span>
                            <span class="text">افزودن فروشگاه جدید</span>
                        </a>
                    </li>
                    <li class='item2 btn'>
                        <a href="{{route('front.profile.article.create')}}" title="" class="link2 flex">
                            <span class="icon"><i class="i-003-color"></i></span>
                            <span class="text">افزودن مجله جدید</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li><!--clsoe .item-->
        <li class='item bottom_part'>
            <div class='panel_menu_btn'><i style="font-size: 15px;" class="i-list"></i> فهرست کاربری</div>
            <ul class='step2 no_bullet clearfix'>
                <li class='item2 {{$activeMenu=='orders'?'active':''}}'><a href='{{route('front.profile.order.index','self')}}' class='link2'>  سفارشات من</a></li>
                <li class='item2 {{$activeMenu=='products'?'active':''}}'><a href='{{route('front.profile.product.index')}}' class='link2'>محصولات من</a></li>
                <li class='item2 {{$activeMenu=='articles'?'active':''}}'><a href='{{route('front.profile.article.index')}}' class='link2'>مجلات من</a></li>
                <li class='item2 {{$activeMenu=='shops'?'active':''}}'><a href='{{route('front.profile.shop.index')}}' class='link2'>فروشگاه های من</a></li>
                <li class='item2 {{$activeMenu=='messages'?'active':''}} {{$newMessages?'new':''}}'><a href='{{route('front.profile.message.index')}}' class='link2'>پیام های من</a></li>
                <li class='item2 {{$activeMenu=='wallets'?'active':''}}'><a href='{{route('front.profile.wallet.index')}}' class='link2'>اطلاعات حساب و موجودی</a></li>
                <li class='item2 {{$activeMenu=='addresses'?'active':''}}'><a href='{{route('front.profile.address.index')}}' class='link2'>اطلاعات پستی</a></li>
                <li class='item2 {{$activeMenu=='index'?'active':''}}'><a href='{{route('front.profile.index')}}' class='link2 active'>ویرایش اطلاعات</a></li>
                <li class='item2 {{$activeMenu=='changepass'?'active':''}}'><a href='{{route('front.profile.password.index')}}' class='link2'>تغییر رمز عبور</a></li>
            </ul>
        </li><!--clsoe .item-->
    </ul><!--clsoe .step-->
</div><!--clsoe .dashboard-->
@include('front.partial.panel-responsive-menu')
