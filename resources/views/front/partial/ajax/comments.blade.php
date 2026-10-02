<div class="comment_style1">
    @if(canComment($object))
        <div class="form_style1">
            {!! Form::open([
                'url'=>route('front.comment.store',[getClassToLower($object),$object->id]),
                'data-ajax',
                'data-type'=>'json',
                'data-on-error'=>'inline-message',
                'data-on-success'=>'alert-message',
                'data-clear'=>'true'
            ]) !!}
            {!! Form::hidden('rate',1) !!}
            <ul class="frm_step no_bullet">
                <li class="frm_item w100 flex">
                    <textarea class="frm_input frm_textarea" name="comment" data-valid-required="" aria-required="true"
                              placeholder="متن نظر شما"></textarea>
                    <div class="frm_title">نظر خود را ثبت کنید</div>
                </li>
                <li class="frm_item w100 flex rate_item">
                    <button class="frm_submit">ثبت نظر</button>
                    <div class="track_rate flex">
                        <div class="star_part">
                            <div class="title_style8"><span class="title">ثبت امتیاز شما</span></div>
                            <div class="rate_style1">
                                <div class="rate_inner clearfix">
                                    <input type="radio" id="star4_5" name="rating[4_10]" value="5">
                                    <label class="full star" for="star4_5" title=" امتیاز"></label>

                                    <input type="radio" id="star4_4" name="rating[4_10]" value="4">
                                    <label class="full star" for="star4_4" title=" امتیاز"></label>

                                    <input type="radio" id="star4_3" name="rating[4_10]" value="3">
                                    <label class="full star" for="star4_3" title=" امتیاز"></label>

                                    <input type="radio" id="star4_2" name="rating[4_10]" value="2">
                                    <label class="full star" for="star4_2" title=" امتیاز"></label>

                                    <input type="radio" id="star4_1" name="rating[4_10]" value="1" checked>
                                    <label class="full star" for="star4_1" title=" امتیاز"></label>
                                </div>
                            </div><!-- rate_style1 -->
                        </div>
                    </div>
                </li>
            </ul>
            {!! Form::close() !!}
        </div><!--close .form_style1-->
    @endif
    <div class="list">
        @if($comments->count())
            <ul class="step1 no_bullet">
                @foreach($comments as $index=>$comment)
                    @include('front.partial.items.comment')
                @endforeach
            </ul><!--close .step1-->
        @else
            <div class="noItem_style2 flex">در حال حاضر هیچ نظری ثبت نشده است!</div>
        @endif
    </div><!--close .list-->
</div><!-- comment style -->
<div id='reply_comment_form' style="display: none;">
    <div class='form_style1 flex'>
        <div class='close_btn'><i class='i-cancel'></i></div>
        {!! Form::open([
         'url'=>'',
         'data-ajax',
         'data-type'=>'json',
         'data-on-success'=>'alert-message',
         'data-on-error'=>'inline-message',
         'data-clear'=>'true'
        ]) !!}
        <ul class="frm_step no_bullet">
            <li class="frm_item w100 flex">
                <textarea class="frm_input frm_textarea" name="comment" data-valid-required="" aria-required="true"
                          placeholder="متن نظر شما"></textarea>
                <div class="frm_title">نظر خود را ثبت کنید</div>
            </li>
            <li class="frm_item w100 flex rate_item">
                <button class="frm_submit">ثبت پیام</button>
            </li>
        </ul>
       {!! Form::close() !!}
    </div><!--close .form_style1-->
</div><!--close #reply_comment_form-->
