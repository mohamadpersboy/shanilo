@extends('admin.master')
@section('css')
    <style>
        .form_style2 .tokenfield .token-input {
            padding-right: 10px !important;
            padding-left: 0 !important;
            direction: rtl !important;
            margin-top: 1px !important;
            border-radius: 2px;
            /*position: absolute;
            right: 0;
            top: 0;*/
        }

        .tokenfield.form-control {
            border: 1px solid #e5e5e5;
            border-radius: 2px;
        }

        .select_style2.height36 {
            height: 40px;
        }

        /*.form_style2 .tokenfield {
            height: 39px !important;
            overflow: hidden !important;
        }*/

        /*  .token.bg-teal {
              position: relative;
              z-index: 2;
              width: 97%;
          }*/
    </style>
@endsection
@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">مدیریت درخواست های تسویه</p>
            <p class="title2">ویرایش درخواست تسویه</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::model($checkout,['url'=>route('admin.checkout.update',$checkout->id),'method'=>'PATCH','class'=>'form-horizontal form-contact-us-validation','files'=>true]) !!}
        {!! Form::hidden('id',$checkout->id) !!}
        <div class="form_style2">
            <ul class="list clearfix">
                <li class="item {{__('content.float')}} width50">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">مبلغ درخواستی</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" value="{{showPrice($checkout->price)}}" readonly>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 nospace">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">حساب بانکی به نام({{$checkout->bankCart->owner}})</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select class="js-example-basic-single">
                            <option value="">شماره کارت: {{$checkout->bankCart->cart_no}}</option>
                            <option value="">شماره شبا: {{$checkout->bankCart->sheba_no}}</option>
                        </select>
                    </div>
                </li>

                <li class="item {{__('content.float')}} width50">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">وضعیت درخواست :<i class="required_style1">*</i></p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        @if($checkout->status=='pending')
                        <select name="status" class="js-example-basic-single">
                            <option value="pending" selected>در انتظار تسویه</option>
                            <option value="done">تسویه شد</option>
                            <option value="denied">رد شد</option>
                        </select>
                        @else
                            @php
                                $status=$checkout->status=='done'?'تسویه شد':'رد شد'
                            @endphp
                            <input type="text" value="{{$status}}" readonly>
                        @endif
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 nospace">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره پیگیری</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" name="tracking_code" value="{{$checkout->tracking_code}}" {{$checkout->status=='done'?'readonly':''}}>
                    </div>
                </li>
            </ul>
        {{--    <hr class="hr_style1 marginb20 margint20">
            <ul class="list clearfix">
                <li class="item {{__('content.float')}} width50 ">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">مبلغ از کیف پول فروشگاه کم شود؟</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="decrease" class="js-example-basic-single">
                            <option value="0">خیر</option>
                            <option value="1">بله</option>
                        </select>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 nospace">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">مبلغ کسری</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" name="decrease_price" value="" >
                    </div>
                </li>
            </ul>--}}
            <hr class="hr_style1 marginb20 margint20">
            <div class="btn_group_style1">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}}">
                        <input type="submit" name="submit" value="{{__('content.submit')}}" class="btn_style2 green">
                    </li>
                </ul>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">ارسال پیام به کاربر محصول</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.message.store')}}"
              enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">متن پیام</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="hidden" name="receiver_id" value="{{$checkout->wallet->shop->user_id}}">
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
@section('admin.checkout.index','active')
{{--End Active Menu--}}
@section('js')
    @include('admin.developer.select2')
@endsection





