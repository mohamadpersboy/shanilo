@forelse($items as $index=>$item)
    <li class="item">
        <a href="{{$item->path()}}" class="flex link">
            <div style="background-image: url({{$item->takeImage('avatar','60/60','user.png')}});" class="pic_part"></div>
            <div class="title_part">{{$item->title}}</div>
        </a>
    </li>
    @empty
    <li class="item">
        <p class="search-no-item">هیچ موردی یافت نشد.</p>
    </li>
@endforelse

