@if($msgs->count() > 0)
    <table>
        <thead>
        <tr>
            <td>شناسه ی پیام</td>
            <td>موضوع</td>
            <td>وضعیت</td>
            <td>تاریخ ثبت</td>
            <td>فعالیت</td>
        </tr>
        </thead>
        <tbody>
        @foreach($msgs as $msg)
            <tr>
                <td style="height: 90px;">{{ $msg->id }}</td>
                <td class="td-subject">{{ $msg->subject }}</td>
                <td>
                    <div class="condition_show {{ $msg->status == 'send' ? 'pending' : 'purple' }}">{{ $msg->status_msg }}</div>
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
