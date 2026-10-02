<li class="item">
    <a href="{{$client->path()}}" class="link flex">
        <div class="user_pic" style="background-image: url('{{$client->takeImage('avatar','90/90','user.png')}}');"></div>
        <div class="user_name ellipsis">{{getUsersFullName($client)}}</div>
    </a>
</li>
