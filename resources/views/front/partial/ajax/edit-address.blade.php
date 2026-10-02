<div class="form_style2">
    <div class="title_style7"><span>ویرایش آدرس</span></div>
    {!! Form::model($address,[
    'url'=>route('front.profile.address.update',$address),
    'data-ajax',
    'data-type'=>'json',
    'data-on-success'=>'redirect',
    'data-on-error'=>'inline-message',
    'data-clear'=>'true'
    ]) !!}
    {{method_field('PATCH')}}
    @include('front.partial.ajax.address-form')
    {!! Form::close() !!}
</div>
<div class="close_btn"><i class="i-cancel"></i></div>