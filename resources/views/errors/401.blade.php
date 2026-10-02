@extends('admin.master')
@section('content')
        <div class="msg_style1">
            <div class="top_part" style="background-image:url({{asset("assets/admin/_images/bg/limit-access.jpg")}})">
                <h3 class="title">{{__('content.access_restriction')}}</h3>
                <span class="icon"><i class="i-lock-alt"></i></span>
            </div>
            <div class="bottom_part">
                <p class="text">{{__('messages.access_restriction')}}</p>
                <a href="{{route('admin.home.index')}}" class="btn_style2 green">{{__('content.admin_panel')}}</a>
            </div>
        </div><!--msg_style1-->
@endsection