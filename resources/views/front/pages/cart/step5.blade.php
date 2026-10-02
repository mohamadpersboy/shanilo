@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="cart_page">
                <div class="container">
                    <div class="inner">

                        @include('front.partial.parts.cart-header')
                        <div class="table_style3 mt30" style="background-color: transparent;">
                            <table>
                                <thead>
                                <tr>
                                    <th class="w30">
                                        <a href="product-detail.php" target="_blank" class="product_info_style2 flex">
                                            <span class="pic" style="background-image: url('{{$cartDetail->shop->takeImage('avatar','60/60')}}');"></span>
                                            <span class="name">{{$cartDetail->shop->title}}</span>
                                        </a>
                                    </th>
                                    <th class="w20">مشخصه</th>
                                    <th class="w20">قیمت (تومان)</th>
                                    <th class="w10">تعداد</th>
                                    <th class="w20">قیمت کل (تومان)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartDetail->details as $index=>$detail)
                                    <tr>
                                        <td>
                                            <a href="{{$detail->productDetail->path()}}" target="_blank" class="product_info_style1 flex"><img src="{{$detail->productDetail->product->takeImage('main','100/50')}}" alt="">
                                                <span class="name">{{$detail->productDetail->product->title}}</span>
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $feature=$detail->productDetail->feature;
                                                $color=$detail->productDetail->color;
                                            @endphp
                                            <span class="cart-feature name">{{$feature?$feature.' ':''}}{{$color->code!='#00NANNAN'?$color->title:''}}</span>
                                        </td>
                                        <td>
                                            <span class="org_price">{{showPrice($detail->productDetail->pure_price)}}</span>
                                        </td>
                                        <td>{{$detail->count}}</td>
                                        <td><span class="total_price">{{showPrice($detail->productDetail->pure_price*$detail->count)}}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="cart_show flex">
                            <div class="price_info">
                                <ul class="step no_bullet">
                                    <li class="item flex">
                                        <span class="title">جمع کل خرید شما</span>
                                        <span class="price">{{$cartDetail->total(true)}}</span>
                                    </li>
                                    <li class="item flex">
                                        <span class="title">هزینه ارسال ، بسته بندی و بیمه سفارش</span>
                                        <span class="price">{{showPrice($cartDetail->transport_price,null,null)}}</span>
                                    </li>
                                    <li class="item flex">
                                        <span class="title">مالیات بر ارزش افزوده</span>
                                        <span class="price">{{showPrice($cartDetail->tax,null,null)}}</span>
                                    </li>
                                   {{-- <li class="item flex">
                                        <span class="title">جمع کل تخفیف</span>
                                        <span class="price">200,000,000</span>
                                    </li>--}}
                                    <li class="item flex">
                                        <span class="title">جمع کل قابل پرداخت</span>
                                        <span class="price">{{showPrice($cartDetail->total(),null,null)}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="cart_info">
                                <div class="icon fright"></div>
                                <p class="text">
                                    این بسته به {{$cartDetail->address->name}} به آدرس {{$cartDetail->address->address}} به شماره تلفن <span>{{$cartDetail->address->mobile}}</span> تحویل داده خواهد شد.
                                    محصولات سفارش داده شده توسط {{$cartDetail->sendType->title}} با هزینه {{showPrice($cartDetail->transport_price)}}  تحویل داده خواهد شد.
                                </p>
                            </div>
                        </div>
                        <div class="cart_btn_part space_between flex mb30 mt30">
                            <a href="{{route('front.cart.step6',$cartDetail)}}" title="" class="btn_style8 green"><span class="text">مرحله بعدی</span><span class="icon"><i class="i-back"></i></span></a>
                            <a href="{{route('front.cart.step4',$cartDetail)}}" title="" class="btn_style8 green"><span class="text">مرحله قبلی</span><span class="icon"><i class="i-next"></i></span></a>
                        </div>




                    </div><!-- .inner -->
                </div><!-- .container -->
        </div><!-- .user_page -->
    </section>


@endsection

@section('js')


    <script>

        $(document).ready(function () {



        });//document ready

    </script>

@endsection