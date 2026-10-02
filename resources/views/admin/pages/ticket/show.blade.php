@extends('admin.master')

@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{$header['show']['title']}}</p>
            <p class="title2">{{$header['show']['description']}}</p>
            <p class="title2">موضوع : {{$ticket->title}}</p>
        </div><!--title_style1-->

        @if(!$ticket->trashed())
            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.ticket.store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">متن پاسخ</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <input type="hidden" name="parent_id" value="{{$ticket->id}}">
                                <textarea name="message" class="autosize">{{ old('message') }}</textarea>
                            </div>
                        </li>

                    </ul>

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="ثبت پاسخ" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.ticket.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        @endif

        <section class="user_msg_part2 marginb50">
            <hr class="hr_style2 margint50">
            <div class="chat_style1">
                <ul class="list step1 clearfix">
                    @if($ticket->tickets->count())
                        @foreach ($ticket->tickets as $ticketChild)
                            <li class="item @if($ticketChild->user_id == null) left_chat @else right_chat @endif clearfix last">
                                <div class="info">
                                    @if($ticketChild->user_id != null)
                                    <span class="pic pic_style3" style="background-image:url({{$ticketChild->user->takeImage('avatar',null,'user-avatar.jpg')}});"></span>
                                    @else
                                    <span class="pic pic_style3" style="background-image:url({{asset('assets/admin/_images/default/admin.png')}});"></span>
                                    @endif
                                </div><!--info-->
                                <div class="context">
                                    <div class="header">
                                        <span class="status">
                                {{-- <i class="name">دریافت شده توسط :</i> --}}
                                @if($ticketChild->user_id != null)
                                <i class="val">{{getUsersFullName($ticketChild->user)}}</i>
                                @else
                                <i class="val">مدیر سایت</i>
                                @endif
                                <i class="name"> / </i>
                                <i class="val">{{\Morilog\Jalali\jDate::forge($ticketChild->created_at)->ago()}}</i></span>
                                    </div>
                                    <div class="msg">
                                        <p class="text">{!! nl2br($ticketChild->message) !!}</p>
                                    </div>
                                </div><!--context-->
                            </li>
                        @endforeach
                    @endif
                    <li class="item right_chat clearfix last">
                        <div class="info">
                            <span class="pic pic_style3" style="background-image:url({{$ticket->user->takeImage('avatar',null,'user-avatar.jpg')}});"></span>
                        </div><!--info-->
                        <div class="context">
                            <div class="header">
                                <span class="status">
                        {{-- <i class="name">دریافت شده توسط :</i> --}}
                        <i class="val">{{getUsersFullName($ticket->user)}}</i>
                        <i class="name"> / </i>
                        <i class="val">{{\Morilog\Jalali\jDate::forge($ticket->created_at)->ago()}}</i></span>
                            </div>
                            <div class="msg">
                                <p class="text">{!! nl2br($ticket->message) !!}</p>
                            </div>
                        </div><!--context-->
                    </li>
                </ul>
            </div><!--chat_style1-->
        </section>
    </div>

@endsection

{{--Active Menu--}}
@section('admin.message','active')
@section('admin.ticket.index','active')
{{--End Active Menu--}}