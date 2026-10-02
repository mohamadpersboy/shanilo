@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>
                        @include('front.partial.dashboard')
                        <div id="pjax-container" class='panel_content'>
                            @include('front.partial.parts.wallet-header')
                            <div class="title_style8"><span>تسویه حساب</span></div>
                            <div class="panel_cart_give_money flex">
                                <div class="form_style2">
                                        {!! Form::open([
                                        'url'=>route('front.profile.checkout.store'),
                                        'data-ajax',
                                        'data-type'=>'json',
                                        'data-on-success'=>'redirect',
                                        'data-on-error'=>'inline-message',
                                        'data-clear'=>'true'
                                        ]) !!}
                                        <ul class="frm_step flex no_bullet">
                                            <li class="frm_item flex w50 not_empty">
                                                <select name="wallet_id" class="frm_select" id="">
                                                    <option value="">لطفا یکی از فروشگاه های خود را انتخاب کنید.
                                                    </option>
                                                    @foreach($shops as $index=>$shop)
                                                        @if($shop->wallet->checkouts()->where('status','pending')->exists() || $shop->wallet->removeable<10000)
                                                            @continue
                                                        @endif
                                                        <option value="{{$shop->wallet->id}}">{{$shop->title }} (قابل
                                                            برداشت: {{showPrice($shop->wallet->removeable)}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="frm_title">فروشگاه</div>
                                            </li>
                                            <li class="frm_item flex w50 not_empty">
                                                <select name="bank_cart_id" class="frm_select" id="">
                                                    <option value="">کارت بانکی</option>
                                                    @foreach($bankCarts as $index=>$bankCart)
                                                        <option value="{{$bankCart->id}}">{{$bankCart->owner}} ({{$bankCart->cart_no}})</option>
                                                    @endforeach

                                                </select>
                                                <div class="frm_title">کارت بانکی</div>
                                            </li>
                                            <li class="frm_item flex w100 not_empty">
                                                <input type="text" class="frm_input currency" name="price"
                                                       placeholder="مبلغ درخواستی  ">
                                                <div class="frm_title">مبلغ درخواستی (تومان)</div>
                                            </li>
                                            <li class="frm_item w100 row_flex flex">
                                                <button class="btn_style2 flex">
                                                    <span class="icon"><i class="i-044-checked"></i></span>
                                                    <span class="text">درخواست تسویه</span>
                                                </button>
                                            </li>
                                        </ul>
                                  {!! Form::close() !!}
                                </div>
                            </div>
                            @if($checkouts->count())
                            <div class="table_style1 mt70">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>شماره درخواست</th>
                                        <th>فروشگاه</th>
                                        <th>مبلغ مبلغ درخواستی</th>
                                        <th>شماره پیگیری</th>
                                        <th>تاریخ تسویه</th>
                                        <th>وضعیت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($checkouts as $index=>$checkout)
                                        <tr>
                                            <td>{{$checkout->id}}</td>
                                            <td>{{$checkout->wallet->shop->title}}</td>
                                            <td><span class="price">{{showPrice($checkout->price,null,null)}}</span>
                                            </td>
                                            <td>{{$checkout->tracking_code}}</td>
                                            <td>{{$checkout->status=='done'?ShowDate($checkout->updated_at):'-'}}</td>
                                            <td>
                                                @if($checkout->status=='done')
                                                    <span class="condition_show green">تسویه شد</span>
                                                @elseif($checkout->status=='denied')
                                                    <span class="condition_show red">رد شد</span>
                                                @else
                                                    <span class="condition_show orange">درحال بررسی</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination_style2">
                                {{$checkouts->render('vendor.pagination.dashboard')}}
                            </div>
                            @else
                            <div class="noItem_style2 flex">موردی اضافه نشده!</div>
                            @endif
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>






    <div class="modal_style1 cart_box_modal w1000">
        <div class="modal_scroll flex">
            <div class="close_bg"></div>
            <div class="wrapper">
                <div class="wrapper_box">
                    <div class="close_btn"><i class="i-cancel"></i></div>
                    <div class="title_style7"><span class="title">کیف پول شماره 1</span></div>
                    <div class="text_style1">
                        کیف پول شما مختص فروشگاه های زیر میباشد.
                    </div>
                    <div class="box_style8">
                        <div class="have_scroll_y scroll_style1">
                            <ul class="step flex no_bullet">
                                <li class="item flex">
                                    <div class="pic"
                                         style="background-image: url('files/images/store/1_brand.jpg');"></div>
                                    <div class="title">فروشگاه دوم شما</div>
                                    <div class="dlt_btn"><i class="i-031-trash"></i>
                                        <div class="short_request">
                                            <span class="question_text">حذف از این کیف پول</span>
                                            <a href="#" title="" class="btn yes">بله</a>
                                            <a href="#" title="" class="btn no">خیر</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item flex">
                                    <div class="pic"
                                         style="background-image: url('files/images/store/1_brand.jpg');"></div>
                                    <div class="title">فروشگاه دوم شما</div>
                                    <div class="dlt_btn"><i class="i-031-trash"></i>
                                        <div class="short_request">
                                            <span class="question_text">حذف از این کیف پول</span>
                                            <a href="#" title="" class="btn yes">بله</a>
                                            <a href="#" title="" class="btn no">خیر</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item flex">
                                    <div class="pic"
                                         style="background-image: url('files/images/store/1_brand.jpg');"></div>
                                    <div class="title">فروشگاه دوم شما</div>
                                    <div class="dlt_btn"><i class="i-031-trash"></i>
                                        <div class="short_request">
                                            <span class="question_text">حذف از این کیف پول</span>
                                            <a href="#" title="" class="btn yes">بله</a>
                                            <a href="#" title="" class="btn no">خیر</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text_style1">اطلاعات کیف پول شما</div>
                    <div class="table_style1">
                        <table>
                            <thead>
                            <tr>
                                <th>شماره تراکنش</th>
                                <th>مبدا</th>
                                <th>مقصد</th>
                                <th>مبلغ فاکتور</th>
                                <th>موجودی</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>علیرضا حیدری</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>محمد حسین سقطچی زنجانی</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>علیرضا حیدری</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>محمد حسین سقطچی زنجانی</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>علیرضا حیدری</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>محمد حسین سقطچی زنجانی</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>علیرضا حیدری</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>محمد حسین سقطچی زنجانی</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>علیرضا حیدری</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            <tr>
                                <td>shanilo-9754</td>
                                <td>محمد حسین سقطچی زنجانی</td>
                                <td>فروشگاه عباس و اکبر بجز محمود</td>
                                <td><span class="price">20,000</span></td>
                                <td><span class="price">20,526,000,000</span></td>
                                <td><a href="#" title="">مشاهده</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal_style1 add_cart_modal w550">
        <div class="modal_scroll flex">
            <div class="close_bg"></div>
            <div class="wrapper">
                <div class="wrapper_box">
                    <div class="close_btn"><i class="i-cancel"></i></div>
                    <div class="title_style7"><span class="title">افزودن کارت جدید</span></div>
                    <div class="text_style1">ایجاد کردن یک کیف پول جدید برای فروشگاه های انتخابی شما</div>
                    <div class="form_style2">
                        <form data-valid-form="" novalidate="novalidate">
                            <ul class="frm_step flex no_bullet">
                                <li class="frm_item flex w100 not_empty">
                                    <input type="text" class="frm_input" name="u1" placeholder="شماره شبا"
                                           data-valid-required="" aria-required="true">
                                    <div class="frm_title">شماره شبا</div>
                                </li>
                                <li class="frm_item flex w100 not_empty">
                                    <input type="text" class="frm_input" name="u2" placeholder="شماره کارت"
                                           data-valid-required="" data-valid-email="" aria-required="true">
                                    <div class="frm_title">شماره کارت</div>
                                </li>
                                <li class="frm_item flex w70 not_empty">
                                    <input type="text" class="frm_input" name="u3" placeholder="نام صاحب کارت"
                                           data-valid-required="" data-valid-email="" aria-required="true">
                                    <div class="frm_title">نام صاحب کارت</div>
                                </li>
                                <li class="frm_item flex w70 not_empty">
                                    <div class="frm_input_flex flex">
                                        <input type="text" class="frm_input" name="u4" placeholder="ماه"
                                               data-valid-required="" data-valid-email="" aria-required="true">/
                                        <input type="text" class="frm_input" name="u5" placeholder="سال"
                                               data-valid-required="" data-valid-email="" aria-required="true">
                                        <div class="frm_title"></div>
                                    </div>
                                    <div class="frm_title">انقضا کارت</div>
                                </li>
                                <li class="frm_item w100 row_flex flex">
                                    <button class="btn_style2 flex">
                                        <span class="icon"><i class="i-044-checked"></i></span>
                                        <span class="text">ثبت کیف پول جدید</span>
                                    </button>
                                    <a href="" class="dlt_btn"><i class="i-031-trash"></i>حذف کارت</a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            /////////////////////////////
            //modal style2
            $('.cart_box_style1 .item.modal_btn.cart_modal_btn ').click(function () {
                $('.modal_style1.cart_box_modal').fadeIn(300);
                $('body').css('overflow', 'hidden');
            });
            //modal style2
            $('.add_cart_btn.modal_btn ').click(function () {
                $('.modal_style1.add_cart_modal').fadeIn(300);
                $('body').css('overflow', 'hidden');
            });
            //////////////////////////////
            // delete click
            $('.box_style8 .item .dlt_btn > i').click(function () {
                $(this).parent('.dlt_btn').addClass('active');
            })
            $('.box_style8 .item .dlt_btn .short_request .btn.no').click(function () {
                $(this).parents('.dlt_btn').removeClass('active');
            })


        });//document ready
    </script>







    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

        $(document).ready(function () {

        });//document ready

    </script>

@endsection