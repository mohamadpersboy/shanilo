@extends('admin.master')
@section('content')

    @if($credit)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_checkout')}}</p>

            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation"
                  action="{{route('admin.profile.create.request.update',$credit->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item">
                            <div class="clearfix"></div>
                            <div class="title_style4 noselect">اطلاعات کاربر درخواست کننده</div>
                        </li>

                        <li class="item  width100 nospace">
                            <p class="field_label">نام درخواست کننده</p>
                            <div class="item_inner">
                                <input disabled type="text" style="text-align: center"
                                       value="{{$credit->user->full_name}}">
                            </div>
                        </li>

                        <li class="item  width100 nospace">
                            <p class="field_label">وضعیت درخواست </p>
                            <div class="item_inner">
                                <input disabled type="text" style="text-align: center"
                                       value="{{$credit->status_request}}">
                            </div>
                        </li>

                        <li class="item  width100 nospace">
                            <p class="field_label">شماره کارت:</p>
                            <div class="item_inner">
                                <input disabled type="text" style="text-align: center"
                                       value="{{$credit->bankCart->format_cart_no}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label" style="text-align: center">شماره شبا:</p>
                            <div class="item_inner">
                                <input style="text-align: center" type="text" disabled
                                       value="{{$credit->bankCart->sheba_no}}">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">مبلغ درخواستی (تومان):</p>
                            <div class="item_inner">
                                <input style="text-align: center" type="text" data-mask="000.000.000.000.000"
                                       data-mask-reverse="true" disabled
                                       value="{{$credit->price}}">
                            </div>
                        </li>
                        <hr>
                        <p class="field_label">انتخاب وضعیت</p>
                        <li class="item width100 {{__('content.float')}}">
                            <div class='item_inner'>
                                <select name="status" class="js-example-basic-single">
                                    <option value="">انتخاب نمایید...</option>
                                    <option @if(old('status',$credit->status) == 'done') selected @endif value="done">
                                        تسویه
                                    </option>
                                    <option @if(old('status',$credit->status) == 'reject') selected @endif value="reject">
                                        رد
                                    </option>
                                </select>
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">شماره پیگیری</p>
                            <div class="item_inner">
                                <input style="text-align: center" name="tracking_code" type="text"
                                       data-mask-reverse="true"
                                       value="{{ old('tracing_code',$credit->tracking_code) }}">
                            </div>
                        </li>
                        <li class="item fright">
                            <input type="submit" name="submit" value="ثبت" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </form>
        </div>

    @endif

@endsection


{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}



@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}
