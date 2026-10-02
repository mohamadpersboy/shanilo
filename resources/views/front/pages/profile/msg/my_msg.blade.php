@if($msgs->count() > 0)
    <table>
        <thead>
        <tr>
            <td>شناسه ی پیام</td>
            <td>مخاطب پیام</td>
            <td>موضوع</td>
            <td>وضعیت</td>
            <td>تاریخ ثبت</td>
            <td>فعالیت</td>
        </tr>
        </thead>
        <tbody>
        @foreach($msgs as $msg)
            <tr>
                <td class="{{!$msg->details()->latest()->first()->creator->is(auth()->user()) && $msg->is_show == '1' ? 'shine' : '' }}">{{ $msg->id }}</td>
                <td>
                    <a href="{{ route('front.user-page.personal',auth()->user()->is($msg->sender) ? $msg->receiver_id : $msg->sender_id) }}"
                       class="user_info_style1 flex">
                        <div class="user_pic"
                             style="background-image: url('{{ auth()->user()->is($msg->sender) ? $msg->receiver->takeImage('avatar','60/60','user.png')  :  $msg->sender->takeImage('avatar','60/60','user.png') }}');">
                        </div>
                        <div class="user_name id">
                            {{ auth()->user()->is($msg->sender) ? $msg->receiver->name.' '.$msg->receiver->family  :  $msg->sender->name.' '.$msg->sender->family }}
                        </div>
                    </a>
                </td>
                <td class="td-subject">{{ $msg->subject }}</td>
                <td>
                    @if($msg->details()->latest()->first()->creator->is(auth()->user()))
                        <span class="condition_show orange">ارسال شده</span>
                    @else
                        <span class="condition_show green">دریافت شده </span>
                    @endif
                </td>
                <td>{{ \Morilog\Jalali\jDate::forge($msg->created_at)->format('H:i Y-m-d') }}</td>
                <td>
                    <a href="{{ route('msg.show',$msg->id) }}">مشاهده</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $msgs->appends(request()->query())->render() !!}
@else
    <div class="alert alert-warning">
        موردی برای نمایش یافت نشد!!
    </div>
@endif
