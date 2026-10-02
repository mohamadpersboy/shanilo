<div class="modal_style1 share_modal w800">
    <div class="modal_scroll flex">
        <div class="close_bg"></div>
        <div class="wrapper">
            <div class="wrapper_box">
                <div class="close_btn"><i class="i-cancel"></i></div>
                <div class="title_style7"><span class="title">ارسال برای دوستان</span></div>
                <div class="form_style1">
                    {!! Form::open([
                    'url'=>route('front.share.store'),
                    'data-ajax',
                    'data-type'=>'json',
                    'data-on-success'=>'alert-message',
                    'data-on-error'=>'inline-message',
                    'data-clear'=>'true'
                    ]) !!}
                    <input type="hidden" name="model">
                    <input type="hidden" name="id">
                    <ul class="frm_step no_bullet">
                        <li class="frm_item w100 flex">
                            <input class="frm_input" name="email" type="text"
                                   placeholder="آدرس ایمیل را وارد کنید">
                            <div class="frm_title"></div>
                        </li>
                        <li class="frm_item w100 flex">
                            <button class="frm_submit">ارسال</button>
                        </li>
                    </ul>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>