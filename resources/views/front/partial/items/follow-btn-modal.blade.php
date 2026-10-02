
@if(inFollowingList($object))
    <div data-url="{{route("front.user-page.toggleFollow",$object)}}" class="followed in-modal btn-follow flw_btn">
        <span class="icon"><i class="i-checked"></i></span>
        <span class="text">Unfollow</span>
    </div>
@else
    <div data-url="{{route("front.user-page.toggleFollow",$object)}}" class="following in-modal btn-follow flw_btn">
        <span class="icon"><i class="i-plus-symbol"></i></span>
        <span class="text">Follow</span>
    </div>
@endif