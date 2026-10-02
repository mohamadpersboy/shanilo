@if(isset($slide))
    <div class="slide_item item">
        @else
            <li class="item {{$productDetail->count>0?"":"empty"}} {{isset($class)?$class:''}}">
                @endif
                <div class="box_info flex">
                    <div class="box_info_btn">
                        <div class="btn"><i class="i-more"></i></div>
                        <div class="box_info_step">
                            <ul class="step2 no_bullet">
                                @can('edit-product-owner',$productDetail->product)
                                    <li class="item2">
                                        <a href="{{ route('front.profile.product.edit',$productDetail->product->id) }}"
                                           title=""
                                           class="link2 flex">
                                            <span class="icon"><i class="i-pencil"></i></span>
                                            <span class="text">ویرایش محصول</span>
                                        </a>
                                    </li>
                                @endcan
                                <li class="item2">
                                    <a href="{{$productDetail->product->takeImage('main')}}" title=""
                                       class="link2 flex fancybox">
                                        <span class="icon"><i class="i-thin-expand-arrows"></i></span>
                                        <span class="text">بزرگنمایی تصویر</span>
                                    </a>
                                </li>
                                <li class="item2">
                                    <a href="javascript:void(0)"
                                       data-url="{{route('front.favorite.toggle',$productDetail)}}"
                                       rel="nofollow" title=""
                                       class="link2 btn-favorite {{Favorite::has($productDetail)?'active':''}} in-product flex">
                                        <span class="icon"><i class="i-048-bookmark"></i></span>
                                        <span class="text">{{Favorite::has($productDetail)?'موجود در علاقه مندی':'افزودن به علاقه مندی'}}</span>
                                    </a>
                                </li>
                                @if(auth()->check() && auth()->id()!=$productDetail->product->shop->user_id)
                                    @php
                                        $inNotifyList=auth()->user()->hasItInNotifyLists($productDetail);
                                    @endphp
                                    <li class="item2">
                                        <a href="javascript:void(0)"
                                           data-url="{{route('front.notifylist.toggle',['productDetail',$productDetail->id])}}"
                                           title="اطلاع رسانی"
                                           class="link2 {{$inNotifyList?'active':''}} flex btn-notify-list in-product">
                                            <span class="icon"><i class="i-010-bell"></i></span>
                                            <span class="text">{{$inNotifyList?'موجود در اطلاع رسانی':'اطلاع رسانی'}} </span>
                                        </a>
                                    </li>
                                @endif
                                @php
                                    $inComparisonList=Comparison::has($productDetail->product);
                                @endphp
                                <li class="item2 compare_btn">
                                    <a href="javascript:void(0)"
                                       data-url="{{route('front.comparison.toggle',$productDetail->product_id)}}"
                                       title=""
                                       class="link2 flex {{$inComparisonList?'active':''}}">
                                        <span class="icon"><i class="i-003-color"></i></span>
                                        <span class="text">{{$inComparisonList?'حذف از مقایسه':'افزودن به لیست مقایسه'}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="user_part flex has_tooltip">
                        <div class="product_store_name ellipsis"><a
                                    href="{{$productDetail->shop->path('index')}}">{{$productDetail->shop->title}}</a>
                        </div>
                        <a href="{{$productDetail->product->shop->user->path('personal')}}" class="user_pic"
                           style="background-image: url('{{$productDetail->product->shop->user->takeImage('avatar','60/60','user.png')}}');"></a>
                        <div class="tooltip_style1 loading">
                            <div class="user_name ellipsis">{{getUsersFullName($productDetail->shop->user)}}</div>
                            <div class="shop_pic"
                                 style="background-image: url('{{$productDetail->shop->takeImage('background','278/180')}}');"></div>
                            <ul class="step2 no_bullet flex">
                                @foreach($productDetail->shop->otherProductDetails($productDetail) as $index=>$otherProductDetail)
                                    <li class="item2">
                                        <a href="{{$otherProductDetail->path()}}" title="" class="link2"><span
                                                    class="other_pic"
                                                    style="background-image: url('{{$otherProductDetail->product->takeImage('main','60/60')}}');"></span></a>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{$productDetail->shop->path('products')}}" title="" class="user_btn"><i
                                        class="i-050-ellipsis"></i></a>
                        </div>
                    </div>
                </div>
                <a href="{{$productDetail->path()}}" title="" class="pic_part">
                    <div class="pic"
                         style="background-image: url('{{$productDetail->product->takeImage('main','560/290')}}');"></div>
                </a>
                <div class="content_part">
                    <a href="{{$productDetail->path()}}" title=""
                       class="name ellipsis">{{$productDetail->product->title}}</a>
                    <div class="price_style1 flex">
                        @if($productDetail->count <= 0)
                            <span class="text-danger">{!! trans('messageShop.unavailable-product') !!}</span>
                        @elseif($productDetail->discount)
                            <span class="org_price price">{{showPrice($productDetail->price,null,null)}}</span>
                            <span class="off_price price">{{showPrice($productDetail->pure_price,null,null)}}</span>
                        @else
                            <span class="off_price price">{{showPrice($productDetail->pure_price,null,null)}}</span>
                        @endif
                    </div>
                    <div class="content_bottom flex">
                        <div class="time flex">
                            <span class="icon"><i class="i-027-clock"></i></span>
                            <span class="text">{{$productDetail->product->created_at_diff}}</span>
                        </div>
                        <div class="location flex">
                            <span class="icon"><i class="i-019-placeholder"></i></span>
                            <span class="text">{{$productDetail->shop->city->name}}</span>
                        </div>
                    </div>
                    <div class="btn_part flex">
                        @if($productDetail->count)
                            <a href="{{$productDetail->path()}}" title="" class="box_btn">
                                <i class="i-009-shopping-cart"></i>
                                <span class="text">افزودن به سبد خرید</span>
                            </a>
                        @else
                            <span title="" class="box_btn"><span class="text">ناموجود</span></span>
                        @endif
                    </div>
                </div>
            @if(isset($slide))
    </div>
    @else
    </li>
@endif
