<li class="item">
    <div class="link">
        <a href="{{$article->path()}}" class="pic" style="background-image: url('{{$article->takeImage('main','275/200')}}');"></a>
        <a href="{{$article->user->path()}}" title="" class="user_part flex">
            <span class="user_pic" style="background-image: url('{{$article->user->takeImage('avatar','60/60','user.png')}}');"></span>
            <span class="user_id id ellipsis">{{getUsersFullName($article->user)}}</span>
        </a>
    </div>
    <a href="{{$article->path()}}" class="content_part">
        <div class="content_wrapper">
            <div class="title ellipsis">{{$article->title}}</div>
            <p class="text ellipsis">{{$article->summery}}</p>
            <div class="btn"><i class="i-search"></i></div>
        </div>
    </a>
</li>