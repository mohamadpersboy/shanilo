@extends('front.master')

@section('section')
    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            <div class="product_edit flex">
                                <div class="form_style2">
                                    {!! Form::model($shop,[
                                       'url'=>route('front.profile.shop.update',$shop),
                                       'data-ajax',
                                       'data-type'=>'json',
                                       'method'=>'patch',
                                       'data-on-error'=>'inline-message',
                                       'data-on-success'=>'alert-message',

                                   ]) !!}
                                    {!! Form::hidden('id',$shop->id) !!}
                                    @include('front.pages.profile.shop.form')
                                    {!! Form::close() !!}
                                </div>
                                <div class="product_info">
                                    <div class="title_style8"><span>اطلاعات فروشگاه</span></div>
                                    <ul class="step no_bullet">
                                        <li class="item flex">
                                            <div class="rate_style1 pointer_event">
                                                @include('front.partial.items.rate',['rate'=>$shop->rate])
                                                <div class="rate_text">امتیاز ثبت شده میان
                                                    <spna>{{$shop->comments()->parents()->count()}}</spna>
                                                    نفر
                                                </div>
                                            </div>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-002-window"></i></span>
                                            <span class="title">تعداد محصولات</span>
                                            <span class="content">{{$shop->products->count()}}</span>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-009-shopping-cart"></i></span>
                                            <span class="title">تعداد فروخته شده</span>
                                            <span class="content">{{$shop->products()->sum('sell_count')}}</span>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-016-bubble"></i></span>
                                            <span class="title">تعداد نظرات</span>
                                            <span class="content">{{$shop->comments()->count()}}</span>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-027-clock"></i></span>
                                            <span class="title">تاریخ ثبت فروشگاه</span>
                                            <span class="content">{{ShowDate($shop->created_at)}}</span>
                                        </li>
                                    </ul>
                                    <hr class="hr_style1"></br>
                                    <div class="cart_btn_part flex">
                                        <a href="javascript:void(0)" title="" data-url="{{route('front.profile.shop.get-covered-cities',$shop)}}" class="btn_style8 green modal_btn btn-covered-cities">
                                            <span class="text">شهر های تحت پوشش</span>
                                        </a>
                                        <a href="javascript:void(0)" title="" data-url="{{route('front.profile.shop.get-covered-states',$shop)}}"  class="btn_style8 green modal_btn btn-covered-states">
                                            <span class="text">استانهای تحت پوشش</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.upload-img-profile')
    @include('front.plugins.market-client-modal')
    @include('front.plugins.shop-states-modal')
    @include('front.plugins.shop-cities-modal')

@endsection

@section('js')

    @include('front.plugins.city-select-2')
    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection