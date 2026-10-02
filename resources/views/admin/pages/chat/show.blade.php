@extends('admin.master')

@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{$header['show']['title']}}</p>
            <p class="title2">{{$header['show']['description']}}</p>
        </div><!--title_style1-->
                
        @if(!$conversation->trashed())
            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.chat.update',$conversation->id)}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('patch')}}
                <div class="form_style2">
                    <ul class="list clearfix">

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="body" class="autosize">{{ old('body') }}</textarea>
                            </div>
                        </li>

                    </ul>

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="ارسال پیام" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.chat.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        @else
            <div class="form_style2">
                <div class="result_style2 disable_max_width sign w">
                    <div class="text icon">این پیام توسط کاربر حذف شده است.</div>
                </div>
            </div><!--paper_style-->
        @endif
        
        <section class="user_msg_part2 marginb50">
            <hr class="hr_style2 margint50">
            <div class="chat_style1">
                <ul class="list step1 clearfix">
                    @foreach ($chats as $chat)
                        <li class="item @if($chat->user_id != Auth::guard('admins')->user()->id) left_chat @else right_chat @endif clearfix last">
                            <div class="info">
                                @if($chat->user_id != Auth::guard('admins')->user()->id)
                                    <span class="pic pic_style3" style="background-image:url({{$chat->sender->takeImage('avatar',null,'user-avatar.jpg')}});"></span>
                                @else
                                    <span class="pic pic_style3" style="background-image:url({{asset('assets/admin/_images/default/admin.png')}});"></span>
                                @endif
                                @if($chat->read_at == null)
                                    <span class="notSeenChat" title="دیده نشده"></span>
                                @else
                                    <span class="seenChat" title="دیده شده"></span>
                                @endif
                            </div><!--info-->
                            <div class="context">
                                <div class="header">
                                    <span class="status">
                            {{-- <i class="name">دریافت شده توسط :</i> --}}
                            @if($chat->user_id != Auth::guard('admins')->user()->id)
                            <i class="val">{{$chat->sender->fullName()}}</i>
                            @else
                            <i class="val">مدیر سایت</i>
                            @endif
                            <i class="name"> / </i>
                            <i class="val">{{showAgoTime($chat->created_at)}}</i></span>
                                </div>
                                <div class="msg">
                                    <p class="text">{!! nl2br($chat->body) !!}</p>
                                </div>
                            </div><!--context-->
                        </li>  
                    @endforeach  
                </ul>    
            </div><!--chat_style1-->
        </section>
    </div>

@endsection

{{--Active Menu--}}
@section('admin.message','active')
@section('admin.chat.index','active')
{{--End Active Menu--}}