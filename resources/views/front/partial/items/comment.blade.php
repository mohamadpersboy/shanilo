<li id="comment-{{$comment->id}}" class="item1">
    <div class="comment clearfix">
        <div class="info_part flex">
            <a href="{{$comment->user->path()}}" class="user_avatar flex">
                <div class="pic"
                     style="background-image: url('{{$comment->user->takeImage('avatar','60/60','user.png')}}');"></div>
                <div class="name ellipsis">{{getUsersFullName($comment->user)}}</div>
            </a>
            <div class="rate_show">
                <div class="star_part">
                    <div class="rate_style1">
                        @include('front.partial.items.rate',['rate'=>$comment->rate])
                    </div><!-- rate_style1 -->
                </div>
            </div>
            @if(auth()->check() && $canAnswer)
                <div data-url="{{route('front.comment.reply',$comment)}}" class="cm_btn reply_btn"><span>پاسخ</span></div>
            @endif
            @if(!isset($noButton))
            @if($comment->isCommentedByAuth())
                <div data-block="#comment-{{$comment->id}}" data-url="{{route('front.comment.destroy',$comment)}}" class="dlt_btn btn-delete reply_btn"><span>حذف پیام</span></div>
            @endif

            @if(!$comment->isCommentedByAuth() && auth()->check())
                @if($comment->isReportedByAuth())
                    <div class="report_btn reported reply_btn"><span>گزارش شد</span></div>
                @else
                    <div data-url="{{route('front.report.store',[getClassToLower($comment),$comment->id])}}" class="report_btn btn-report reply_btn"><span>گزارش تخلف</span></div>
                @endif
            @endif
            @endif
            <div class="date">
                <span class="calendar_text">{{show_persian_with_month($comment->created_at)}}</span>
            </div>
        </div>
        <div class="text_part">
            <p class="text ellipsis">{{$comment->comment}}</p>
        </div>
    </div>
    @if($canAnswer)
    <div class="under_comment">
        <div class="reply_html"></div><!--close .reply_html-->
        <ul class="step2 no_bullet">
            @foreach($comment->answers as $index=>$answer)
                <li class="item2">
                    <div class="info_part flex">
                        <a href="{{$answer->user->path()}}" class="user_avatar flex">
                            <div class="pic"
                                 style="background-image: url('{{$answer->user->takeImage('avatar','60/60','user.png')}}');"></div>
                            <div class="name ">{{getUsersFullName($answer->user)}}</div>
                        </a>
                        <div class="date"><span class="calendar_text">{{show_persian_with_month($answer->created_at)}}</span></div>
                    </div>
                    <div class="text_part">
                        <p class="text ">{{$answer->comment}}</p>
                    </div>
                </li><!--close .item2-->
            @endforeach
        </ul><!--close .step2-->
    </div><!--close .under_comment-->
    @endif
</li><!--close .item1-->