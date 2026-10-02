@forelse($users as $index=>$user)
    <li data-id="{{$user->id}}" class="item2 share-friend flex">
        <div class="user_pic"
             style="background-image: url('{{$user->takeImage('avatar','60/60','user.png')}}');"></div>
        <div class="user_name">{{getUsersFullName($user)}}</div>
    </li>
@empty
    <li class=" flex">
        <div class="noItem_style2 flex">موردی یافت نشد!</div>
    </li>
@endforelse


