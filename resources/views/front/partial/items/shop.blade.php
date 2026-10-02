<div class="slide_item">
    <div class="pic_part">
        <div class="blur_pic"
             style="background-image: url('{{$shop->takeImage('background','350/160')}}');"></div>
        <a href="{{$shop->path()}}" title="" class="pic"
           style="background-image: url('{{$shop->takeImage('background','350/160')}}');"></a>
    </div>
    @if(canFollowOrBlock($shop))
        @php
            $inFollowList=inFollowingList($shop);
        @endphp
        <div class="follow_part flex">
            <div data-url="{{route('front.shop-page.toggleFollow',$shop)}}"
                 class="follow_btn btn-follow {{$inFollowList?'red':'green'}}">
                <span class="z_index2">{{$inFollowList?'unfollow':'follow'}}</span>
            </div><!-- give it this class = unfollow -->
            <div class="follow_Show flex"><span class="text">followers</span><span
                        id="shop-followers-{{$shop->id}}"
                        class="count">{{$shop->followers_count}}</span></div>
        </div>
    @else
        <div class="follow_part flex">
            <div class="follow_btn">
                <span class="z_index2" style="color:gray;">-</span>
            </div><!-- give it this class = unfollow -->
            <div class="follow_Show flex"><span class="text">followers</span><span
                        id="shop-followers-{{$shop->id}}"
                        class="count">{{$shop->followers_count}}</span></div>
        </div>
    @endif
    <div class="box_rate">
        <div class='rate_style1 pointer_event'>
            @include('front.partial.items.rate',['rate'=>$shop->rate])
        </div><!-- rate_style1 -->
    </div>
    <div class="content_part z_index3 flex">
        <div class="user_pic"
             style="background-image: url('{{$shop->user->takeImage('avatar','60/60','user.png')}}');"></div>
        <div class="content flex">
            <a href="{{$shop->path()}}" title=""
               class="store_name ellipsis">{{$shop->title}}</a>
            <div class="user_name"><span class="title">توسط</span> : <a
                        href="{{$shop->user->path()}}" title=""
                        class="user_name">{{getUsersFullName($shop->user)}}</a></div>
        </div>
    </div>
</div>