@component('mail::message')

شما با موفقیت در خبرنامه وبسایت {{__('content.site_name')}} عضو شدید، جهت لغو عضویت روی دکمه لغو عضویت کلیک نمایید.

با سپاس<br>
{{__('content.site_name')}}

@component('mail::button', ['url' => route('front.newsletter.destroy',$newsletterid)])
    لغو عضویت
@endcomponent

@endcomponent
