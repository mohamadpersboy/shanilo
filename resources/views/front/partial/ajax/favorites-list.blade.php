@if(Favorite::count())
    <div class="box_style1">
        <div class="have_scroll_y scroll_style1">
            <ul class="step2 no_bullet">
                @foreach(Favorite::details() as $index=>$detail)
                    <li id="favorite-item-{{$detail->id}}" class="item2">
                        <a href="{{$detail->productDetail->path()}}" title="" class="link2 flex">
                            <div class="pic_part" style="background-image: url('{{$detail->productDetail->product->takeImage('main','100/100')}}');"></div>
                            <span class="content_part flex">
                                <span class="name ellipsis">{{$detail->productDetail->product->title}}</span>
                                <span class="price">{{showPrice($detail->productDetail->pure_price,null,null)}}</span>
                            </span>
                        </a>
                        <div class="dlt_btn btn-delete" data-block="#favorite-item-{{$detail->id}}" data-url="{{route('front.favorite.destroy',$detail->productDetail)}}"><i class="i-cancel"></i></div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@else
    <div class="noItem_style1 type2">
        <span>محصولی در علاقه مندی ها شما وجود ندارد.</span>
    </div>
@endif