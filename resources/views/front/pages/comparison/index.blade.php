@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="comparison_page">
                    <div class="contact_part1">
                        <div class="content_part flex">
                            <div class="title flex">مقایسه محصول</div>
                            <div class="content">
                                کاربر گرامی ؛ مقایسه ی بین کالاهای یک فروشگاه و یا محصولات چند فروشگاه مختلف با یکدیگر این امکان را فراهم نموده است تا بتوانید ویژگی ها و مشخصات کالا های مختلف را در کنار یکدیگر مشاهده و بررسی نموده و تجربه بهترین و دقیق ترین انتخاب را از بین کالا ها و فروشگاه های مختلف داشته باشید .
                            </div>
                        </div>
                    </div>
                    <div class="compare_table table_style2">
                    @if(Comparison::count())
                    <table>
                        <thead>
                        <tr>
                            <th></th>

                            @foreach(Comparison::details() as $index=>$detail)
                                <th>
                                    <a href="{{$detail->product->path()}}" title="" class="head_link flex">
                                        <img src="{{$detail->product->takeImage('main','270/150')}}" alt="">
                                        <span class="compare_name">{{$detail->product->title}}</span>
                                    </a>
                                    <div class="compare_price">
                                        <div class="price_style1 flex">
                                            @if($detail->product->indexedProduct->discount)
                                                <span class="org_price price">{{showPrice($detail->product->indexedProduct->price,null,null)}}</span>
                                                <span class="off_price price">{{showPrice($detail->product->indexedProduct->pure_price,null,null)}}</span>
                                            @else
                                                <span class="off_price price">{{showPrice($detail->product->indexedProduct->pure_price,null,null)}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>نام فروشگاه</td>
                            @foreach(Comparison::details() as $index=>$detail)
                                <td><a href="{{$detail->product->shop->path()}}">{{$detail->product->shop->title}}</a></td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>امتیاز کاربران</td>
                            @foreach(Comparison::details() as $index=>$detail)
                                <td>{{(float)$detail->product->rate}}</td>
                            @endforeach
                        </tr>
                        @php
                        $productCategoryTechnicalSpecifications=Comparison::details()->first()->product->productCategoryTechnicalSpecifications;
                        @endphp
                        @foreach($productCategoryTechnicalSpecifications as $index=>$productCategoryTechnicalSpecification)
                            <tr>
                                <td>{{$productCategoryTechnicalSpecification->technicalSpecification->title}}</td>
                                @foreach(Comparison::details() as $index=>$detail)
                                    <td>{{$detail->product->productCategoryTechnicalSpecifications()->where('product_category_technical_specifications.id',$productCategoryTechnicalSpecification->id)->first()->pivot->value}}</td>
                                @endforeach
                            </tr>
                        @endforeach

                        <tr>
                            <td>
                                <div class="compare_icon tcenter"><i class="i-list"></i> </div>
                            </td>
                            @foreach(Comparison::details() as $index=>$detail)
                                <td class="creator_part ">
                                    <div class="pic_part">
                                        <div class="market_part">
                                            <a href="{{$detail->product->shop->path()}}" title="" class="link flex">
                                                <div class="pic" style="background-image: url('{{$detail->product->shop->takeImage('avatar','60/60')}}');"></div>
                                                <div class="name user_name_style1 ">{{$detail->product->shop->title}}</div>
                                            </a>
                                        </div>
                                        <div class="user_part">
                                            <a href="{{$detail->product->shop->user->path()}}" title="" class="link flex">
                                                <div class="pic" style="background-image: url('{{$detail->product->shop->user->takeImage('avatar','60/60')}}');"></div>
                                                <div class="name user_name_style1 {{$detail->product->shop->user->confirmed_by_admin?'checked':''}}">{{getUsersFullName($detail->product->shop->user)}}</div>
                                            </a>
                                        </div>
                                    </div>
                                    {{--<a href="{{$detail->product->path()}}" class="btn_style6">افزودن به سبد خرید</a>--}}
                                    <a href="{{$detail->product->path()}}" class="btn_style2  flex z_index4">
                                        <span class="icon"><i class="i-009-shopping-cart"></i></span>
                                        <span class="text">افزودن به سبد خرید</span>
                                    </a>
                                </td>
                            @endforeach

                        </tr>
                        </tbody>
                    </table>
                    @else
                        <div class="noItem_style2 flex">موردی یافت نشد!</div>
                    @endif
                </div>
                </div><!-- comparison_page -->
            </div><!-- inner -->
        </div><!-- container -->
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {
        });//document ready

    </script>

@endsection
