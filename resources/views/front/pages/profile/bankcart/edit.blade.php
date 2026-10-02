<div class="close_btn"><i class="i-cancel"></i></div>
<div class="title_style7"><span class="title">ویرایش کارت</span></div>
<div class="text_style1">ویرایش کارت بانکی</div>
<div class="form_style2">
    {!! Form::model($bankCart,[
    'url'=>route('front.profile.bankCart.update',$bankCart),
    'data-ajax',
    'data-type'=>'json',
    'data-on-success'=>'redirect',
    'data-on-error'=>'inline-message',
    'data-clear'=>'true'
    ]) !!}
    {!! method_field('PATCH') !!}
    @include('front.pages.profile.bankcart.form')
    {!! Form::close() !!}
</div>