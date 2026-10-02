@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
                <div class="container">
                    <div class="inner">
                        <div class='panel_style1 other_page_section'>
                            @include('front.partial.dashboard')
                            <div id="pjax-container" data-url="{{route('front.profile.order.index',[$type,'page'=>1])}}" class='panel_content'>
                                @include('front.partial.parts.order-header')
                                <div class="filter_style1 mb30">
                                    <ul class="step no_bullet flex">
                                        <li class="item responsive_100">
                                            <div class="select_part">
                                                <select name="shop_id" class="profile-filter" data-group="shop_id" id="">
                                                    <option value="">فروشگاه ها</option>
                                                    @foreach($shops as $index=>$shop)
                                                        <option value="{{$shop->id}}" {{$selectedShop==$shop->id?'selected':''}}>{{$shop->title}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <input type="text" value="{{$selectedId}}" class="profile-filter" data-group="id"  placeholder="شماره سفارش">
                                        </li>
                                        <li class="item">
                                            <input type="text" value="{{$selectedTrackingCode}}" class="profile-filter" data-group="tracking_code"  placeholder="شماره پیگیری تراکنش">
                                        </li>
                                    </ul>
                                </div>
                                @if($orders->count())
                                <div class="panel_table table_style2">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="w10">شماره سفارش</th>
                                            <th class="w10">فروشگاه</th>
                                            <th class="w10">خریدار</th>
                                            <th class="w10">مبلغ کل سفارش</th>
                                            <th class="w10">نوع ارسال</th>
                                            <th class="w10">وضعیت پرداخت</th>
                                            <th class="w10">وضعیت سفارش</th>
                                            <th class="w10">تاریخ سفارش</th>
                                            <th class="w10">مشاهده جزییات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $index=>$order)
                                            <tr>
                                                <td class="{{$order->user_id!=auth()->id() && !$order->seen?'shine':''}}">{{$order->id}}</td>
                                                <td>

                                                    @if($order->shop != null )
                                                        <a href="{{ $order->shop->path() != null ? $order->shop->path() : '' }}" target="_blank" class="user_info_style1 flex">
                                                            <div class="user_pic" style="background-image: url('{{$order->shop->takeImage('avatar','60/60')}}');"></div>
                                                            {{--<div class="user_name id">{{getUsersFullName($order->shop->user)}}</div>--}}
                                                            <div class="user_name id">{{$order->shop->title}}</div>
                                                        </a>
                                                    @else
                                                        <p>وجود ندارد</p>
                                                    @endIf
                                                </td>
                                                <td>
                                                    <a href="{{$order->user->path()}}" target="_blank" class="user_info_style1 flex">
                                                        <div class="user_pic" style="background-image: url('{{$order->user->takeImage('avatar','60/60','user.png')}}');"></div>
                                                        <div class="user_name id">{{getUsersFullName($order->user)}}</div>
                                                    </a>
                                                </td>
                                                <td>{{showPrice($order->total)}}</td>
                                                <td>{{$order->sendType->title}}</td>
                                                <td><div class="condition_show {{$order->payment->frontStatus->getClass()}}">{{$order->payment->front_status->getTitle()}}</div></td>
                                                <td><div class="condition_show {{$order->frontStatus->getClass()}}">{{$order->front_status->getTitle()}}</div></td>
                                                <td>{{show_persian_with_month($order->created_at)}}</td>
                                                <td><a href="{{route('front.profile.order.show',$order)}}">مشاهده</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- table_style2 -->
                                <div class="pagination_style2">
                                    {{$orders->render('vendor.pagination.dashboard')}}
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

    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection
