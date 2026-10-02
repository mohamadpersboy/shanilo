@php
    if($comment->commentable instanceof \App\Models\Specific\Product){
        $img=$comment->commentable->takeImage('main','60/60');
    }else{
     $img=$comment->commentable->takeImage('avatar','60/60');
    }
@endphp
<h3 class="comment-product-title">
    <img width="80" src="{{$img}}" alt="">
    {{$comment->commentable->title_fa}}
</h3>
@if($comment->parent)
    <div class="comment-parent">
        <h4 class="comment-parent-title">پاسخ به نظر</h4>
        <p class="comment-parent-body">{{$comment->parent->comment}}</p>
    </div>
@endif
<p class="comment-body">
    <img src="{{url('assets/front/_images/icon/rating-'.$comment->rate.'_0.gif')}}" alt="">
    {{$comment->comment}}
</p>
