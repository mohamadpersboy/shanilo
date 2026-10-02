@extends('admin.master')
@section('content')

    @if($inventory)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_inventory')}}</p>
                <p class="title2">{{__('content.create_inventory')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.inventory.update',$inventory->id)}}" enctype="multipart/form-data">
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
                                <input type="text" disabled value="{{$inventory->user->full_name()}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">ایمیل:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->user->email}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">شماره تماس:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->user->mobile}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">موجودی فعلی (تومان) :</p>
                            <div class="item_inner">
                                <input type="text" data-mask="000,000,000,000,000" data-mask-reverse="true" disabled value="{{$inventory->user->balance}}">
                            </div>
                        </li>

                        <li class="item">
                            <div class="clearfix"></div>
                            <hr class="hr_style2 margint20">
                            <div class="title_style4 noselect">اطلاعات پرداخت</div>
                            <hr class="hr_style2 margint5">
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">مبلغ واریزی (تومان):</p>
                            <div class="item_inner">
                                <input type="text" data-mask="000,000,000,000,000" data-mask-reverse="true" disabled value="{{$inventory->price}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">نام بانک:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->source_bank_name}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">نام صاحب حساب:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->account_name}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">شماره حساب / کارت:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->card_code}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">شماره رسید:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->tracking_code}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">تاریخ پرداخت:</p>
                            <div class="item_inner">
                                <input type="text" disabled value="{{$inventory->deposit_date}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">بانک مقصد:</p>
                            <div class="item_inner">

                                <input type="text" disabled value="                                واریز شده به بانک {{$inventory->admin_bank->title}} به نام {{$inventory->admin_bank->name}} شماره حساب {{$inventory->admin_bank->account_number}} شماره کارت {{$inventory->admin_bank->account_card}}">
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">توضیحات</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="description" class="autosize" placeholder="توضیحات را وارد نمایید">{{$inventory->description}}</textarea>
                            </div>
                        </li>
                    </ul>
                    @if($inventory->pay_status != 2)
                        <div class="btn_group_style2 tcenter confstat_wrapper">
                            <hr class="hr_style1 margint20 marginb10">
                            <ul class="list clearfix">
                                <li class="item width31 fright">
                                    <label class="checkradio_style1 noselect cl_yellow"><input type="radio" name="pay_status" value="1" @if($inventory->pay_status == 1) checked="checked" @endif><span class="box"></span>در انتظار تایید</label>
                                </li>

                                <li class="item width31 fright">
                                    <label class="checkradio_style1 noselect cl_green2"><input type="radio" name="pay_status" value="2" @if($inventory->pay_status == 2) checked="checked" @endif><span class="box"></span>تایید واریز</label>
                                </li>

                                <li class="item width31 fright">
                                    <label class="checkradio_style1 noselect cl_red"><input type="radio" name="pay_status" value="3" @if($inventory->pay_status == 3) checked="checked" @endif><span class="box"></span>عدم تایید واریز</label>
                                </li>
                            </ul>
                            <hr class="hr_style1 margint10 marginb20">
                        </div>
                    @else
                        <hr class="hr_style1 margint20 marginb10">
                        <div class="btn_group_style2 tcenter confstat_wrapper">
                            <div class="cl_green2 tcenter title_style3" style="margin-bottom:0;color:#25ab8c;">پرداخت تائید شده</div>            <hr class="hr_style1 margint10 marginb20">
                        </div>
                    @endif

                    {{--<hr class="hr_style1 marginb20 margint20">--}}
                    @if($inventory->pay_status != 2)
                        <div class="btn_group_style1">
                            <ul class="list clearfix">
                                <li class="item {{__('content.float')}}">
                                    <input type="submit" name="submit" id="edit_inventory" value="{{__('content.save_changes')}}" class="btn_style2 green">
                                </li>
                                <li class="item {{__('content.float')}}">
                                    <a href="{{route('admin.inventory.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="btn_group_style1">
                            <ul class="list clearfix">
                                <li class="item {{__('content.float')}}">
                                    <a href="{{route('admin.inventory.index')}}" class="btn_style2">بازگشت به لیست</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_inventorys'))

{{--Active Menu--}}
@section('admin.inventory.index','active')
{{--End Active Menu--}}