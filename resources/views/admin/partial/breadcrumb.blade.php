@if(isset($items))
<div class='breadcrumb_style1'>
    <ul class='list'>
        <li class='item'><a href="{{route('admin.home.index')}}" class='link'>{{__('content.home_page')}}</a></li>
        @php $lastElement = end($items); @endphp
        @foreach($items as $item)
            <li class="item @if($item == $lastElement) active @endif"><a class="@if($item != $lastElement) link @else ellipsis display-inline-block @endif" @if($item != $lastElement) href="{{$item['link']}}" @endif title="{{$item['title']}}">{{$item['title']}}</a></li>
        @endforeach
    </ul>
</div><!--breadcrumb_style1-->
@endif

