@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            <div class="sel_product_unit flex">
                                <ul class="step no_bullet flex user-order-wizard">
                                    <!-- items has class ===== "checked" , "error" , "active" -->
                                    @if($order->status==0)
                                        <li class="item error"><a href="javascript:void(0)" title="" class="link">کنسل
                                                شد</a></li>
                                    @else
                                        @for($i=1;$i<=5;$i++)
                                            <li class="item {{$order->status==$i || $order->status>$i?'checked':''}} {{$order->status+1==$i?'active':''}}">
                                                <a href="{{$order->canUpdateStatus($i)?route('front.profile.order.update-status',$order):'#'}}"
                                                   data-status="{{$i}}" title=""
                                                   class="link btn-update-order-status">{{\App\Models\Specific\Order::statuses()[$i]->getTitle()}}</a>
                                            </li>
                                        @endfor
                                    @endif

                                </ul>
                                <div class="action_btn flex">
                                    @if($order->canUpdateStatus(0) && $order->status!=0)
                                        <a href="{{route('front.profile.order.update-status',$order)}}" data-status="0"
                                           class="cancel_btn btn-update-order-status">لغو سفارش</a>
                                    @endif
                                </div>
                            </div>
                            <div class="factor_style1 clearfix">
                                <div class="factor_part1 flex">
                                    <div class="btn_part_style1 flex">
                                        <a href="javascript:window.print();" class="btn_style7 flex">
                                            <div class="text z_index2">چاپ جزییات فاکتور</div>
                                            <div class="icon"><i class="i-power"></i></div>
                                        </a>
                                    </div>
                                    <h2 class="title">صورت حساب فـروش کـالا</h2>
                                    @if($order->user_id==auth()->id() && $order->status>=2 &&  !$order->isReportedByAuth())
                                        <div data-url="{{route('front.report.create',['order',$order->id])}}"
                                             class="btn_part_style1 btn-create-report modal_btn flex">
                                            <div class="btn_style7 red flex">
                                                <div class="text z_index2">ثبت نارضایتی کالا</div>
                                                <div class="icon"><i class="i-chat"></i></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{--<div class="factor_part1 flex">
                                    <h2 class="title">صورت حساب فـروش کـالا</h2>
                                </div>--}}
                                <div class="factor_part2 table_style3">
                                    <table class="table1">
                                        <tbody>
                                        <tr class="flex">
                                            <td class="width65 user_info">
                                                <table>
                                                    <tbody>
                                                    <tr class="info_row tright">
                                                        <td class="vert_label">
                                                            <div class="outer_text">
                                                                <div class="inner_text">فروشنده</div>
                                                            </div>
                                                        </td>
                                                        <td class="info_col">
                                                            <ul class="clearfix no_bullet row_100 tright">
                                                                <li class="info_item">
                                                                    <i class="item_name">فروشنده :</i>
                                                                    <i class="item_val">{{$order->shop->title}}</i>
                                                                </li>

                                                                <li class="info_item">
                                                                    <i class="item_name">نشانی :</i>
                                                                    <i class="item_val">{{$order->shop->address}}</i>
                                                                </li>

                                                                <li class="info_item">
                                                                    <i class="item_name">تلفن تماس :</i>
                                                                    <i class="item_val">{{$order->shop->phone}}</i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr class="info_row tright">
                                                        <td class="vert_label">
                                                            <div class="outer_text">
                                                                <div class="inner_text">خریــدار</div>
                                                            </div>
                                                        </td>
                                                        <td class="info_col">
                                                            <ul class="clearfix no_bullet tright">
                                                                <li class="info_item">
                                                                    <i class="item_name">خریدار :</i>
                                                                    <i class="item_val">{{getUsersFullName($order->user)}}</i>
                                                                </li>
                                                                <li class="info_item">
                                                                    <i class="item_name">تحویل به :</i>
                                                                    <i class="item_val">{{$order->address->name}}</i>
                                                                </li>
                                                                <li class="info_item">
                                                                    <i class="item_name">ایمیل :</i>
                                                                    <i class="item_val">{{$order->user->email}}</i>
                                                                </li>

                                                                <li class="info_item">
                                                                    <i class="item_name">نشانی : </i>
                                                                    <i class="item_val">{{$order->address->address}}</i>
                                                                </li>

                                                                <li class="info_item">
                                                                    <i class="item_name">تلفن تماس :</i>
                                                                    <i class="item_val">{{$order->address->phone}}
                                                                        - {{$order->address->mobile}}</i>
                                                                </li>

                                                                <li class="info_item">
                                                                    <i class="item_name">کد پستی :</i>
                                                                    <i class="item_val">{{$order->address->zip_code}}</i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="width2_5 gap"></td>
                                            <td class="width35 pay_info">
                                                <table>
                                                    <tbody>
                                                    <tr>
                                                        <td class="vert_label width10">
                                                            <div class="outer_text">
                                                                <div class="inner_text">پرداخت اینترنتی
                                                                    - {{$order->payment->payType->title}}</div>
                                                            </div>
                                                        </td>
                                                        <td class="width90">
                                                            <p class="date"><i class="strong">تاریخ ثبت
                                                                    :</i>{{ShowTime($order->created_at)}}
                                                                - {{ShowDate($order->created_at)}}  </p>
                                                            <div class="factor_no">
                                                                <p class="">شماره فاکتور </p>
                                                                <img class="barcode_img" src="_images/bg/barcode.png">
                                                                <p class="barcode_no letter1_5">{{$order->id}}</p>
                                                            </div>
                                                            <hr class="hr_style2 marginb10">
                                                            <div class="track_no">
                                                                <p class="">شماره پیگیری </p>
                                                                <img class="barcode_img" src="_images/bg/barcode_2.png">
                                                                <p class="barcode_no letter1_5">{{$order->payment->ref_id}}</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="clear"></div>

                                <div class="factor_part3 clearfix table_style2">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="w10 width5">ردیف</th>
                                            <th class="w10 width15 pic screen_only">تصویر کالا</th>
                                            <th class="w30 width35">شرح کالا</th>
                                            <th class="w15width20">قیمت واحد - تومان</th>
                                            <th class="width5">تعداد</th>
                                            <th class="w20 width20">قیمت نهایی - تومان</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->details as $index=>$detail)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td class="pic screen_only"><a href="{{$detail->productDetail->path()}}"
                                                                               target="_blank" class="pic"
                                                                               style="background-image: url('{{$detail->productDetail->product->takeImage('main','100/100')}}');"></a>
                                                </td>
                                                <td class="name">{{$detail->productDetail->product->title}}
                                                    <hr class="hr_style1">
                                                    <ul class="pro_option no_bullet">
                                                        <li class="opt_item">
                                                            <ul style="list-style: none;">
                                                                @foreach($detail->properties as $i=>$property)
                                                                    <li>{{$i}} : {{$property}}</li>
                                                                @endforeach
                                                            </ul>
                                                            <hr class="hr_style1">
                                                        </li>
                                                        @php
                                                            $color=$detail->productDetail->color;
                                                            $feature=$detail->productDetail->feature;
                                                        @endphp
                                                        <li class="opt_item">{{$feature?$feature.' ':''}}{{$color->code!='#00NANNAN'?$color->title:''}}</li>
                                                    </ul>
                                                </td>
                                                <td class="price_unit">{{showPrice($detail->pure_price,null,null)}}</td>
                                                <td>{{$detail->count}}</td>
                                                <td class="price_total">{{showPrice($detail->count*$detail->pure_price,null,null)}}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="table_footer price no_hover screen_only">
                                            <td rowspan="4" class="factor_text_label">
                                                <div class="outer_text">
                                                    <div class="inner_text">توضیحات</div>
                                                </div>
                                            </td>
                                            <td colspan="2" rowspan="4" class="tright factor_text">
                                                نحوه ارسال سفارش : {{$order->sendType->title}}<br>
                                                <br>
                                            </td>
                                            <td class="price_name" colspan="2">جمع مبالغ</td>
                                            <td class="price_val ">{{showPrice($order->totalProductsPrice)}}</td>
                                        </tr>
                                        <tr class="table_footer price_other no_hover screen_only">
                                            <td class="price_name" colspan="2">(+) هزینه ارسال</td>
                                            <td class="price_val">{{showPrice($order->transport_price)}}</td>
                                        </tr>
                                        <tr class="table_footer price_other no_hover screen_only">
                                            <td class="price_name" colspan="2">(+) مالیات و ارزش افزوده</td>
                                            <td class="price_val">{{showPrice($order->tax)}}</td>
                                        </tr>
                                        <tr class="table_footer amount no_hover screen_only">
                                            <td class="price_name" colspan="2">مبلغ پرداختی</td>
                                            <td class="price_val">{{showPrice($order->total)}}</td>
                                        </tr>

                                        <tr class="print_only table_footer_price">
                                            <td colspan="5" class="outer_table">
                                                <table>
                                                    <tbody>
                                                    <tr>
                                                        <td class="price_item">جمع مبالغ : <i
                                                                    class="price">1,719,500</i></td>

                                                        <td class="price_item other"> (+) هزینه ارسال : <i
                                                                    class="price">0</i></td>

                                                        <!--<td class='price_item discount'> (-) تخفیف هدایا : <i class='price'>0</i></td>-->

                                                        <td class="price_item amount">مبلغ پرداختی : <i class="price">1,719,500</i>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="factor_part4">
                                    <ul class="clearfix no_bullet">
                                        <li class="sign_item">
                                            <p class="sign_item_name">مهر و امضا فـروشـنده</p>
                                        </li>
                                        <li class="sign_item">
                                            <p class="sign_item_name">تاریـخ و زمـان تحویـل</p>
                                        </li>
                                        <li class="sign_item">
                                            <p class="sign_item_name">مهر و امضا خــریــدار</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>
    </div>
    @include('front.plugins.report-modal')
    @include('front.partial.upload-img-profile')

@endsection
