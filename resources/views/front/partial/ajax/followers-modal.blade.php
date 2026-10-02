@if($objects->count())
@foreach($objects as $index=>$object)
    <li class="item">
        <div class="link flex">
            @if(isUserInstance($object))
            <a href="{{$object->path('personal')}}" class="user_part flex">
                <div class="user_pic" style="background-image: url('{{$object->takeImage('avatar','60/60','user.png')}}');"></div>
                <div class="user_name ellipsis">{{getUsersFullName($object)}}</div>
            </a>
            @else
                <a href="{{$object->path('index')}}" class="user_part flex">
                    <div class="user_pic" style="background-image: url('{{$object->takeImage('avatar','60/60')}}');"></div>
                    <div class="user_name ellipsis">{{$object->title}}</div>
                </a>
            @endif
            @if(canFollowOrBlock($object))
                <div class="follow_part flex">
                    @include('front.partial.items.follow-btn-modal')
                </div>
            @endif
        </div>
    </li>
@endforeach
@else
    <li class="item">
        <div class="noItem_style2 flex">موردی یافت نشد!</div>
    </li>
@endif
