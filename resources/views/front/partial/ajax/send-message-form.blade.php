<div class="comment_style1">
    <div class="form_style1">
        {!! Form::open([
            'url'=>route('msg.store'),
            'data-ajax',
            'data-type'=>'json',
            'data-on-error'=>'inline-message',
            'data-on-success'=>'alert-message',
            'data-clear'=>'true',
            'enctype'=>'multipart/form-data'
        ]) !!}
        {!! Form::hidden('receiver_id',$receiver->id) !!}
        {!! Form::hidden('receiver_sid',bcrypt($receiver->id)) !!}
        @if(isset($shop))
            {!! Form::hidden('shop_id',$shop->id) !!}
            {!! Form::hidden('shop_sid',bcrypt($shop->id)) !!}
        @endif
        <ul class="frm_step no_bullet">
            <li class="frm_item w100 flex">
                <input class="frm_input" name="subject" placeholder="موضوع پیام">
            </li>
            <li class="frm_item w100 flex">
                    <textarea class="frm_input frm_textarea" name="description" data-valid-required=""
                              aria-required="true"
                              placeholder="متن پیام شما"></textarea>
                <div class="frm_title">پیام شما خود را ثبت کنید</div>
            </li>
            <li class="frm_item w100 flex">
                <div class="single-ticket__send_form__grid">

                    <div class="single-ticket__send_upload"
                         onclick="document.getElementById('attachment-file-message').click();">
                        <button class="single-ticket__send_upload_btn" type="button">انتخاب فایل</button>
                        <input type="text" id="file-name" class="single-ticket__send_upload_input"
                               value="فایلی انتخاب نشده" readonly="">
                    </div>
                    <input type="file" onchange="ticketFileName()" id="attachment-file-message" name="upload"
                           style="display: none; ">

                </div>
                {{--                <input type="file" class="frm_input" name="file">--}}
            </li>
            <li class="frm_item w100 flex rate_item">
                <button class="frm_submit" style="background-color:#B521CF">ثبت پیام </button>
            </li>
        </ul>
        {!! Form::close() !!}
    </div><!--close .form_style1-->
</div><!-- comment style -->
