@if($msgs->count() != 0)
    <table class="">
        <thead>
        <tr>
            <th>شناسه ی پیام</th>
            <th>ارسال کننده</th>
            <th>از طریق</th>
            <th>موضوع</th>
            <th>وضعیت</th>
            <th>تاریخ تیکت</th>
            <th>فعالیت</th>
        </tr>
        </thead>
        <tbody>
        @foreach($msgs as $msg)
            <tr>
                <td class="{{!$msg->details()->latest()->first()->creator->is(auth()->user()) && $msg->is_show == '1' ? 'shine' : '' }}">{{ $msg->id }}</td>
                <td>
                    <a href="{{ route('front.user-page.personal',$msg->sender_id) }}" class="user_info_style1 flex">
                        <div class="user_pic"
                             style="background-image: url('{{ $msg->sender->takeImage('avatar','60/60','user.png') }}');">
                        </div>
                        <div class="user_name id">
                            {{ ($msg->is_ticket) ? 'admin' : $msg->sender->name.' '.$msg->sender->family }}
                        </div>
                    </a>
                </td>
                <td>
                    <a class="user_info_style1 flex">
                        <div class="user_pic"
                             style="background-image: url('{{$msg->shop->takeImage('background','1200/500')}}');">
                        </div>
                        <div class="user_name id">
                            {{ $msg->shop->title }}
                        </div>
                    </a>
                </td>
                <td class="td-subject">{{ $msg->subject }}</td>
                <td>
                    @if($msg->details()->latest()->first()->creator->is(auth()->user()))
                        <span class="condition_show orange">ارسال شده</span>
                    @else
                        <span class="condition_show green">دریافت شده </span>
                    @endif                </td>
                <td>{{ \Morilog\Jalali\jDate::forge($msg->created_at)->format('H:i Y-m-d') }}</td>
                <td>
                    <a href="{{ route('msg.show',$msg->id) }}">مشاهده</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $msgs->render() !!}
@else
    <div class="alert alert-warning">
        موردی برای نمایش یافت نشد!
    </div>
@endif
