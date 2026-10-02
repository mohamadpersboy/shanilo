@component('mail::message')
لطفا جهت فعال سازی حساب کاربری خود بر روی لینک زیر کلیک نمایید.
{{__('content.site_name')}}

@component('mail::button', ['url' => route('front.auth.confirm',$user_confirm)])
    فعال سازی حساب
@endcomponent

@endcomponent
