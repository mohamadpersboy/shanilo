<div class="close_btn"><i class="i-cancel"></i></div>
<div class="title_style7"><span class="title">افزودن کارت جدید</span></div>
<div class="text_style1">ایجاد کارت بانکی جدید</div>
<div class="form_style2">
    {!! Form::open([
    'url'=>route('front.profile.bankCart.store'),
    'data-ajax',
    'data-type'=>'json',
    'data-on-success'=>'redirect',
    'data-on-error'=>'inline-message',
    'data-clear'=>'true'
    ]) !!}
    @include('front.pages.profile.bankcart.form')
    {!! Form::close() !!}
</div>