@extends('front.master')
@section('section')
    <section class="other_page">
        <div class="user_panel">
                <div class="container">
                    <div class="inner">
                        <div class='panel_style1 other_page_section'>
                            @include('front.partial.dashboard')
                            <div class='panel_content'>
                                <div class="title_style8"><span>لیست فروشگاه های من</span></div>
                                <div class="box_style5">
                                    <ul class="step flex no_bullet">
                                        <li class="item new_item">
                                            <a href="{{route('front.profile.shop.create')}}" title="" class="pic_part">
                                                <div class="pic"></div>
                                                <div class="pic_btn flex"><i class="i-search"></i><span>مشاهده</span></div>
                                            </a>
                                            <div class="box_link box_shadow_style1">
                                                <ul class="step2 no_bullet flex">

                                                </ul>
                                            </div>
                                            <a href="{{route('front.profile.shop.create')}}" class="name ellipsis" style="word-wrap: break-word;">ثبت فروشگاه جدید</a>
                                        </li>
                                        @foreach($shops as $index=>$shop)
                                            <li id="shop-{{$shop->id}}" class="item">
                                                <a href="{{$shop->path()}}" title="" class="pic_part">
                                                    <div class="pic" style="background-image: url('{{$shop->takeImage('background','278/180')}}');"></div>
                                                    <div class="pic_btn flex"><i class="i-search"></i><span>مشاهده</span></div>
                                                </a>
                                                <div class="box_link box_shadow_style1">
                                                    <ul class="step2 no_bullet flex">
                                                        <li class="item2">
                                                            <a href="{{route('front.profile.shop.edit',$shop)}}" title="" class="link2 flex">
                                                                <div class="icon"><i class="i-045-mark"></i></div>
                                                                <div class="tooltip right tooltip_style2">ویرایش فروشگاه</div>
                                                            </a>
                                                        </li>
                                                        <li class="item2">
                                                            <a href="{{$shop->path('products')}}" title="" class="link2 flex">
                                                                <div class="icon"><i class="i-041-folder"></i></div>
                                                                <div class="tooltip right tooltip_style2">مشاهده محصولات</div>
                                                            </a>
                                                        </li>
                                                        <li class="item2 share_btn">
                                                            <a href="javascript:void(0)" data-url="{{route('front.profile.shop.clients',$shop)}}" class="link2 flex  btn-clients modal_btn">
                                                                <div class="icon"><i class="i-030-user"></i></div>
                                                                <div class="tooltip right tooltip_style2">لیست مشتریان</div>
                                                            </a>
                                                        </li>
                                                        <li class="item2">
                                                            <a href="{{route('front.profile.order.index',['others','shop_id'=>$shop->id])}}" title="" class="link2 flex">
                                                                <div class="icon"><i class="i-012-list"></i></div>
                                                                <div class="tooltip right tooltip_style2">مشاهده فاکتورها</div>
                                                            </a>
                                                        </li>
                                                        <li class="item2">
                                                            <a title="" data-block="#shop-{{$shop->id}}" data-url="{{route('front.profile.shop.destroy',$shop)}}" class="link2 flex cursor-pointer btn-delete">
                                                                <div class="icon"><i class="i-031-trash"></i></div>
                                                                <div class="tooltip right tooltip_style2">حذف فروشگاه</div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="name ellipsis" style="word-wrap: break-word;">{{$shop->title}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div><!--clsoe .panel_content-->
                        </div>
                    </div><!-- .inner -->
                </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.upload-img-profile')
    @include('front.plugins.market-client-modal')
    @include('front.plugins.user-modal')
@endsection

@section('js')


    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection