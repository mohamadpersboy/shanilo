<div class="top_part">
    <ul class="step no_bullet flex">
        <li class="item {{$activeMenu=='index'?'active':''}}"><a href="{{route('front.timeline.index')}}" title="" class="link">following</a></li>
        <li class="item {{$activeMenu=='specialSuggestions'?'active':''}}"><a href="{{route('front.timeline.special-suggestions')}}" title="" class="link">پیشنهاد شگفت انگیز</a></li>
        <li class="item {{$activeMenu=='specialSells'?'active':''}}"><a href="{{route('front.timeline.special-sells')}}" title="" class="link">فروش ویژه</a></li>
        <li class="item {{$activeMenu=='friendsSuggestions'?'active':''}}"><a href="{{route('front.timeline.friends-suggestions')}}" title="" class="link">پیشنهادات دوستان</a></li>
        <li class="item {{$activeMenu=='articles'?'active':''}}"><a href="{{route('front.timeline.articles')}}" title="" class="link">جدیدترین مجلات</a></li>
    </ul>
</div>