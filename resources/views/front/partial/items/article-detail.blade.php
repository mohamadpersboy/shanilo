<div class="personal_detail_style2">
    <div class="detail_style1">
        <div class="detail_date flex">
            <div class="item flex"><span class="icon"><i class="i-022-calendar"></i></span><span class="title">تاریخ انتشار : </span><span
                        class="content">{{show_persian_with_month($article->created_at)}}</span></div>
            <div class="item flex"><span class="icon"><i class="i-011-eye"></i></span><span
                        class="title">تعداد بازدید : </span><span class="content">{{$article->views}}</span></div>
            @if($source=$article->source)
                <div class="item detail_source">
                    <span class="name">منبع مقاله:</span>
                    <a href="{{$article->link?:'javascript:void(0)'}}" title="" class="link">{{$source}}</a>
                </div>
            @endif
        </div>
        {{--<div class="detail_source">
            <span class="name">منبع مقاله:</span>
            <a href="#" title="" class="link">وب سایت خبری آوا نگار</a>
        </div>--}}
        <div class="detail_pic" style="background-image: url('{{$article->takeImage('main','900/655')}}');"></div>
        <div class="detail_title">{{$article->title}}</div>
        <div class="detail_content">
            <article class="content_style1 ">
                <p class="line-break">
                    {{$article->description}}
                </p>
            </article>
        </div>
    </div>
</div><!-- personal_detail_style2 -->