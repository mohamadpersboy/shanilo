@if($object instanceof \App\Models\Base\User || $object instanceof \App\Models\Specific\Shop)
    <a href="{{$object->path()}}" class="pic"
       style="background-image: url('{{$object->takeImage('avatar','60/60','user.png')}}');"></a>
@elseif($object instanceof \App\Models\Specific\ProductDetail)
    <a href="{{$object->path()}}" class="pic" style="background-image: url('{{$object->product->takeImage('main','60/60')}}');"></a>
@elseif($object==null)
    <a href="javascript:void(0)" class="pic" style="background-image: url('_images/bg/app_icon.png');"></a>
@else
    <a href="{{$object->path()}}" class="pic" style="background-image: url('{{$object->takeImage('main','60/60')}}');"></a>
@endif
<div class="content_part">
    @if($object instanceof \App\Models\Base\User)
        <a href="{{$object->path()}}" class="from id ltr" title="">{{getUsersFullName($object)}}</a>
    @elseif($object instanceof \App\Models\Specific\Shop)
        <a href="{{$object->path()}}" class="from id ltr" title="">{{$object->title}}</a>
    @elseif($object instanceof \App\Models\Specific\ProductDetail)
        <a href="{{$object->path()}}" class="from id ltr" title="">{{$object->product->title}}</a>
    @elseif($object==null)
        <a href="javascript:void(0)" class="from id ltr" title="">پشتیبانی وبسایت</a>
    @else
        <a href="{{$object->path()}}" class="from id ltr" title="">{{$object->title}}</a>
    @endif
    @if($link)
        <a href="{{$link}}" target="_blank" class="text">{{$message}}</a>
    @else
        <div>{!! $message !!}</div>
    @endif
</div>