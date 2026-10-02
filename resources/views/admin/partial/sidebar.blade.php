<aside class="sidebar_style1">
    <div class="sidebar_part1">
        <div class="usermenu_wrapper">
            <a href="#" class="usermenu_part1 clearfix">
                <!--<span class='pic_style1' style='background-image:url(_images/pic_profile.jpg);'></span>-->
                <span class="logo"
                      style="background-image:url({{asset('assets/admin/_images/logo/logo_for_admin.png')}});"></span>
                <div class="name_profile">
                    <p class="name_profile1">{{Auth::guard('admins')->user()->name}} {{Auth::guard('admins')->user()->family}}</p>
                    <p class="name_profile2">{{Auth::guard('admins')->user()->email}}</p>
                    <i class="i-angle-down icon_arrow"></i>
                </div>
            </a>
            <div class="usermenu_part2">
                <ul class="list">
                    <li class="item"><a href="{{route('admin.home.index')}}"
                                        class="link">{{__('content.my_profile')}}</a></li>
                    @role('atlas-administrator|administrator')
                    <li class="item"><a href="{{route('admin.admin.create')}}"
                                        class="link">{{__('content.create_admin')}}</a></li>
                    <li class="item"><a href="{{route('admin.admin.index')}}"
                                        class="link">{{__('content.management_admins')}}</a></li>
                    <li class="item"><a href="{{route('admin.role.index')}}"
                                        class="link">{{__('content.management_roles')}}</a></li>
                    @endrole
                    <li class="item logout"><a href="{{route('admin.auth.logout')}}"
                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                               class="link"><i class="icon i-power-2"></i>{{__('content.logout')}}</a>
                    </li>
                    <form id="logout-form" action="{{route('admin.auth.logout')}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </div><!--usermenu-->
        </div><!--usermenu_wrapper-->
    </div><!--sidebar_part1-->

    <div class="sidebar_part2">
        <ul class="step1 clearfix">
            <li class="item tab1 index @yield('admin.all')" title="{{__('content.list_pages')}}" data-tabno="1"
                style="width: 25%;"><i class="i-dot-3"></i></li>
            @permission('view.message || view.contact')
            <li class="item tab2 mail @yield('admin.message')" title="پیام های سایت" data-tabno="2" style="width: 25%;">
                <i class="i-letter-mail-1"></i>
                @if($data_header['messages'] || $data_header['violationreports'])
                    <i class="notif" style="display: inline-block;"></i>
                @endif
            </li>
            @endpermission
            @permission('view.user')
            <li class="item tab3 user @yield('admin.user')" title="کاربران سایت" data-tabno="3" style="width: 25%;"><i
                        class="i-person"></i></li>
            @endpermission
            <li class="item tab4 search" title="{{__('content.search_in_pages')}}" data-tabno="4" style="width: 25%;"><i
                        class="i-search"></i></li>
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
                            <li class="item item2 @yield('admin.role.index')"><a href="{{route('admin.role.index')}}"
                                                                                 class="link link2">{{__('content.management_roles')}}</a>
                            </li>
                            <li class="item item2 @yield('admin.role.create')"><a href="{{route('admin.role.create')}}"
                                                                                  class="link link2">{{__('content.create_role')}}</a>
                            </li>

                            <li class="item item2 @yield('admin.permission.index')"><a
                                        href="{{route('admin.permission.index')}}"
                                        class="link link2">{{__('content.management_permissions')}}</a></li>
                            <li class="item item2 @yield('admin.permission.create')"><a
                                        href="{{route('admin.permission.create')}}"
                                        class="link link2">{{__('content.create_permission')}}</a></li>
                        </ul>
                    </li>
                </ul>
                @endrole

                <div data-section>
                    <p class="tab_title dis_none" data-section-p>{{__('content.site_main_managements')}}</p>
                    <ul class="step1" data-section-ul>
                       
                        <li class="item item1">
                            <a href="{{route('social_network.index')}}" target="" class="link link1">مدیریت شبکه ی ها اجتماعی 
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        <li class="item item1">
                            <a href="{{route('slider.create')}}" target="" class="link link1">اسلایدر صفحه ی اصلی
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @permission('view.brand')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1"> برند ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.brand')
                                <li class="item item2 @yield('admin.brand.index')"><a
                                            href="{{route('admin.brand.index')}}" class="link link2">نمایش برندها</a>
                                </li>
                                @endpermission
                                @permission('create.brand')
                                <li class="item item2 @yield('admin.brand.create')"><a
                                            href="{{route('admin.brand.create')}}" class="link link2">افزودن برند</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.plan')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">پلن محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.plan')
                                <li class="item item2 @yield('admin.plan.index')"><a
                                            href="{{route('admin.plan.index')}}" class="link link2">نمایش پلن ها </a>
                                </li>
                                @endpermission
                                @permission('create.plan')
                                <li class="item item2 @yield('admin.plan.create')"><a
                                            href="{{route('admin.plan.create')}}" class="link link2">افزودن پلن</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.productcategory')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1"> دسته بندیهای محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.productcategory')
                                <li class="item item2 @yield('admin.productcategory.index')"><a
                                            href="{{route('admin.productCategory.index')}}" class="link link2">نمایش
                                        دسته بندیهای محصولات</a>
                                </li>
                                @endpermission
                                @permission('create.productcategory')
                                <li class="item item2 @yield('admin.productcategory.create')"><a
                                            href="{{route('admin.productCategory.create')}}" class="link link2">افزودن
                                        دسته بندی محصول</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.technicalspecification')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">مشخصات فنی
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.technicalspecification')
                                <li class="item item2 @yield('admin.technicalspecification.index')"><a
                                            href="{{route('admin.technicalSpecification.index')}}" class="link link2">نمایش
                                        مشخصات فنی</a>
                                </li>
                                @endpermission
                                @permission('create.technicalspecification')
                                <li class="item item2 @yield('admin.technicalspecification.create')"><a
                                            href="{{route('admin.technicalSpecification.create')}}" class="link link2">افزودن
                                        مشخصه فنی</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.product')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.product')
                                <li class="item item2 @yield('admin.product.index')"><a
                                            href="{{route('admin.product.index')}}" class="link link2">نمایش محصولات</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.firstpagespecialsuggestion')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">پیشنهادات ویژه
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.firstpagespecialsuggestion')
                                <li class="item item2 @yield('admin.firstpagespecialsuggestion.index')">
                                    <a href="{{route('admin.firstPageSpecialSuggestion.index')}}" class="link link2">نمایش
                                        پیشنهادات ویژه</a>
                                </li>
                                @endpermission
                                @permission('create.firstpagespecialsuggestion')
                                <li class="item item2 @yield('admin.firstpagespecialsuggestion.create')">
                                    <a href="{{route('admin.firstPageSpecialSuggestion.create')}}" class="link link2">افزودن
                                        پیشنهاد ویژه</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.firstpagespecialsell')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">فروش ویژه
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.firstpagespecialsell')
                                <li class="item item2 @yield('admin.firstpagespecialsell.index')">
                                    <a href="{{route('admin.firstPageSpecialSell.index')}}" class="link link2">نمایش
                                        فروش ویژه</a>
                                </li>
                                @endpermission
                                @permission('create.firstpagespecialsell')
                                <li class="item item2 @yield('admin.firstpagespecialsell.create')">
                                    <a href="{{route('admin.firstPageSpecialSell.create')}}" class="link link2">افزودن
                                        فروش ویژه</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission


                        @permission('view.shop')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">فروشگاها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.shop')
                                <li class="item item2 @yield('admin.shop.index')"><a
                                            href="{{route('admin.shop.index')}}" class="link link2">نمایش فروشگاها</a>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.checkout')
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">تسویه حساب ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                <li class="item item1 @yield('admin.checkout.index')">
                                    <a href="{{route('admin.checkout.index')}}" target=""
                                       class="link link1">تسویه حساب فروشگاه
                                        <i class="icon i-checkmark-round"></i>
                                        <i class="arrow i-angle-down"></i>
                                    </a>
                                </li>
                                <li class="item item1 @yield('admin.checkout.index')">
                                    <a href="{{route('admin.credit.index')}}" target=""
                                       class="link link1">تسویه حساب موجودی
                                        <i class="icon i-checkmark-round"></i>
                                        <i class="arrow i-angle-down"></i>
                                    </a>
                                </li>
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
                                <li class="item item2 @yield('admin.videogallery.index')"><a
                                            href="{{route('admin.videogallery.index')}}"
                                            class="link link2">{{__('content.list_of_videogallery')}}</a></li>
                                @endpermission
                                @permission('create.videogallery')
                                <li class="item item2 @yield('admin.videogallery.create')"><a
                                            href="{{route('admin.videogallery.create')}}"
                                            class="link link2">{{__('content.create_videogallery')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.picturegallery|create.picturegallery')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">{{__('content.picturegallery')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.picturegallery')
                                <li class="item item2 @yield('admin.picturegallery.index')"><a
                                            href="{{route('admin.picturegallery.index')}}"
                                            class="link link2">{{__('content.list_of_picturegallery')}}</a></li>
                                @endpermission
                                @permission('create.picturegallery')
                                <li class="item item2 @yield('admin.picturegallery.create')"><a
                                            href="{{route('admin.picturegallery.create')}}"
                                            class="link link2">{{__('content.create_picturegallery')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.comment')
                        <li class="item item1 @yield('admin.comment.index') {{--@if($data_header['comments']) show_notif @endif--}}">
                            <a href="{{route('admin.comment.index')}}" target=""
                               class="link link1">{{__('content.management_comment')}}
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                        @permission('view.order')
                        <li class="item item1 @yield('admin.order.index') {{--@if($data_header['orders']) show_notif @endif--}}">
                            <a href="{{route('admin.order.index')}}" target=""
                               class="link link1">سفارشات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                        @permission('view.payment')
                        <li class="item item1 @yield('admin.payment.index')">
                            <a href="{{route('admin.payment.index')}}" target=""
                               class="link link1">پرداخت ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission

                    </ul>
                </div>

                <div data-section>
                    <p class="tab_title dis_none" data-section-p>مدیریت درخواست ها</p>
                    <ul class="step1" data-section-ul>
                        {{--   @permission('view.inventory')
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
                           @endpermissio--}}

                        @permission('view.newsletter')
                        <li class="item item1 @yield('admin.newsletter.index')">
                            <a href="{{route('admin.newsletter.index')}}" target="" class="link link1">مدیریت خبرنامه ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </div>
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
                                <li class="item item2 @yield('admin.aboutus.index')"><a
                                            href="{{route('admin.aboutUs.index')}}" class="link link2">نمایش درباره
                                        ما</a></li>
                                @endpermission
                                @permission('create.aboutus')
                                <li class="item item2 @yield('admin.aboutus.create')"><a
                                            href="{{route('admin.aboutUs.create')}}" class="link link2">افزودن درباره
                                        ما</a></li>
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
                                <li class="item item2 @yield('admin.bankaccount.index')"><a
                                            href="{{route('admin.bankAccount.index')}}" class="link link2">لیست حسابهای
                                        بانکی</a></li>
                                @endpermission
                                @permission('create.bankaccount')
                                <li class="item item2 @yield('admin.bankaccount.create')"><a
                                            href="{{route('admin.bankAccount.create')}}" class="link link2">افزودن حساب
                                        بانکی</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.country|create.country')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">کشورها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.country')
                                <li class="item item2 @yield('admin.country.index')"><a
                                            href="{{route('admin.country.index')}}" class="link link2">لیست کشورها</a>
                                </li>
                                @endpermission
                                @permission('create.country')
                                <li class="item item2 @yield('admin.country.create')"><a
                                            href="{{route('admin.country.create')}}" class="link link2">افزودن کشور</a>
                                </li>
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
                                <li class="item item2 @yield('admin.news.index')"><a
                                            href="{{route('admin.news.index')}}" class="link link2">لیست اخبار</a></li>
                                @endpermission
                                @permission('create.news')
                                <li class="item item2 @yield('admin.news.create')"><a
                                            href="{{route('admin.news.create')}}"
                                            class="link link2">{{__('content.create_news')}}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        <!--#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-->
                        <!--Article     >
                        <!--#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-->
                        @permission('view.articlecategory|create.articlecategory')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">دسته بندی مقالات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.articlecategory')
                                <li class="item item2 @yield('admin.articlecategory.index')"><a
                                            href="{{route('admin.articleCategory.index')}}"
                                            class="link link2">نمایش دسته بندی مقالات</a></li>
                                @endpermission
                                @permission('create.articlecategory')
                                <li class="item item2 @yield('admin.articlecategory.create')"><a
                                            href="{{route('admin.articleCategory.create')}}"
                                            class="link link2">افزودن دسته بندی مقاله</a></li>
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
                                <li class="item item2 @yield('admin.article.index')"><a
                                            href="{{route('admin.article.index')}}"
                                            class="link link2">{{__('content.list_of_article')}}</a></li>
                                @endpermission
                                {{-- @permission('create.article')
                                 <li class="item item2 @yield('admin.article.create')"><a
                                             href="{{route('admin.article.create')}}"
                                             class="link link2">{{__('content.create_article')}}</a></li>
                                 @endpermission--}}
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.suggestedproduct|create.suggestedproduct')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">محصولات پیشنهادی
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.suggestedproduct')
                                <li class="item item2 @yield('admin.suggestedproduct.index')"><a
                                            href="{{route('admin.suggestedProduct.index')}}"
                                            class="link link2">نمایش محصولات پیشنهادی</a></li>
                                @endpermission
                                @permission('create.suggestedproduct')
                                <li class="item item2 @yield('admin.suggestedproduct.create')"><a
                                            href="{{route('admin.suggestedProduct.create')}}"
                                            class="link link2">افزودن محصول پیشنهادی</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.document|create.document')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">مدارک محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.document')
                                <li class="item item2 @yield('admin.document.index')"><a
                                            href="{{route('admin.document.index')}}"
                                            class="link link2">نمایش مدارک</a></li>
                                @endpermission
                                @permission('create.document')
                                <li class="item item2 @yield('admin.document.create')"><a
                                            href="{{route('admin.document.create')}}"
                                            class="link link2">افزودن مدرک</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.standard|create.standard')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">استاندارد محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.standard')
                                <li class="item item2 @yield('admin.standard.index')"><a
                                            href="{{route('admin.standard.index')}}"
                                            class="link link2">نمایش استانداردها</a></li>
                                @endpermission
                                @permission('create.standard')
                                <li class="item item2 @yield('admin.standard.create')"><a
                                            href="{{route('admin.standard.create')}}"
                                            class="link link2">افزودن استاندارد</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission('view.catalog|create.catalog')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">کاتالوگ محصولات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.catalog')
                                <li class="item item2 @yield('admin.catalog.index')"><a
                                            href="{{route('admin.catalog.index')}}"
                                            class="link link2">نمایش کاتالوگ ها</a></li>
                                @endpermission
                                @permission('create.catalog')
                                <li class="item item2 @yield('admin.catalog.create')"><a
                                            href="{{route('admin.catalog.create')}}"
                                            class="link link2">افزودن کاتالوگ</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.pricerange|create.pricerange')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">بازه قیمت ها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.pricerange')
                                <li class="item item2 @yield('admin.pricerange.index')"><a
                                            href="{{route('admin.priceRange.index')}}"
                                            class="link link2">نمایش بازه قیمت</a></li>
                                @endpermission
                                @permission('create.pricerange')
                                <li class="item item2 @yield('admin.pricerange.create')"><a
                                            href="{{route('admin.priceRange.create')}}"
                                            class="link link2">افزودن بازه قیمت</a></li>
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
                                <li class="item item2 @yield('admin.contact.index')"><a
                                            href="{{route('admin.contact.index')}}" class="link link2">نمایش اطلاعات
                                        تماس</a></li>
                                @endpermission
                                @permission('create.contact')
                                <li class="item item2 @yield('admin.contact.create')"><a
                                            href="{{route('admin.contact.create')}}" class="link link2">افزودن اطلاعات
                                        تماس</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.page|create.page')
                        <li class="item item1 hassub {{--show_notif--}}">
                            <a href="#" target="" class="link link1">صفحات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.page')
                                <li class="item item2 @yield('admin.page.index')"><a
                                            href="{{route('admin.page.index')}}" class="link link2">لیست صفحات</a></li>
                                @endpermission
                                @permission('create.page')
                                <li class="item item2 @yield('admin.page.create')"><a
                                            href="{{route('admin.page.create')}}" class="link link2">افزودن صفحه</a>
                                </li>
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
                                <li class="item item2 @yield('admin.sitecontentimage.index')"><a
                                            href="{{route('admin.siteContentImage.index')}}" class="link link2">نمایش
                                        تصاویر</a></li>
                                @endpermission
                                @role('atlas-administrator')
                                <li class="item item2 @yield('admin.sitecontentimage.create')"><a
                                            href="{{route('admin.siteContentImage.create')}}" class="link link2">ایجاد
                                        تصویر جدید</a></li>
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
                                <li class="item item2 @yield('admin.adplan.index')"><a
                                            href="{{route('admin.adplan.index')}}" class="link link2">پلن های
                                        تبلیغاتی</a></li>
                                @endpermission
                                @permission('view.adtime')
                                <li class="item item2 @yield('admin.adtime.index')"><a
                                            href="{{route('admin.adtime.index')}}" class="link link2">زمان های
                                        تبلیغاتی</a></li>
                                @endpermission
                                @permission('view.adsection')
                                <li class="item item2 @yield('admin.adsection.index')"><a
                                            href="{{route('admin.adsection.index')}}" class="link link2">مکان های
                                        تبلیغاتی</a></li>
                                @endpermission
                                @permission('view.addetail')
                                <li class="item item2 @yield('admin.addetail.index')"><a
                                            href="{{route('admin.addetail.index')}}" class="link link2">جزئیات
                                        تبلیغاتی</a></li>
                                @endpermission
                                @permission('view.adrequest')
                                <li class="item item2 @if($data_header['adrequests']->count()) show_notif @endif @yield('admin.adrequest.index')">
                                    <a href="{{route('admin.adrequest.index')}}" class="link link2">درخواست تبلیغاتی</a>
                                </li>
                                @endpermission
                                @permission('view.advertisement')
                                <li class="item item2 @yield('admin.advertisement.index')"><a
                                            href="{{route('admin.advertisement.index')}}" class="link link2">مدیریت
                                        تبلیغات</a></li>
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
                            <a href="{{route('admin.policy.index')}}" target=""
                               class="link link1">{{__('permission.policy')}}
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
                            <a href="{{route('admin.managermessage.index')}}" target="" class="link link1">پیام های
                                مدیریت
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
                                <li class="item item2 @yield('contact')"><a href="{{route('admin.contactus.index')}}"
                                                                            class="link link2">اطلاعات تماس با ما</a>
                                </li>
                                @endpermission
                                @permission('view.about')
                                <li class="item item2 @yield('admin.about.index')"><a
                                            href="{{route('admin.about.index')}}" class="link link2">اطلاعات درباره
                                        ما</a></li>
                                @endpermission
                                @permission('view.social')
                                <li class="item item2 @yield('admin.social.index')"><a
                                            href="{{route('admin.social.index')}}" class="link link2">لینک شبکه های
                                        اجتماعی</a></li>
                                @endpermission
                                @permission('view.applink')
                                <li class="item item2 @yield('admin.applink.index')"><a
                                            href="{{route('admin.applink.index')}}" class="link link2">لینک اپلیکیشن و
                                        انجمن</a></li>
                                @endpermission
                                @permission('view.sitecontent')
                                <li class="item item2 @yield('admin.sitecontent.index')"><a
                                            href="{{route('admin.sitecontent.index')}}" class="link link2">متن های
                                        سایت</a></li>
                                @endpermission

                            </ul>
                        </li>
                        @endpermission

                        @permission('view.state|edit.state')
                        <li class="item item1 @yield('admin.state.index')">
                            <a href="{{route('admin.state.index')}}" target="" class="link link1">استانها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                        @permission('view.city|edit.city')
                        <li class="item item1 @yield('admin.city.index')">
                            <a href="{{route('admin.city.index')}}" target="" class="link link1">شهرها
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </div>

                <div data-section>
                    <p class="tab_title dis_none" data-section-p>تنظیمات</p>
                    <ul class="step1" data-section-ul>
                        @permission('view.logactivity')
                        <li class="item item1 @yield('admin.logactivity.index')">
                            <a href="{{route('admin.logactivity.index')}}"
                               class="link link1">{{__('content.management_logactivity')}}
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
                                    <a href="{{route('admin.statistic.index')}}" class="link link2">گزارش درآمد
                                        فروشگاه</a>
                                </li>
                                <li class="item item2 @yield('admin.statistic.sales')">
                                    <a href="{{route('admin.statistic.sales')}}" class="link link2">گزارش فروش
                                        کالاها</a>
                                </li>
                            </ul>
                        </li>
                        @endpermission

                        @permission('view.calendar')
                        <li class="item item1 @yield('admin.calendar.index')">
                            <a href="{{route('admin.calendar.index')}}" target=""
                               class="link link1">{{__('content.management_calendar')}}
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
                        <li class="item item1 hassub">
                            <a href="#" target="" class="link link1">تعرفه سرویس ها و خدمات
                                <i class="icon i-checkmark-round"></i>
                                <i class="arrow i-angle-down"></i>
                            </a>
                            <ul class="step2">
                                @permission('view.sendtype')
                                <li class="item item2 @yield('admin.send_type.index')"><a
                                            href="{{route('admin.send_type.index')}}"
                                            class="link link2">{{__('content.management_send_type')}}</a></li>
                                @endpermission
                                @permission('view.paytype')
                                <li class="item item2 @yield('admin.pay_type.index')"><a
                                            href="{{route('admin.pay_type.index')}}"
                                            class="link link2">{{__('content.management_pay_type')}}</a></li>
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
                                <li class="item item2 @yield('admin.education.index')"><a
                                            href="{{route('admin.education.index')}}" class="link link2">میزان
                                        تحصیلات</a></li>
                                @endpermission
                                @permission('view.skill')
                                <li class="item item2 @yield('admin.skill.index')"><a
                                            href="{{route('admin.skill.index')}}" class="link link2">سطح مهارت</a></li>
                                @endpermission
                                @permission('view.bank')
                                <li class="item item2 @yield('admin.bank.index')"><a
                                            href="{{route('admin.bank.index')}}"
                                            class="link link2">{{__('content.list_of_bank')}}</a></li>
                                @endpermission
                                @permission('view.color')
                                <li class="item item2 @yield('admin.color.index')"><a
                                            href="{{route('admin.color.index')}}"
                                            class="link link2">{{__('content.list_of_color')}}</a></li>
                                @endpermission
                                @permission('view.mobilepreorder')
                                <li class="item item2 @yield('admin.mobilepreorder.index')"><a
                                            href="{{route('admin.mobilepreorder.index')}}" class="link link2">پیش شماره
                                        موبایل</a></li>
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
                <p class="tab_title">پیامهای وبسایت</p>
                <ul class="step1">
                    @permission('view.chat')
                    <li class="item item1 @yield('admin.chat.index') @if($data_header['chats'] > 0) show_notif @endif">
                        <a href="{{route('admin.chat.index')}}"
                           class="link link1">{{__('content.menu_chat')}} @if($data_header['chats'] > 0)<i
                                    class="no alert">({{$data_header['chats']}})</i>@endif</a>
                    </li>
                    @endpermission
                    @permission('view.ticket')
                    <li class="item item1 @yield('admin.ticket.index') @if($data_header['tickets']->count()) show_notif @endif">
                        <a href="{{route('admin.ticket.index')}}" target=""
                           class="link link1">{{__('content.menu_ticket')}} @if($data_header['tickets']->count())<i
                                    class="no alert">({{$data_header['tickets']->count()}})</i>@endif</a></li>
                    @endpermission
                    @permission('view.contact')
                    <li class="item item1 @yield('admin.contact.message') @if($data_header['contacts']->count()) show_notif @endif">
                        <a href="{{route('admin.contactUs.index')}}" target="" class="link link1">پیامهای تماس باما
                            وبسایت @if($data_header['contacts']->count())<i
                                    class="no alert">({{$data_header['contacts']->count()}})</i>@endif</a></li>
                    @endpermission
                    @permission('view.message')
                    <li class="item item1 @yield('admin.message.index') @if($data_header['messages']) show_notif @endif">
                        <a href="{{route('admin.message.index')}}" target="" class="link link1">پیامهای کاربران
                            وبسایت @if($data_header['messages'])<i class="no alert">
                                ({{$data_header['messages']}})</i>
                            @endif</a>
                    </li>
                    @endpermission
                    @permission('view.violationreport')
                    <li class="item item1 @yield('admin.violationreport.index') @if($data_header['violationreports']) show_notif @endif">
                        <a href="{{route('admin.violationReport.index')}}" target="" class="link link1">گزارشات
                            تخلف @if($data_header['violationreports'])<i class="no alert">
                                ({{$data_header['violationreports']}})</i>
                            @endif</a>
                    </li>
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
                    <li class="item item1 @yield('admin.user.index')"><a href="{{route('admin.user.index')}}"
                                                                         class="link link1">نمایش کاربران</a></li>
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
  $(document).ready(function () {
    $('[data-section-ul]').each(function () {
      var $data_section = $(this).closest('[data-section]');
      var $data_section_ul = $(this);
      var $data_section_ul_li = $(this).find('li');
      var $data_section_p = $data_section.find('[data-section-p]');
      if ($data_section_ul_li.length) {
        $data_section_p.show();
      }
    });
  });
</script>
