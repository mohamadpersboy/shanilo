<div class="form_style2">
    <div class="title_style7"><span>افزودن آدرس جدید</span></div>
    {!! Form::open([
    'url'=>route('front.profile.address.store'),
    'data-ajax',
    'data-type'=>'json',
    'data-on-success'=>'redirect',
    'data-on-error'=>'inline-message',
    'data-clear'=>'true'
    ]) !!}
        @include('front.partial.ajax.address-form')
    {!! Form::close() !!}
</div>
<div class="close_btn"><i class="i-cancel"></i></div>