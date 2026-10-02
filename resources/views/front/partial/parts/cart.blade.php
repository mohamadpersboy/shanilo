@if(Cart::count())
    <div class="box_style1">
        <div class="have_scroll_y scroll_style1">
            <ul class="step2 no_bullet">
                @foreach(Cart::products() as $index=>$productDetail)
                    <li class="item2">
                        <a href="{{$productDetail->path()}}" title="" class="link2 flex">
                            <div class="pic_part" style="background-image: url('{{$productDetail->product->takeImage('main','270/150')}}');"></div>
                            <span class="content_part flex">
                            <span class="name ellipsis">{{$productDetail->product->title}}({{$productDetail->color->title}})</span>
                            <span class="price">{{showPrice($productDetail->pure_price,null,null)}}</span>
                        </span>
                        </a>
                        <div class="dlt_btn btn-toggle-cart" data-url="{{route('front.cart.toggle',$productDetail)}}"><i class="i-cancel"></i></div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <a href="{{route('front.cart.step1')}}" class="btn_style1"><span>مشاهده سبد خرید</span><span
                class="price_part"><span class="title">مجموع :</span> <span class="price">{{showPrice(Cart::sumProductsPrice(),null,null)}}</span></span></a>
@else
    <div class="noItem_style1" style="display: block;">
        <span>سبد خرید شما خالی است.</span>
    </div>
@endif
