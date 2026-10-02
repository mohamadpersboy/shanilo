<div class="personal_detail_style1">
    <div class="user_navigation box_shadow_style1">
        <a class="responsive_menu_btn">منوی کاربر</a>
        <div class="list_menu">
            <ul class="step no_bullet flex">
                <li class="item {{$activeMenu=="index"?'active':''}}"><a href="{{$user->path()}}" title="" class="link">صفحه
                        اصلی</a></li>
                <li class="item {{$activeMenu=="suggestions"?'active':''}}"><a href="{{$user->path('suggestions')}}" title="" class="link">پیشنهاد من</a></li>

                <li class="item {{$activeMenu=="favorites"?'active':''}}"><a @if(CanEditUser($user)) href="{{$user->path('favorites')}}" @endif title="" class="link">علاقه مندی های من</a></li>

                <li class="item {{$activeMenu=="shops"?'active':''}}"><a href="{{$user->path('shops')}}" title="" class="link">فروشگاه های من</a></li>
                <li class="item {{$activeMenu=="articles"?'active':''}}"><a href="{{$user->path('articles')}}" title="" class="link">مجلات من</a></li>
                <li class="item {{$activeMenu=="about"?'active':''}}"><a href="{{$user->path('about')}}" title="" class="link">درباره من</a></li>
            </ul>
        </div><!-- list_menu -->
    </div>
    <a href="{{$user->takeImage('background','1200/500','user_page_defult_pic.jpg')}}" class="fancybox user_background" style="background-image: url('{{$user->takeImage('background','1200/500','user_page_defult_pic.jpg')}}');"></a>
    @if(canEditUser($user))
    <div class="change_pic_btn flex">
        <div class="text"><span>تغییر دادن عکس</span></div>
        <div class="icon"><i class="i-047-camera"></i></div>
    </div>
    @endif
    <div class="user_part1 flex">
        <div class="right_part user_pic {{canEditUser($user)?'change_pic_profile_btn':''}}" style="background-image: url('{{$user->takeImage('avatar','172/172','user.png')}}');"></div>
        <div class="left_part flex">
            <div class="user_follow flex">
                @auth
                @if(canEditUser($user))
                <div class="btn_style5 have_sub flex">
                    <span class="icon"><i class="i-widget"></i></span>
                    <div class="sub_style2">
                        <ul class="step2 no_bullet">

                            <li class="item2"><a href="{{route('front.profile.index')}}" class="link2">ویرایش
                                    اطلاعات</a></li>
                            <li class="item2"><a href="{{route('front.profile.product.create')}}" class="link2">افزودن
                                    محصول</a></li>
                            <li class="item2"><a href="{{route('front.profile.shop.create')}}" class="link2">افزودن
                                    فروشگاه</a></li>
                            <li class="item2"><a href="{{route('front.profile.article.create')}}" class="link2">افزودن
                                    مجله</a></li>
                            <li class="item2"><a href="{{route('front.profile.password.index')}}" class="link2">تغییر
                                    رمز عبور</a></li>
                            {{-- @else
                                         <li class="item2"><a href="user-information.php" class="link2">فعال کردن هشدار</a></li>
                                         <li class="item2 report_btn modal_btn"><a title="" class="link2">گزارش</a></li>--}}
                        </ul>
                    </div>
                </div>
                @endif
                @endauth
                @if(canFollowOrBlock($user))
                @if(inFollowingList($user))
                <a data-url="{{route('front.user-page.toggleFollow',$user)}}" href="javascript:void(0)" title="" class="btn_style5 red flex btn-follow">
                    <span class="text">unfollow</span>
                </a>
                @else
                <a data-url="{{route('front.user-page.toggleFollow',$user)}}" href="javascript:void(0)" title="" class="btn_style5 green flex btn-follow">
                    <span class="text">follow</span>
                </a>
                @endif
                @if(inBlockList($user))
                <a data-url="{{route('front.user-page.toggleBlock',$user)}}" href="javascript:void(0)" title="" class="btn_style5 btn-block green flex">
                    <span class="text">unblock</span>
                </a>
                @else
                <a data-url="{{route('front.user-page.toggleBlock',$user)}}" href="javascript:void(0)" title="" class="btn_style5 btn-block red flex">
                    <span class="text">block</span>
                </a>
                @endif
                @if(!inBlockList(auth()->user(),$user))
                <a href="javascript:void(0)" title="ارسال پیام" data-url="{{route('front.message.create',['user',$user->id])}}" class="btn_style5 modal_btn orange btn-send-message flex">
                    <span class="icon" style="margin-left: 10px;"><i class="i-chat"></i></span>
                    <span class="text">ارسال پیام</span>
                </a>
                @endif
                @endif
            </div>
            <div class="user_name flex {{$user->confirmed_by_admin?'checked':''}}">
                <!-- add " checked " class -->
                <div class="name">{{getUsersFullName($user)}}</div>
                <a href="{{$user->path()}}" title="" class="id">{{$user->username}}</a>
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
            <ul class="socials-main__items flex socials-main__items_user">
                <li class="item box_shadow_style1">
                    <div data-url="{{route('front.user-page.getFollowers',$user)}}" class="link flex follower_btn modal_btn">
                        <span class="title">followers</span>
                        <span class="count">{{calculateFollowersCount($user->followers->count())}}</span>
                    </div>
                </li>
                <li class="item box_shadow_style1">
                    <div data-url="{{route('front.user-page.getFollowings',$user)}}" class="link flex following_btn modal_btn">
                        <span class="title">following</span>
                        <span class="count">{{$user->following->filter(function ($following){
                        return !!$following->followable;
                    })->count()}}</span>
                    </div>
                </li>
                <li class="item box_shadow_style1">
                    <a href="{{$user->path('personal')}}" class="link flex">
                        <span class="title"> محصولات</span>
                        <span class="count">{{$user->products->count()}}</span>
                    </a>
                </li>
                <li class="item box_shadow_style1">
                    <a href="{{$user->path('shops')}}" class="link flex">
                        <span class="title">فروشگاه ها</span>
                        <span class="count">{{$user->shops_count}}</span>
                    </a>
                </li>

                <li class="item box_shadow_style1">
                    <a @if(canEditUser($user)) href="{{$user->path('favorites')}}" @endif class="link flex">
                        <span class="title">علاقه مندی</span>
                        <span class="count">{{$user->favoriteProducts()->count()}}</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="user_part3">
        <div class="title_style4">اطلاعات تماس</div>
        <ul class="step no_bullet">
            @if(canEditUser($user) || $user->show_info)
            <li class="item flex">
                <div class="icon"><i class="i-phone-reciever"></i></div>
                <div id="field-mobile" class="content">{{$user->mobile}}</div>
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
                        'data-field'=>'#field-mobile',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$user->id) !!}
                        {!! Form::hidden('_sid',bcrypt($user->id)) !!}
                        {!! Form::hidden('field','mobile') !!}
                        <input class="form_type" type="text" placeholder="" name="value">
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
            @endif
            <li class="item flex">
                <div class="icon"><i class="i-019-placeholder"></i></div>
                <div id="field-address" class="content">{{$user->address}}</div>
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
                        'data-field'=>'#field-address',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$user->id) !!}
                        {!! Form::hidden('_sid',bcrypt($user->id)) !!}
                        {!! Form::hidden('field','address') !!}
                        <textarea class="form_type" name="value"></textarea>
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
            @if(canEditUser($user) || $user->show_info)
            <li class="item flex">
                <div class="icon"><i class="i-017-mail"></i></div>
                <div id="field-email" class="content">{{$user->email}}</div>
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
                        'data-field'=>'#field-email',
                        'data-type-json',
                        'class'=>'flex'
                        ]) !!}
                        {!! Form::hidden('id',$user->id) !!}
                        {!! Form::hidden('_sid',bcrypt($user->id)) !!}
                        {!! Form::hidden('field','email') !!}
                        <input class="form_type" type="text" placeholder="" name="value">
                        <button><i class="i-check-square-o"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                @endif
            </li>
            @endif
        </ul>
    </div>
</div><!-- .personal_detail_style1 -->


<script>
    $(document).ready(function() {
        /////////////////////////////
        //responsive menu
        $(".user_navigation .responsive_menu_btn").click(function(e) {
            $(this).toggleClass("active");
            $(".user_navigation .list_menu").toggleClass("active");
            e.stopPropagation();
        });
        $("body").click(function() {
            $(".user_navigation .list_menu, .user_navigation .responsive_menu_btn").removeClass("active");
        });
        $(".user_navigation .list_menu").click(function(e) {
            e.stopPropagation();
        });

        /////////////////////////////
        //show contact info
        $('.personal_detail_style1 .user_part3 .title_style4').click(function() {
            var t4 = $(this);
            if (t4.hasClass('active')) {
                t4.removeClass('active');
                t4.siblings('.step').stop(true, false).slideUp(200);
            } else {
                t4.addClass('active');
                t4.siblings('.step').stop(true, false).slideDown(200);
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

    }); //document ready
</script>
