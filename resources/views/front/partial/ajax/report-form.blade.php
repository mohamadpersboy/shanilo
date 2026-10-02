<div class="comment_style1">
    <div class="form_style1">
        {!! Form::open([
            'url'=>$route,
            'data-ajax',
            'data-type'=>'json',
            'data-on-error'=>'inline-message',
            'data-on-success'=>'redirect',
            'data-clear'=>'true'
        ]) !!}
        {!! Form::hidden('redirect',true) !!}
        <ul class="frm_step no_bullet">
            <li class="frm_item w100 flex">
                                        <textarea class="frm_input frm_textarea" name="description" data-valid-required=""
                                                  aria-required="true" placeholder="توضیحات شما"></textarea>
                <div class="frm_title">توضیحات خود را ثبت نمایید.</div>
            </li>
            <li class="frm_item w100 flex rate_item">
                <button class="frm_submit">ارسال گزارش</button>
            </li>
        </ul>
        {!! Form::close() !!}
    </div>
</div>
