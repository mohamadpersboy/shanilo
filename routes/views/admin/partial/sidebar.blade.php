<aside class="sidebar_style1">
    <div class="sidebar_part1">
        <div class="usermenu_wrapper">
            <a href="#" class="usermenu_part1 clearfix">
                <!--<span class='pic_style1' style='background-image:url(_images/pic_profile.jpg);'></span>-->
                <span class="logo" style="background-image:url({{asset('assets/front/_images/logo/logo_for_admin.png')}});"></span>
                <div class="name_profile">
                    <p class="name_profile1">{{Auth::guard('admins')->user()->name}} {{Auth::guard('admins')->user()->family}}</p>
                    <p class="name_profile2">{{Auth::guard('admins')->user()->email}}</p>
                    <i class="i-angle-down icon_arrow"></i>
                </div>
            </a>
            <div class="usermenu_part2">
                <ul class="list">
                    <li class="item"><a href="{{route('admin.home.index')}}" class="link">{{__('content.my_profile')}}</a></li>
                    @role('atlas-administrator|administrator')
                        <li class="item"><a href="{{route('admin.admin.create')}}" class="link">{{__('content.create_admin')}}</a></li>
                        <li class="item"><a href="{{route('admin.admin.index')}}" class="link">{{__('content.management_admins')}}</a></li>
                        <li class="item"><a href="{{route('admin.role.index')}}" class="link">{{__('content.management_roles')}}</a></li>
                    @endrole
                    <li class="item logout"><a href="{{route('admin.auth.logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="link"><i class="icon i-power-2"></i>{{__('content.logout')}}</a></li>
                    <form id="logout-form" action="{{route('admin.auth.logout')}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </div><!--usermenu-->
        </div><!--usermenu_wrapper-->
    </div><!--sidebar_part1-->

    <div class="sidebar_part2">
        <ul class="step1 clearfix">
            <li class="item tab1 index @yield('admin.all')" title="{{__('content.list_pages')}}" data-tabno="1" style="width: 25%;"><i class="i-dot-3"></i></li>
            @permission('view.contact || view.ticket || view.chat')
                <li class="item tab2 mail @yield('admin.message')" title="پیام های سایت" data-tabno="2" style="width: 25%;"><i class="i-letter-mail-1"></i>@if($data_header['contacts']->count() || $data_header['tickets']->count())<i class="notif" style="display: inline-block;"></i>@endif</li>
            @endpermission
            @permission('view.user')
                <li class="item tab3 user @yield('admin.user')" title="کاربران سایت" data-tabno="3" style="width: 25%;"><i class="i-person"></i></li>
            @endpermission
            <li class="item tab4 search" title="{{__('content.search_in_pages')}}" data-tabno="4" style="width: 25%;"><i class="i-search"></i></li>
        </ul>
    </div><!--sidebar_part2-->

    <div class="sidebar_part3">
        <div class="tab_content tab_content1  @yield('admin.all')">
            <div class="list_style1">
                @role('atlas-administrator')
                    <p class="tab_title">{{__('content.access_management')}}</p>
                    <ul class="step1">
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">{{__('content.access_level_management')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                <li class="item item2 @yield('admin.role.index')"><a href="{{route('admin.role.index')}}" class="link link2">{{__('content.management_roles')}}</a></li>
                                <li class="item item2 @yield('admin.role.create')"><a href="{{route('admin.role.create')}}" class="link link2">{{__('content.create_role')}}</a></li>

                                <li class="item item2 @yield('admin.permission.index')"><a href="{{route('admin.permission.index')}}" class="link link2">{{__('content.management_permissions')}}</a></li>
                                <li class="item item2 @yield('admin.permission.create')"><a href="{{route('admin.permission.create')}}" class="link link2">{{__('content.create_permission')}}</a></li>
                            </ul>
                        </li>
                    </ul>
                @endrole

                <div data-section>
                    <p class="tab_title dis_none" data-section-p>{{__('content.site_main_managements')}}</p>
                    <ul class="step1" data-section-ul>
                      
                        @permission('view.brand')
                        <li class="item item1 @yield('admin.brand.index')">
                            <a href="{{route('admin.brand.index')}}" target="" class="link link1">مدیریت برند ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission

                        @permission('view.category|create.category|view.category2|create.category2')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">دسته بندی ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.category')
                                <li class="item item2 @yield('admin.category.index')"><a href="{{route('admin.category.index')}}" class="link link2">دسته بندی - گروه اصلی</a></li>
                                @endpermission
                                @permission('view.category2')
                                <li class="item item2 @yield('admin.category2.index')"><a href="{{route('admin.category2.index')}}" class="link link2">دسته بندی محصولات - زیر گروه ها</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.tag|view.tag2')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">تگ محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.tag')
                                <li class="item item2 @yield('admin.tag.index')"><a href="{{route('admin.tag.index')}}" class="link link2">تگ محصولات - گروه اصلی</a></li>
                                @endpermission
                                @permission('view.tag2')
                                <li class="item item2 @yield('admin.tag2.index')"><a href="{{route('admin.tag2.index')}}" class="link link2">تگ محصولات - زیر گروه ها</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.videogallery|create.videogallery')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">گالری ویدئو
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.videogallery')
                                <li class="item item2 @yield('admin.videogallery.index')"><a href="{{route('admin.videogallery.index')}}" class="link link2">{{__('content.list_of_videogallery')}}</a></li>
                                @endpermission
                                @permission('create.videogallery')
                                <li class="item item2 @yield('admin.videogallery.create')"><a href="{{route('admin.videogallery.create')}}" class="link link2">{{__('content.create_videogallery')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.picturegallery|create.picturegallery')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">{{__('picture-gallery')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.picturegallery')
                                <li class="item item2 @yield('picture-gallery')"><a href="{{route('admin.picturegallery.index')}}" class="link link2">{{__('content.list_of_picturegallery')}}</a></li>
                                @endpermission
                                @permission('create.picturegallery')
                                <li class="item item2 @yield('admin.picturegallery.create')"><a href="{{route('admin.picturegallery.create')}}" class="link link2">{{__('content.create_picturegallery')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.member|create.member')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">اعضاء
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.member')
                                <li class="item item2 @yield('admin.member_category.index')"><a href="{{route('admin.member_category.index')}}" class="link link2">مدیریت دسته بندی اعضاء</a></li>
                                <li class="item item2 @yield('admin.member.index')"><a href="{{route('admin.member.index')}}" class="link link2">{{__('content.list_of_member')}}</a></li>
                                @endpermission
                                @permission('create.member')
                                <li class="item item2 @yield('admin.member.create')"><a href="{{route('admin.member.create')}}" class="link link2">{{__('content.create_member')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.productcategory|create.productcategory')
                         <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">دسته بندی محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.productcategory')
                                <li class="item item2 @yield('admin.productcategory.index')"><a href="{{route('admin.productCategory.index')}}" class="link link2">لیست دسته بندیها</a></li>
                                @endpermission
                                @permission('create.productcategory')
                                <li class="item item2 @yield('admin.productcategory.create')"><a href="{{route('admin.productCategory.create')}}" class="link link2">افزودن دسته بندی محصول</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.product|create.product')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.product')
                                <li class="item item2 @yield('admin.product.index')"><a href="{{route('admin.product.index')}}" class="link link2">لیست محصولات</a></li>
                                @endpermission
                                @permission('create.product')
                                <li class="item item2 @yield('admin.product.create')"><a href="{{route('admin.product.create')}}" class="link link2">افزودن محصول</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.giftcart|create.giftcart')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">مدیریت کارت هدیه
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.giftcart')
                                <li class="item item2 @yield('admin.giftcart.index')"><a href="{{route('admin.giftCart.index')}}" class="link link2">نمایش کارتهای هدیه</a></li>
                                @endpermission
                                @permission('create.giftcart')
                                <li class="item item2 @yield('admin.giftcart.create')"><a href="{{route('admin.giftCart.create')}}" class="link link2">افزودن کارت هدیه</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.discountcode|create.discountcode')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">مدیریت کدهای تخفیف
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.discountcode')
                                <li class="item item2 @yield('admin.discountcode.index')"><a href="{{route('admin.discountCode.index')}}" class="link link2">نمایش کدهای تخفیف</a></li>
                                @endpermission
                                @permission('create.discountcode')
                                <li class="item item2 @yield('admin.discountcode.create')"><a href="{{route('admin.discountCode.create')}}" class="link link2">افزودن کد تخفیف</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.creditcondition|create.creditcondition')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">مدیریت شرایط اعتبار
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.creditcondition')
                                <li class="item item2 @yield('admin.creditcondition.index')"><a href="{{route('admin.creditCondition.index')}}" class="link link2">نمایش شرایط اعتبار</a></li>
                                @endpermission
                                @role('atlas-administrator')
                                <li class="item item2 @yield('admin.creditcondition.create')"><a href="{{route('admin.creditCondition.create')}}" class="link link2">افزودن شرط اعتبار</a></li>
                                @endrole
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.paymenttype|create.paymenttype')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">مدیریت نحوه های پرداخت
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.paymenttype')
                                <li class="item item2 @yield('admin.paymenttype.index')"><a href="{{route('admin.paymentType.index')}}" class="link link2">نمایش نحوه های پرداخت</a></li>
                                @endpermission
                                @role('atlas-administrator')
                                <li class="item item2 @yield('admin.paymenttype.create')"><a href="{{route('admin.paymentType.create')}}" class="link link2">افزودن نحوه پرداخت </a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.ordertype|create.ordertype')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">مدیریت انواع سفارش
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.ordertype')
                                <li class="item item2 @yield('admin.ordertype.index')"><a href="{{route('admin.orderType.index')}}" class="link link2">نمایش انواع سفارش</a></li>
                                @endpermission
                                @permission('create.ordertype')
                                <li class="item item2 @yield('admin.ordertype.create')"><a href="{{route('admin.orderType.create')}}" class="link link2">افزودن نوع سفارش</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.service|create.service')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.service')
                                <li class="item item2 @yield('admin.service.index')"><a href="{{route('admin.service.index')}}" class="link link2">{{__('content.list_of_service')}}</a></li>
                                @endpermission
                                @permission('create.service')
                                <li class="item item2 @yield('admin.service.create')"><a href="{{route('admin.service.create')}}" class="link link2">{{__('content.create_service')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.comment')
                        <li class="item item1 @yield('admin.comment.index') @if($data_header['comments']->count()) show_notif @endif">
                            <a href="{{route('admin.comment.index')}}" target="" class="link link1">{{__('content.management_comment')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                      

                    </ul>
                    @permission('view.printservice')
                    <p class="tab_title dis_none" data-section-p>مدیریت خدمات دفتر فنی مهندسی</p>
                    <ul class="step1" data-section-ul>
                        @permission('view.order|edit.order')
                        <li class="item item1 hassub @yield('admin.order.index') @if($data_header['orders']) show_notif @endif">
                            <a href="#" target="" class="link link1">مدیریت سفارشات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.printservice')
                                <li class="item item2 @yield('admin.order.index')">
                                    <a href="{{route('admin.order.index')}}" class="link link2">لیست سفارشات</a>
                                </li>
                                @endpermission
                                @permission('create.printservice')
                                <li class="item item2 @yield('admin.order.report')"><a href="{{route('admin.order.report')}}" class="link link2">گزارشات</a></li>
                                @endpermission
                            </ul>
                        </li>

                        @endpermission

                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">مدیریت خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.printservice')
                                <li class="item item2 @yield('admin.printservice.index')"><a href="{{route('admin.printService.index')}}" class="link link2">نمایش خدمات</a></li>
                                @endpermission
                                @permission('create.printservice')
                                <li class="item item2 @yield('admin.printservice.create')"><a href="{{route('admin.printService.create')}}" class="link link2">افزودن خدمت</a></li>
                                @endpermission
                            </ul>
                        </li>

                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">مدیریت لیست های خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.selectbox')
                                <li class="item item2 @yield('admin.selectbox.index')"><a href="{{route('admin.selectBox.index')}}" class="link link2">نمایش لیست خدمات</a></li>
                                @endpermission
                                @permission('create.selectbox')
                                <li class="item item2 @yield('admin.selectbox.create')"><a href="{{route('admin.selectBox.create')}}" class="link link2">افزودن لیست خدمات</a></li>
                                @endpermission
                            </ul>
                        </li>
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">مدیریت مقادیر لیست های خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.selectboxvalue')
                                <li class="item item2 @yield('admin.selectboxvalue.index')"><a href="{{route('admin.selectBoxValue.index')}}" class="link link2">نمایش مقادیر لیست خدمات</a></li>
                                @endpermission
                                @permission('create.selectboxvalue')
                                <li class="item item2 @yield('admin.selectboxvalue.create')"><a href="{{route('admin.selectBoxValue.create')}}" class="link link2">افزودن مقدار لیست خدمات</a></li>
                                @endpermission
                            </ul>
                        </li>
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">مدیرت پسوندهای فایل
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.extension')
                                <li class="item item2 @yield('admin.extension.index')"><a href="{{route('admin.extension.index')}}" class="link link2">نمایش پسوندهای فایل</a></li>
                                @endpermission
                                @permission('create.extension')
                                <li class="item item2 @yield('admin.extension.create')"><a href="{{route('admin.extension.create')}}" class="link link2">افزودن پسوند فایل</a></li>
                                @endpermission
                            </ul>
                        </li>
                    </ul>
                    @endpermission
                </div>

                {{--<div data-section>
                    <p class="tab_title dis_none" data-section-p>مدیریت درخواست ها</p>
                    <ul class="step1" data-section-ul>
                        @permission('view.inventory')
                        <li class="item item1 @yield('admin.inventory.index') @if($data_header['increase_balance_request']->count()) show_notif @endif">
                            <a href="{{route('admin.inventory.index')}}" target="" class="link link1">درخواست های افزایش موجودی
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission

                        @permission('view.checkout')
                        <li class="item item1 @yield('admin.checkout.index') @if($data_header['checkouts']->count()) show_notif @endif">
                            <a href="{{route('admin.checkout.index')}}" target="" class="link link1">درخواست های تسویه حساب
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission

                        @permission('view.newsletter')
                        <li class="item item1 @yield('admin.newsletter.index')">
                            <a href="{{route('admin.newsletter.index')}}" target="" class="link link1">
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </div>
--}}
                <div data-section>
                    <p class="tab_title dis_none" data-section-p>{{__('content.site_other_managements')}}</p>
                    <ul class="step1" data-section-ul>
                        @permission('view.aboutus|create.aboutus')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">{{__('permission.aboutus')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.aboutus')
                                <li class="item item2 @yield('admin.aboutus.index')"><a href="{{route('admin.aboutUs.index')}}" class="link link2">نمایش درباره ما</a></li>
                                @endpermission
                                @permission('create.aboutus')
                                <li class="item item2 @yield('admin.aboutus.create')"><a href="{{route('admin.aboutUs.create')}}" class="link link2">افزودن درباره ما</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.banner|create.banner')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">بنر
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.banner')
                                <li class="item item2 @yield('admin.banner.index')"><a href="{{route('admin.banner.index')}}" class="link link2">لیست بنرها</a></li>
                                @endpermission
                                @permission('create.banner')
                                <li class="item item2 @yield('admin.banner.create')"><a href="{{route('admin.banner.create')}}" class="link link2">افزودن بنر</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.bankaccount|create.bankaccount')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">حسابهای بانکی
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.bankaccount')
                                <li class="item item2 @yield('admin.bankaccount.index')"><a href="{{route('admin.bankAccount.index')}}" class="link link2">لیست حسابهای بانکی</a></li>
                                @endpermission
                                @permission('create.bankaccount')
                                <li class="item item2 @yield('admin.bankaccount.create')"><a href="{{route('admin.bankAccount.create')}}" class="link link2">افزودن حساب بانکی</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.printservicedescription|create.printservicedescription')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">نحوه ارائه خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.printservicedescription')
                                <li class="item item2 @yield('admin.printservicedescription.index')"><a href="{{route('admin.printServiceDescription.index')}}" class="link link2">لیست نحوه ارائه خدمات</a></li>
                                @endpermission
                                @permission('create.printservicedescription')
                                <li class="item item2 @yield('admin.printservicedescription.create')"><a href="{{route('admin.printServiceDescription.create')}}" class="link link2">افزودن نحوه ارائه خدمات</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.news|create.news')
                            <li class="item item1 hassub {{--show_notif--}}">
                                <a href="#" target="" class="link link1">{{__('permission.news')}}
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                                <ul class="step2">
                                    @permission('view.news')
                                    <li class="item item2 @yield('admin.news.index')"><a href="{{route('admin.news.index')}}" class="link link2">لیست اخبار</a></li>
                                    @endpermission
                                    @permission('create.news')
                                    <li class="item item2 @yield('admin.news.create')"><a href="{{route('admin.news.create')}}" class="link link2">{{__('content.create_news')}}</a></li>
                                    @endpermission
                                </ul>
                            </li>
                        @endpermission

                        @permission('view.article|create.article')
                            <li class="item item1 hassub {{--show_notif--}}">
                                <a href="#" target="" class="link link1">{{__('content.articles')}}
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                                <ul class="step2">
                                    @permission('view.article')
                                    <li class="item item2 @yield('admin.article.index')"><a href="{{route('admin.article.index')}}" class="link link2">{{__('content.list_of_article')}}</a></li>
                                    @endpermission
                                    @permission('create.article')
                                    <li class="item item2 @yield('admin.article.create')"><a href="{{route('admin.article.create')}}" class="link link2">{{__('content.create_article')}}</a></li>
                                    @endpermission
                                </ul>
                            </li>
                        @endpermission
                        @permission('view.articlecategory|create.articlecategory')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">Article categories
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.articlecategory')
                                <li class="item item2 @yield('admin.article_category.index')"><a href="{{route('admin.articleCategory.index')}}" class="link link2">View article categories</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.contact|create.contact')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">اطلاعات تماس
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.contact')
                                <li class="item item2 @yield('admin.contact.index')"><a href="{{route('admin.contact.index')}}" class="link link2">نمایش اطلاعات تماس</a></li>
                                @endpermission
                                @permission('create.contact')
                                <li class="item item2 @yield('admin.contact.create')"><a href="{{route('admin.contact.create')}}" class="link link2">افزودن اطلاعات تماس</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.page|create.page')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">Pages
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.page')
                                <li class="item item2 @yield('admin.page.index')"><a href="{{route('admin.page.index')}}" class="link link2">View pages</a></li>
                                @endpermission
                                @permission('create.page')
                                <li class="item item2 @yield('admin.page.create')"><a href="{{route('admin.page.create')}}" class="link link2">Create page</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.sitecontentimage|create.sitecontentimage')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">تصاویر وبسایت
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.sitecontentimage')
                                <li class="item item2 @yield('admin.sitecontentimage.index')"><a href="{{route('admin.siteContentImage.index')}}" class="link link2">نمایش تصاویر</a></li>
                                @endpermission
                                @role('atlas-administrator')
                                <li class="item item2 @yield('admin.sitecontentimage.create')"><a href="{{route('admin.siteContentImage.create')}}" class="link link2">ایجاد تصویر جدید</a></li>
                                @endrole
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.adplan|view.adtime|view.adsection|view.addetail|view.adrequest|view.advertisement')
                            <li class="item item1 hassub @if($data_header['adrequests']->count()) show_notif @endif">
                                <a href="#" target="" class="link link1">تبلیغات
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                                <ul class="step2">
                                    @permission('view.adplan')
                                    <li class="item item2 @yield('admin.adplan.index')"><a href="{{route('admin.adplan.index')}}" class="link link2">پلن های تبلیغاتی</a></li>
                                    @endpermission
                                    @permission('view.adtime')
                                    <li class="item item2 @yield('admin.adtime.index')"><a href="{{route('admin.adtime.index')}}" class="link link2">زمان های تبلیغاتی</a></li>
                                    @endpermission
                                    @permission('view.adsection')
                                    <li class="item item2 @yield('admin.adsection.index')"><a href="{{route('admin.adsection.index')}}" class="link link2">مکان های تبلیغاتی</a></li>
                                    @endpermission
                                    @permission('view.addetail')
                                    <li class="item item2 @yield('admin.addetail.index')"><a href="{{route('admin.addetail.index')}}" class="link link2">جزئیات تبلیغاتی</a></li>
                                    @endpermission
                                    @permission('view.adrequest')
                                    <li class="item item2 @if($data_header['adrequests']->count()) show_notif @endif @yield('admin.adrequest.index')"><a href="{{route('admin.adrequest.index')}}" class="link link2">درخواست تبلیغاتی</a></li>
                                    @endpermission
                                    @permission('view.advertisement')
                                    <li class="item item2 @yield('admin.advertisement.index')"><a href="{{route('admin.advertisement.index')}}" class="link link2">مدیریت تبلیغات</a></li>
                                    @endpermission
                                </ul>
                            </li>
                        @endpermission

                        @permission('view.guide')
                            <li class="item item1 @yield('admin.guide.index')">
                                <a href="{{route('admin.guide.index')}}" target="" class="link link1">راهنمای سایت
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                            </li>
                        @endpermission


                        @permission('view.policy')
                            <li class="item item1 @yield('admin.policy.index')">
                                <a href="{{route('admin.policy.index')}}" target="" class="link link1">{{__('permission.policy')}}
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                            </li>
                        @endpermission

                        @permission('view.faq')
                            <li class="item item1 @yield('admin.faq.index')">
                                <a href="{{route('admin.faq.index')}}" target="" class="link link1">{{__('permission.faq')}}
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                            </li>
                        @endpermission

                        @permission('view.managermessage')
                            <li class="item item1 @yield('admin.managermessage.index')">
                                <a href="{{route('admin.managermessage.index')}}" target="" class="link link1">پیام های مدیریت
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                            </li>
                        @endpermission

                        @permission('view.slider')
                            <li class="item item1 @yield('admin.slider.index')">
                                <a href="{{route('admin.slider.index')}}" target="" class="link link1">مدیریت اسلایدر
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                            </li>
                        @endpermission

                        @permission('view.contactus|view.about|view.social|view.applink|view.sitecontent')
                            <li class="item item1 hassub {{--show_notif--}}">
                                <a href="#" target="" class="link link1">محتوای سایت
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                                <ul class="step2">
                                    @permission('view.contactus')
                                    <li class="item item2 @yield('contact')"><a href="{{route('admin.contactus.index')}}" class="link link2">اطلاعات تماس با ما</a></li>
                                    @endpermission
                                    @permission('view.about')
                                    <li class="item item2 @yield('admin.about.index')"><a href="{{route('admin.about.index')}}" class="link link2">اطلاعات درباره ما</a></li>
                                    @endpermission
                                    @permission('view.social')
                                    <li class="item item2 @yield('admin.social.index')"><a href="{{route('admin.social.index')}}" class="link link2">لینک شبکه های اجتماعی</a></li>
                                    @endpermission
                                    @permission('view.applink')
                                    <li class="item item2 @yield('admin.applink.index')"><a href="{{route('admin.applink.index')}}" class="link link2">لینک اپلیکیشن و انجمن</a></li>
                                    @endpermission
                                    @permission('view.sitecontent')
                                    <li class="item item2 @yield('admin.sitecontent.index')"><a href="{{route('admin.sitecontent.index')}}" class="link link2">متن های سایت</a></li>
                                    @endpermission

                                </ul>
                            </li>
                        @endpermission
                    </ul>
                </div>

                <div data-section>
                    <p class="tab_title dis_none" data-section-p>تنظیمات</p>
                    <ul class="step1" data-section-ul>
                        @permission('view.logactivity')
                            <li class="item item1 @yield('admin.logactivity.index')">
                                <a href="{{route('admin.logactivity.index')}}" class="link link1">{{__('content.management_logactivity')}}
                                    <i class="icon i-checkmark-round"></i>
                                    <i class="arrow i-angle-down"></i>
                                </a>
                            </li>
                        @endpermission

                        @permission('view.statistic')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">گزارش درآمد و فروش
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                <li class="item item2 @yield('admin.statistic.index')">
                                    <a href="{{route('admin.statistic.index')}}" class="link link2">گزارش درآمد فروشگاه</a>
                                </li>
                                <li class="item item2 @yield('admin.statistic.sales')">
                                    <a href="{{route('admin.statistic.sales')}}" class="link link2">گزارش فروش کالاها</a>
                                </li>
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.calendar')
                        <li class="item item1 @yield('admin.calendar.index')">
                            <a href="{{route('admin.calendar.index')}}" target="" class="link link1">{{__('content.management_calendar')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission

                        @permission('view.week')
                        <li class="item item1 @yield('admin.week.index')">
                            <a href="{{route('admin.week.index')}}" target="" class="link link1">مدیریت ساعت کار هفته
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission

                        @permission('view.sendtype|view.paytype')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">تعرفه سرویس ها و خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.sendtype')
                                <li class="item item2 @yield('admin.send_type.index')"><a href="{{route('admin.send_type.index')}}" class="link link2">{{__('content.management_send_type')}}</a></li>
                                @endpermission
                                @permission('view.paytype')
                                <li class="item item2 @yield('admin.pay_type.index')"><a href="{{route('admin.pay_type.index')}}" class="link link2">{{__('content.management_pay_type')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.education|view.skill|view.bank|view.plan|view.color|view.mobilepreorder')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">تنظیمات عمومی
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.education')
                                <li class="item item2 @yield('admin.education.index')"><a href="{{route('admin.education.index')}}" class="link link2">میزان تحصیلات</a></li>
                                @endpermission
                                @permission('view.skill')
                                <li class="item item2 @yield('admin.skill.index')"><a href="{{route('admin.skill.index')}}" class="link link2">سطح مهارت</a></li>
                                @endpermission
                                @permission('view.bank')
                                <li class="item item2 @yield('admin.bank.index')"><a href="{{route('admin.bank.index')}}" class="link link2">{{__('content.list_of_bank')}}</a></li>
                                @endpermission
                                @permission('view.plan')
                                <li class="item item2 @yield('admin.plan.index')"><a href="{{route('admin.plan.index')}}" class="link link2">{{__('content.list_of_plan')}}</a></li>
                                @endpermission
                                @permission('view.color')
                                <li class="item item2 @yield('admin.color.index')"><a href="{{route('admin.color.index')}}" class="link link2">{{__('content.list_of_color')}}</a></li>
                                @endpermission
                                @permission('view.mobilepreorder')
                                <li class="item item2 @yield('admin.mobilepreorder.index')"><a href="{{route('admin.mobilepreorder.index')}}" class="link link2">پیش شماره موبایل</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                    </ul>
                </div>

            </div><!--list_style1-->
        </div><!--tab_content1-->

        @permission('view.contact || view.ticket || view.chat')
            <div class="tab_content tab_content2 @yield('admin.message')">
                <div class="list_style2 ">
                    <p class="tab_title">پیامهای تماس با ما</p>
                    <ul class="step1">
                        @permission('view.chat')
                            <li class="item item1 @yield('admin.chat.index') @if($data_header['chats'] > 0) show_notif @endif">
                                <a href="{{route('admin.chat.index')}}" class="link link1">{{__('content.menu_chat')}} @if($data_header['chats'] > 0)<i class="no alert">({{$data_header['chats']}})</i>@endif</a>
                            </li>
                        @endpermission
                        @permission('view.ticket')
                            <li class="item item1 @yield('admin.ticket.index') @if($data_header['tickets']->count()) show_notif @endif"><a href="{{route('admin.ticket.index')}}" target="" class="link link1">{{__('content.menu_ticket')}} @if($data_header['tickets']->count())<i class="no alert">({{$data_header['tickets']->count()}})</i>@endif</a></li>
                        @endpermission
                        @permission('view.contact')
                            <li class="item item1 @yield('admin.contact.message') @if($data_header['contacts']->count()) show_notif @endif"><a href="{{route('admin.contactUs.index')}}" target="" class="link link1">پیامهای تماس باما وبسایت @if($data_header['contacts']->count())<i class="no alert">({{$data_header['contacts']->count()}})</i>@endif</a></li>
                        @endpermission
                    </ul>
                </div><!--list_style2-->
            </div><!--tab_content2-->
        @endpermission

        @permission('view.user')
            <div class="tab_content tab_content3 @yield('admin.user')">
                <div class="list_style2 ">
                    <p class="tab_title">کاربران</p>
                    <ul class="step1">
                        <li class="item item1 @yield('admin.user.index')"><a href="{{route('admin.user.index')}}" class="link link1">نمایش کاربران</a></li>
                    </ul>
                </div><!--list_style2-->
            </div><!--tab_content3-->
        @endpermission

        <div class="tab_content tab_content4">
            <p class="tab_title">{{__('content.search_in_pages')}}</p>
            <div class="search_wrapper">
                <input type="text" name="keyword">
                <i class="i-ios-search-strong icon"></i>
            </div><!--search_wrapper-->
            <div class="search_result">
                <div class="list_style2 ">
                    <ul class="step1"></ul>
                </div><!--list_style2-->
            </div><!--search_wrapper-->
        </div><!--tab_content3-->

    </div><!--sidebar_part3-->
</aside>

<script type="text/javascript">
    $(document).ready(function(){
        $('[data-section-ul]').each(function(){
            var $data_section = $(this).closest('[data-section]');
            var $data_section_ul = $(this);
            var $data_section_ul_li = $(this).find('li');
            var $data_section_p = $data_section.find('[data-section-p]');
            if($data_section_ul_li.length){
                $data_section_p.show();
            }
        });
    });
</script>