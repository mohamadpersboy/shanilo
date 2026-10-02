@extends('admin.master')
@section('css')
    <link href="{{asset('assets/admin/_css/factor.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')

    @if($payment)

        <div class="paper_style1">
            <div class='title_style1'>
                <p class='title1'> جزئیات فاکتور  <i class='ltr ' style='display:inline-block;'>{{$payment->factor->title}}</i></p>
                <p class='title2'>جزئیات فاکتور مربوطه را در این بخش می توانید مشاهده نمائید</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <div class="form_style2">
                <div class="factor_style1 margint30 clearfix">
                    <div class="factor_part1">
                        <span class='print'><a href='javascript:window.print();' class='btn_style4 blue'>چاپ صورت حساب<i class='icon i-printing-paper'></i></a></span>
                        @if($payment->pay_subject == 1)
                            <h2 class="title">صورت حساب فـروش کـالا</h2>
                        @else
                            <h2 class="title">صورت حساب ارائه خدمات</h2>
                        @endif
                        <span class="logo" style="background-image: url({{asset('assets/front/_images/logo/footer_logo.jpg')}});"></span>
                    </div>

                    <div class="factor_part2">
                        <table class="table1">
                            <tbody><tr>
                                <td class="width65 user_info">
                                    <table>
                                        <tbody><tr class="info_row tright">
                                            <td class="vert_label"><div class="outer_text"><div class="inner_text">فروشنده</div></div></td>
                                            <td class="info_col">
                                                <ul class="clearfix no_bullet">
                                                    <li class="info_item">
                                                        <i class="item_name">فروشنده :</i>
                                                        <i class="item_val">{{__('content.site_name')}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">نشانی :</i>
                                                        <i class="item_val">{{mainSetting('address')}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">تلفن تماس :</i>
                                                        <i class="item_val">{{mainSetting('tel')}}</i>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr class="info_row tright">
                                            <td class="vert_label"><div class="outer_text"><div class="inner_text">خریــدار</div></div></td>
                                            <td class="info_col">
                                                <ul class="clearfix no_bullet">
                                                    <li class="info_item">
                                                        <i class="item_name">خریدار :</i>
                                                        <i class="item_val">{{$payment->user->fullName()}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">ایمیل :</i>
                                                        <i class="item_val">{{$payment->user->email}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">تلفن تماس :</i>
                                                        <i class="item_val"> @if($payment->user->tel != null) {{$payment->user->tel}} - @endif {{$payment->user->mobile}}</i>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr class="info_row tright">
                                            <td class="vert_label"><div class="outer_text"><div class="inner_text">ارسال شود به</div></div></td>
                                            <td class="info_col">
                                                <ul class="clearfix no_bullet">
                                                    <li class="info_item">
                                                        <i class="item_name">نام :</i>
                                                        <i class="item_val">{{$payment->factor->address->name}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">ایمیل :</i>
                                                        <i class="item_val">{{$payment->factor->address->email}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">نشانی : </i>
                                                        <i class="item_val">{{$payment->factor->address->state->name}} - {{$payment->factor->address->city->name}} - {{$payment->factor->address->address}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">تلفن تماس :</i>
                                                        <i class="item_val">{{$payment->factor->address->tel}} - {{$payment->factor->address->mobile}}</i>
                                                    </li>
                                                    @if($payment->factor->address->latlong != null)
                                                        <li class="info_item">
                                                            <a href="https://maps.googleapis.com/maps/api/staticmap?center={{$payment->factor->address->latlong}}&markers=color:red%7Clabel:C%7C{{$payment->factor->address->latlong}}&zoom=15&size=1000x1000&key:AIzaSyDZaZOS9IPKn3EhAlGWW0O7Hf43FKaH4Yw" target="_blank"><i class="item_name">مشاهده نقشه</i></a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>

                                        </tbody></table>
                                </td>
                                <td class="width2_5 gap"></td>
                                <td class="width35 pay_info">
                                    <table>
                                        <tbody><tr>
                                            <td class="vert_label width10"><div class="outer_text"><div class="inner_text">{{$payment->pay_type_relation->title}}</div></div></td>
                                            <td class="width90">
                                                <p class="date"><i class="strong">تاریخ ثبت :</i> {{ShowTime($payment->created_at)}} - {{ShowDate($payment->created_at)}}</p>
                                                <div class="factor_no">
                                                    <p class="title_style2">شماره فاکتور </p>
                                                    @php $barcode = str_replace('ARD-','',$payment->factor->title); @endphp
                                                    <div class="barcode_img">
                                                        @php echo \Milon\Barcode\DNS1D::getBarcodeHTML($barcode, "CODABAR",1,44);  @endphp
                                                    </div>
                                                    <p class="barcode_no letter1_5">{{$payment->factor->title}}</p>
                                                </div>
                                                @if($payment->tracking_code != null)
                                                    <br>
                                                    <div class='track_no'>
                                                        <p class='title_style2'>شماره پیگیری </p>
                                                        @php $barcode = str_replace('','',$payment->tracking_code); @endphp
                                                        <div class="barcode_img">
                                                            @php echo \Milon\Barcode\DNS1D::getBarcodeHTML($barcode, "CODABAR",1,44);  @endphp
                                                        </div>
                                                        <p class="barcode_no letter1_5">{{$payment->tracking_code}}</p>
                                                    </div>
                                                @else
                                                    <br><p class='title_style2'>نوع پرداخت</p>
                                                    <i class='cl_blue pay_type'>{{$payment->pay_type_relation->title}}</i>
                                                @endif

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                            </tbody></table>
                    </div>

                    <div class="clear marginb30"></div>

                    <div class="factor_part3 clearfix table_style1">
                        <table>
                            <thead>
                            <tr>
                                <th class="width5">ردیف</th>
                                <th class="width15 pic screen_only">تصویر کالا</th>
                                <th class="width35">شرح کالا</th>
                                <th class="width20">قیمت واحد  - تومان</th>
                                <th class="width5">تعداد</th>
                                <th class="width20">قیمت نهایی  - تومان</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php $i=1; @endphp
                            @foreach($payment->factor->orders as $order)
                                @php $cart = $order->model_name::find($order->model_id); @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td class="pic screen_only"><a href="{{route('front.product.show',$cart->id)}}" target="_blank" class="pic" style="background-image: url({{$cart->takeimage()}});"></a></td>
                                    <td class="name">
                                        {{$order->title}}
                                    </td>
                                    <td class="price_unit show_money_value_with_comma">{{$order->price}}</td>
                                    <td>{{$order->quantity}}</td>
                                    <td class="price_total show_money_value_with_comma">{{$order->price*$order->quantity}}</td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach

                            <tr class="table_footer price no_hover screen_only">
                                <td rowspan="4" class="factor_text_label">
                                    <div class="outer_text">
                                        <div class="inner_text">توضیحات</div>
                                    </div>
                                </td>
                                @if($payment->factor->log != null)
                                    <td colspan="2" rowspan="4" class="tright factor_text">{{$payment->factor->log}}</td>
                                @else
                                    <td colspan="2" rowspan="4" class="tright factor_text">توضیحی ثبت نشده است.</td>
                                @endif
                                <td class="price_name" colspan="2">جمع مبالغ</td>
                                <td class="price_val "><i class="show_money_value_with_comma">{{$payment->factor->price}}</i> تومان</td>
                            </tr>
                            <tr class="table_footer price_other no_hover screen_only">
                                <td class="price_name" colspan="2">(+) هزینه ارسال </td>
                                @if($payment->factor->send_type_price == null || $payment->factor->send_type_price == 0)
                                    <td class="price_val">رایگان</td>
                                @else
                                    <td class="price_val"><i class="show_money_value_with_comma">{{$payment->factor->send_type_price}}</i> تومان</td>
                                @endif
                            </tr>
                            @if($payment->factor->discount != null || $payment->factor->discount != 0)
                                <tr class='table_footer discount no_hover screen_only'>
                                    <td class='price_name' colspan='2'>(-) تخفیف فاکتور </td>
                                    <td class='price_val'><i class="show_money_value_with_comma">{{$payment->factor->discount}}</i> تومان</td>
                                </tr>
                            @endif
                            <tr class="table_footer amount no_hover screen_only">
                                <td class="price_name" colspan="2">مبلغ پرداختی</td>
                                <td class="price_val"><i class="show_money_value_with_comma">{{$payment->factor->price_after_discount}}</i> تومان</td>
                            </tr>

                            <tr class="print_only table_footer_price">
                                <td colspan="5" class="outer_table">
                                    <table>
                                        <tbody><tr>
                                            <td class="price_item">جمع مبالغ : <i class="price"><i class="show_money_value_with_comma">{{$payment->factor->price}}</i> تومان</i></td>

                                            @if($payment->factor->send_type_price == null || $payment->factor->send_type_price == 0)
                                                <td class="price_item other"> (+) هزینه ارسال : <i class="price">رایگان</i></td>
                                            @else
                                                <td class="price_item other"> (+) هزینه ارسال : <i class="price"><i class="show_money_value_with_comma">{{$payment->factor->send_type_price}}</i> تومان</i></td>
                                            @endif

                                            @if($payment->factor->discount != null || $payment->factor->discount != 0)
                                                <td class='price_item discount'> (-) تخفیف : <i class='price'><i class="show_money_value_with_comma">{{$payment->factor->discount}}</i> تومان</i></td>
                                            @endif

                                            <td class="price_item amount">مبلغ پرداختی : <i class="price"><i class="show_money_value_with_comma">{{$payment->factor->price_after_discount}}</i> تومان</i></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!--factor_style1-->
            </div>

            <div class="form_style2 dont_show_in_print">
                <form method="post" action="{{route('admin.factor.update',$payment->factor->id)}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class='btn_group_style2 tcenter confstat_wrapper'>
                        <hr class='hr_style1 margint20 marginb10' />
                        <ul class='list clearfix'>

                            <li class='item width31 fright'>
                                <label class='checkradio_style1 noselect cl_blue'><input type='radio' name='visited' value='1' @if($payment->factor->visited == 1) checked @endif/><span class='box'></span>پیگیری نشده</label>
                            </li>

                            <li class='item width31 fright'>
                                <label class='checkradio_style1 noselect cl_green2'><input type='radio' name='visited' value='2' @if($payment->factor->visited == 2) checked @endif><span class='box'></span>پیگیری شده</label>
                            </li>

                            <li class='item width31 fright'>
                                <label class='checkradio_style1 noselect cl_red'><input type='radio' name='visited' value='3' @if($payment->factor->visited == 3) checked @endif/><span class='box'></span>لـــغو شـده</label>
                            </li>
                        </ul>

                        <hr class='hr_style1 margint10 marginb10' />

                        <ul class='list clearfix margin_auto'>
                            <li class='item width31 fright'>
                                <label class='checkradio_style1 noselect cl_red'><input type='radio' name='send_status' value='1' @if($payment->factor->send_status == 1) checked @endif/><span class='box'></span>ارسال نشده</label>
                            </li>

                            <li class='item width31 fright'>
                                <label class='checkradio_style1 noselect cl_blue'><input type='radio' name='send_status' value='2' @if($payment->factor->send_status == 2) checked @endif><span class='box'></span>ارســال شـده </label>
                            </li>

                            <li class='item width31 fright'>
                                <label class='checkradio_style1 noselect cl_green2'><input type='radio' name='send_status' value='3' @if($payment->factor->send_status == 3) checked @endif/><span class='box'></span>تحـویل شده</label>
                            </li>

                        </ul>

                        <hr class='hr_style1 margint10 marginb10' />

                        @if($payment->pay_type == 2)
                            <ul class='list clearfix margin_auto'>
                                <li class='item width31 fright'>
                                    <label class='checkradio_style1 noselect cl_blue'><input type='radio' name='pay_status' value='1' @if($payment->pay_status == 1) checked @endif><span class='box'></span>در انتظار پرداخت</label>
                                </li>

                                <li class='item width31 fright'>
                                    <label class='checkradio_style1 noselect cl_green2'><input type='radio' name='pay_status' value='2' @if($payment->pay_status == 2) checked @endif/><span class='box'></span>پرداخت و تسویه شد</label>
                                </li>

                                <li class='item width31 fright'>
                                    <label class='checkradio_style1 noselect cl_red'><input type='radio' name='pay_status' value='3' @if($payment->pay_status == 3) checked @endif/><span class='box'></span>پرداخت نشد</label>
                                </li>

                            </ul>
                        @endif

                        <hr class='hr_style1 margint10 marginb20' />

                        <ul class="list clearfix">
                            <li class="item width100 {{__('content.float')}} editor_style">
                                <div class="item_inner">
                                    <textarea name="log" class="autosize" placeholder="توضیحات خود را برای این فاکتور ثبت نمائید...">{{$payment->factor->log}}</textarea>
                                </div>
                            </li>
                        </ul>

                        <div class="btn_group_style1">
                            <hr class="hr_style1 marginb20 margint20">
                            <ul class="list clearfix">
                                <li class="item {{__('content.float')}}">
                                    <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                                </li>
                                <li class="item {{__('content.float')}}">
                                    <a href="{{route('admin.factor.index')}}" class="btn_style2">بازگشت به لیست</a>
                                </li>
                            </ul>
                        </div>
                    </div><!--confstat_wrapper-->
                </form>
            </div>

        </div>

        {{-- <div class="paper_style1 dont_show_in_print">
            <div class="title_style1">
                <p class="title1">اطلاع رسانی به کاربر</p>
                <p class="title2">با استفاده از این بخش می توانید به کاربر مربوطه اطلاع رسانی نمائید</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.sent_message.store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="to" value="{{$payment->user->id}}">
                <div class="form_style2">
                    <ul class="list clearfix">

                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">عنوان پیام:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{ old('title') }}">
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">متن پیام<i class="required_style1">*</i></p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="message">{{ old('message') }}</textarea>
                            </div>
                        </li>

                    </ul>

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="ارسال پیام" class="btn_style2 green">
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div> --}}
    @endif

@endsection

@section('PageHeading',__('content.management_factors'))

{{--Active Menu--}}
@section('admin.factor.index','active')
{{--End Active Menu--}}