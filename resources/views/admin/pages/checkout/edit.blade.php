@extends('admin.master')
@section('content')

    @if($checkout)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_checkout')}}</p>
                <p class="title2">{{"درخواست تسویه حساب به نام ".$checkout->user->full_name()}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.checkout.update',$checkout->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item">
                            <div class="clearfix"></div>
                            <div class="title_style4 noselect">اطلاعات کاربر درخواست کننده</div>
                            <hr class="hr_style2 margint5">
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">نام و نام خانوادگی:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user->full_name()}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">ایمیل:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user->email}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">شماره تماس:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user->mobile}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">موجودی قابل برداشت (تومان) :</p>
                            <div class="item_inner">
                                @php if($checkout->user->master_left_video_balance < 0){
                                    $master_left_video_balance = str_replace('-','',$checkout->user->master_left_video_balance);
                                } else {
                                    $master_left_video_balance = $checkout->user->master_left_video_balance;
                                }
                                @endphp
                                <input type="text" data-mask="000.000.000.000.000" data-mask-reverse="true" disabled value="{{$master_left_video_balance}}" @if($checkout->user->master_left_video_balance < 0) style="background-color: rgba(255, 10, 10, 0.18) !important;" @endif>
                            </div>
                        </li>

                        <li class="item">
                            <div class="clearfix"></div>
                            <hr class="hr_style2 margint20">
                            <div class="title_style4 noselect">پرداخت شود به بانک</div>
                            <hr class="hr_style2 margint5">
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">نام بانک:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user_bank->title}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">نام صاحب حساب:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user_bank->name}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">شماره حساب:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user_bank->account_number}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">شماره کارت:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user_bank->account_card}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">شماره شبا:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$checkout->user_bank->account_shaba}}">
                            </div>
                        </li>

                        <li class="item">
                            <div class="clearfix"></div>
                            <hr class="hr_style2 margint20">
                            <div class="title_style4 noselect">اطلاعات پرداخت</div>
                            <hr class="hr_style2 margint5">
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">مبلغ درخواستی (تومان):</p>
                            <div class="item_inner">
                                <input type="text" data-mask="000.000.000.000.000" data-mask-reverse="true" disabled value="{{$checkout->price}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">روش واریز:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="@if($checkout->pay_type == 1) روش کارت به کارت با کارمزد @else روش پایا بدون کارمزد @endif">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">مبلغ کارمزد (تومان):</p>
                            <div class="item_inner">
                                <input type="text" class="ltr" @if($checkout->pay_status != 2) name="price_check_out" @else disabled @endif data-mask="000.000.000.000.000" data-mask-reverse="true" value="{{$checkout->price_check_out}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">شماره تراکنش/پیگیری:</p>
                            <div class="item_inner">
                                <input type="text" class="ltr" @if($checkout->pay_status != 2) name="tracking_code" @else disabled @endif value="{{$checkout->tracking_code}}">
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">توضیحات</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="description" class="autosize" placeholder="توضیحات را وارد نمایید">{{$checkout->description}}</textarea>
                            </div>
                        </li>
                    </ul>
                    @if($checkout->pay_status != 2)
                        <div class="btn_group_style2 tcenter confstat_wrapper">
                            <hr class="hr_style1 margint20 marginb10">
                            <ul class="list clearfix">
                                <li class="item width31 fright">
                                    <label class="checkradio_style1 noselect cl_yellow"><input type="radio" name="pay_status" value="1" @if($checkout->pay_status == 1) checked="checked" @endif><span class="box"></span>در انتظار تایید</label>
                                </li>

                                <li class="item width31 fright">
                                    <label class="checkradio_style1 noselect cl_green2"><input type="radio" name="pay_status" value="2" @if($checkout->pay_status == 2) checked="checked" @endif><span class="box"></span>تایید پرداخت</label>
                                </li>

                                <li class="item width31 fright">
                                    <label class="checkradio_style1 noselect cl_red"><input type="radio" name="pay_status" value="3" @if($checkout->pay_status == 3) checked="checked" @endif><span class="box"></span>عدم تایید پرداخت</label>
                                </li>
                            </ul>
                            <hr class="hr_style1 margint10 marginb20">
                        </div>
                    @else
                        <hr class="hr_style1 margint20 marginb10">
                        <div class="btn_group_style2 tcenter confstat_wrapper">
                            <div class="cl_green2 tcenter title_style3" style="margin-bottom:0;color:#25ab8c;">پرداخت نهایی شده</div> <hr class="hr_style1 margint10 marginb20">
                        </div>
                    @endif

                    {{--<hr class="hr_style1 marginb20 margint20">--}}
                    @if($checkout->pay_status != 2)
                        <div class="btn_group_style1">
                            <ul class="list clearfix">
                                <li class="item {{__('content.float')}}">
                                    <input type="submit" name="submit" id="edit_checkout" value="{{__('content.save_changes')}}" class="btn_style2 green">
                                </li>
                                <li class="item {{__('content.float')}}">
                                    <a href="{{route('admin.checkout.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="btn_group_style1">
                            <ul class="list clearfix">
                                <li class="item {{__('content.float')}}">
                                    <a href="{{route('admin.checkout.index')}}" class="btn_style2">بازگشت به لیست</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_checkouts'))

{{--Active Menu--}}
@section('admin.checkout.index','active')
{{--End Active Menu--}}