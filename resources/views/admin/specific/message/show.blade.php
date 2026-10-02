@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">مدیریت پیامهای کاربران</p>
            <p class="title2">جزئیات پیام</p>
        </div><!--title_style1-->

        <section id="messages" class="user_msg_part2 marginb50 " style="max-height: 400px;overflow: scroll;">
            <hr class="hr_style2 margint50">
            <div class="chat_style1">
                <ul class="list step1 clearfix">
                    @if($messages->count())
                        @foreach ($messages as $childMessage)
                            <li class="item @if($childMessage->user_id == null) left_chat @else right_chat @endif clearfix last">
                                <div class="info">
                                    @if($childMessage->user_id != null)
                                        <a href="{{$childMessage->sender->path()}}" target="_blank">    <span
                                                    class="pic pic_style3"
                                                    style="background-image:url({{$childMessage->sender->takeImage('avatar','60/60','user.png')}});"></span></a>
                                    @else
                                        <span class="pic pic_style3"
                                              style="background-image:url({{asset('assets/admin/_images/default/admin.png')}});"></span>
                                    @endif
                                </div><!--info-->
                                <div class="context">
                                    <div class="header">
                                        <span class="status">
                                {{-- <i class="name">دریافت شده توسط :</i> --}}
                                            @if($childMessage->user_id != null)
                                                <a href="{{$childMessage->sender->path()}}" target="_blank"> <i
                                                            class="val">{{getUsersFullName($childMessage->sender)}}</i></a>
                                            @else
                                                <i class="val">مدیر سایت</i>
                                            @endif
                                            <i class="name"> / </i>
                                            <i class="val">{{\Morilog\Jalali\jDate::forge($childMessage->created_at)->ago()}}</i></span>
                                    </div>
                                    <div class="msg">
                                        @if($childMessage->upload_file != "")
                                            <a href="{{ $childMessage->upload_file }}"> لینک دریافت فایل</a>
                                            <hr>
                                        @endif
                                        <p class="text">{!! nl2br($childMessage->message) !!}</p>
                                    </div>
                                </div><!--context-->
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div><!--chat_style1-->
        </section>
        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.message.store')}}"
              enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">متن پاسخ</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="hidden" name="receiver_id" value="{{$receiverId}}">
                            <textarea name="message" class="autosize">{{ old('message') }}</textarea>
                        </div>

                    </li>
                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">افزودن فایل</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="file" name="upload_file">
                        </div>

                    </li>
                </ul>

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="ثبت پاسخ" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.ticket.index')}}"
                               class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

{{--Active Menu--}}
@section('admin.message','active')
@section('admin.message.index','active')
{{--End Active Menu--}}

@section('js')
    <script>
      $(function () {
        $('#messages').scrollTop($('#messages')[0].scrollHeight);
      });
    </script>
@endsection
