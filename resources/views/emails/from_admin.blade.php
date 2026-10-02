@component('mail::message')

<table border="0" style="font-family: 'Tahoma'; margin-top: 20px;">
    <tr>
        <td colspan="2" style="font-family: tahoma; color: #2c9d6f;padding: 15px 0;">جناب آقا / خانم {{$name}}</td>
    </tr>
    <tr>
        <td style="font-family: tahoma; color: #2c9d6f;padding: 10px 0;width: 20%;vertical-align: top;">موضوع پیام :</td>
        <td style="font-family: tahoma; color: #888;padding: 10px 0;">{{$title}}</td>
    </tr>
    <tr>
        <td style="font-family: tahoma; color: #2c9d6f;padding: 10px 0;width: 20%;vertical-align: top;">متن پیام :</td>
        <td style="font-family: tahoma; color: #888;padding: 10px 0;">{!! nl2br($message) !!}</td>
    </tr>
</table>

 باتشکر<br>
{{__('content.site_name')}}

@endcomponent
