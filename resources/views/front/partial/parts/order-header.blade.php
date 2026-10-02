<div class="factor_btn flex">
    <a href="{{route('front.profile.order.index','self')}}" title="" class="link {{$subActiveMenu=='self'?'active':''}}"><span class="count">{{$selfOrdersCount}}</span><span class="title">خریدهای من</span></a>
    <a href="{{route('front.profile.order.index','others')}}" title="" class="link {{$subActiveMenu=='others'?'active':''}}"><span class="count">{{$othersOrdersCount}}</span><span class="title">سفارشات فروشگاه من</span></a>
</div>