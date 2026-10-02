@extends('admin.master')
@section('css')
    <link href="{{asset('assets/admin/_css/factor.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت سفارشات</p>
                    <p class="title2">جزئیات سفارش</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">

            <div class="form_style2">
                <div class="factor_style1 margint30 clearfix">
                    <div class="factor_part1">
                        <span class='print'><a href='javascript:window.print();' class='btn_style4 blue'>چاپ فاکتور<i class='icon i-printing-paper'></i></a></span>
                        <h2 class="title">فاکتور فروش</h2>

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
                                                        <i class="item_name">نام :</i>
                                                        <i class="item_val">{{__('content.site_name')}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">آدرس :</i>
                                                        <i class="item_val">{{$contact->address}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">تلفن :</i>
                                                        <i class="item_val">{{$contact->phone}}</i>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr class="info_row tright">
                                            <td class="vert_label"><div class="outer_text"><div class="inner_text">مشتری</div></div></td>
                                            <td class="info_col">
                                                <ul class="clearfix no_bullet">
                                                    <li class="info_item">
                                                        <i class="item_name">نام :</i>
                                                        <i class="item_val">{{getUsersFullName($order->user)}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">ایمیل :</i>
                                                        <i class="item_val">{{$order->user->email}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">تلفن:</i>
                                                        <i class="item_val">{{$order->user->mobile}}</i>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr class="info_row tright">
                                            <td class="vert_label"><div class="outer_text"><div class="inner_text">دریافت کننده</div></div></td>
                                            <td class="info_col">
                                                <ul class="clearfix no_bullet">
                                                    <li class="info_item">
                                                        <i class="item_name">نام :</i>
                                                        <i class="item_val">{{$order->address->full_name}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">ایمیل :</i>
                                                        <i class="item_val">{{$order->address->email}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">آدرس : </i>
                                                        <i class="item_val">{{$order->address->state->name}} - {{$order->address->city->name}} - {{$order->address->address}}</i>
                                                    </li>

                                                    <li class="info_item">
                                                        <i class="item_name">تلفن :</i>
                                                        <i class="item_val">{{$order->address->phone}} - {{$order->address->mobile}}</i>
                                                    </li>
                                                    {{--@if($order->address->latlong != null)
                                                        <li class="info_item">
                                                            <a href="https://maps.googleapis.com/maps/api/staticmap?center={{$order->address->latlong}}&markers=color:red%7Clabel:C%7C{{$order->address->latlong}}&zoom=15&size=1000x1000&key:AIzaSyDZaZOS9IPKn3EhAlGWW0O7Hf43FKaH4Yw" target="_blank"><i class="item_name">مشاهده نقشه</i></a>
                                                        </li>
                                                    @endif--}}
                                                </ul>
                                            </td>
                                        </tr>

                                        </tbody></table>
                                </td>
                                <td class="width2_5 gap"></td>
                                <td class="width35 pay_info">
                                    <table>
                                        <tbody><tr>
                                            <td class="vert_label width10"><div class="outer_text"><div class="inner_text">{{$order->payment->payType->title}}</div></div></td>
                                            <td class="width90">
                                                <p class="date"><i class="strong">تاریخ خرید :</i> {{ShowTime($order->created_at)}} - {{ShowDate($order->created_at)}}</p>
                                                <div class="factor_no">
                                                    <p class="title_style2">شماره فاکتور </p>
                                                    @php $barcode = $order->id; @endphp
                                                    <div class="barcode_img">
                                                        @php echo \Milon\Barcode\DNS1D::getBarcodeHTML($barcode, "CODABAR",1,44);  @endphp
                                                    </div>
                                                    <p class="barcode_no letter1_5">IMI-{{$order->id}}</p>
                                                </div>
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
                                <th class="width5">id</th>
                                <th class="width15 pic screen_only">{{__('content.tbl_image')}}</th>
                                <th class="width35">{{__('content.tbl_title')}}</th>
                                <th class="width35">رنگ</th>
                                <th class="width20">قیمت</th>
                                <th class="width5">تعداد</th>
                                <th class="width20">جمع</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php $i=1; @endphp
                            @foreach($order->details as $index=>$detail)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="pic screen_only"><a href="{{$detail->productDetail->path()}}" target="_blank" class="pic" style="background-image: url({{$detail->productDetail->takeImage('main','90/90')}});"></a></td>
                                    <td class="name">
                                        {{$detail->productDetail->product->title}} <br>
                                        {{$detail->productDetail->product->code}}
                                    </td>
                                    <td class="name">
                                        {{$detail->productDetail->color->title}}
                                    </td>
                                    <td class="price_unit show_money_value_with_comma">{{showPrice($detail->pure_price)}}</td>
                                    <td>{{$detail->count}}</td>
                                    <td class="price_total show_money_value_with_comma">{{showPrice($detail->pure_price*$detail->count)}}</td>
                                </tr>
                            @endforeach

                            <tr class="table_footer price no_hover screen_only">
                                <td class="price_name" colspan="6">جمع کل</td>
                                <td class="price_val ">{{showPrice($order->sum_price)}}</td>
                            </tr>
                            <tr class="table_footer price_other no_hover screen_only">
                                <td class="price_name" colspan="6">(+) هزینه ارسال </td>
                                <td class="price_val">هزینه ارسال: {{$order->send_type_price?showPrice($order->send_type_price):'رایگان'}}</td>
                            </tr>
                            <tr class="table_footer amount no_hover screen_only">
                                <td class="price_name" colspan="6">قابل پرداخت</td>
                                <td class="price_val">{{showPrice($order->payment->price)}}</td>
                            </tr>

                            <tr class="print_only table_footer_price">
                                <td colspan="6" class="outer_table">
                                    <table>
                                        <tbody><tr>
                                            <td class="price_item">جمع کل :{{showPrice($order->sum_price)}}</td>
                                            <td class="price_item other">هزینه ارسال: {{$order->send_type_price?showPrice($order->send_type_price):'رایگان'}}</td>
                                        {{--    <td class="price_item other">مالیات بر ارزش افزوده: {{showPrice($order->tax_price)}}</td>--}}
                                            <td class="price_item amount">قابل پرداخت : {{showPrice($order->payment->price)}}</td>
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

        </div>
        <div class="paper_style1 dont_show_in_print">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت سفارشات</p>
                    <p class="title2">ویرایش سفارش</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">
            {!! Form::open(['url'=>route('admin.order.update',$order),'method'=>'PATCH']) !!}
            @include('admin.specific.order.form')
            {!! Form::close() !!}
        </div>
@endsection

{{--Active Menu--}}
@section('admin.order.index','active')
{{--End Active Menu--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}