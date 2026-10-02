@component('mail::message')

    کاربر سایت {{__('content.site_name')}} خبر زیر را جهت معرفی، برای شما ارسال نموده است.

<table border="0" style="font-family: 'Tahoma'; margin-top: 20px;">
    <tr>
        <td
        style="    font-family: Avenir, Helvetica, sans-serif;
    width: 140px;
    border: solid 1px #eaeaea;
    display: block;
    padding: 20px;
    margin-left: 20px;
border-radius: 4px"
        ><img src="{{$image}}" alt='{{$title}}' title="{{$title}}" style="
    max-width: 100%;
    max-height: 100%;
    margin: 0 auto;
    display: block;"></td>
        <td style="font-family: tahoma; color: #888;">{{$title}}</td>
    </tr>
</table>


@component('mail::button', ['url' => $link])
    مشاهده خبر
@endcomponent

 باتشکر<br>
{{__('content.site_name')}}

@endcomponent
