@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">جستجوی پیشرفته</p>
            <p class="title2">جستجوی پیشرفته پرداختها</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <div class="form_style2">
            {!! Form::open([
            'id'=>'search-form'
            ]) !!}
            <ul class="list clearfix">
                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">از بابت</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="payable_type" id="payable_type" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            @foreach($types as $index=>$type)
                                <option value="{{$index}}">{{$type}}</option>
                            @endforeach

                        </select>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره تراکنش</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="transaction_id">
                    </div>
                </li>
                <li class="item fleft width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره پیگیری</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="tracking_code">
                    </div>
                </li>

                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره مرجع تراکنش</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="ref_id">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">نوع پرداخت</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="pay_type_id" id="pay_type_id" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            @foreach($payTypes as $index=>$payType)
                                <option value="{{$payType->id}}">{{$payType->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li class="item fleft width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">وضعیت پرداخت</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="status" id="status" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            <option value="successful">موفق</option>
                            <option value="unsuccessful">ناموفق</option>
                            <option value="pending">در انتظار پرداخت</option>
                        </select>
                    </div>
                </li>

                <li class="item {{__('content.float')}} width50">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">از تاریخ</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" data-date-picker id="date_from">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 nospace">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">تا تاریخ</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" data-date-picker id="date_to">
                    </div>
                </li>
            </ul>
            <hr class="hr_style1 marginb20 margint20">
            <div class="btn_group_style1">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}}">
                        <input type="submit" name="submit" value="{{__('content.search')}}" class="btn_style2 green">
                    </li>
                </ul>
            </div>
            {!! Form::close() !!}
        </div><!--paper_style-->
    </div>
    @if(isset($payments) && $payments)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت پرداخت ها</p>
                    <p class="title2">نمایش پرداخت ها</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img
                                        src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}"/></a>
                        </li>
                        {{--<li class="item {{__('content.float')}}">
                            <form id='frm_page_status' method='get'>
                                <div class='select_style select_style2 height36'>
                                    <span class='select_label'>در انتظار تایید</span>
                                    <i class='select_arrow i-angle-down'></i>
                                    <select name='status'>
                                        <option value='pending' selected="selected" data-change-bgcolor='#c8a878'>در انتظار تایید</option>
                                        <option value='sent' data-change-bgcolor='#78c88d'>ارسال شده</option>
                                        <option value='denied' data-change-bgcolor='#c87878'>رد شده</option>
                                    </select>
                                </div><!--select_style2-->
                            </form>
                        </li>--}}
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>وضعیت پرداخت</th>
                        <th>از بابت</th>
                        <th>نوع پرداخت</th>
                        <th>شماره تراکنش</th>
                        <th>شماره مرجع تراکنش</th>
                        <th>شماره پیگیری</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت پرداخت ها</p>
                <p class="title2">نمایش پرداخت ها</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <div class="form_style2">
                <div class="result_style2 disable_max_width sign i">
                    <div class="text icon">در حال حاضر هیچ آیتمی وجود ندارد.</div>
                </div>
            </div><!--paper_style-->
        </div>
    @endif
@endsection

{{--Active Menu--}}
@section('admin.payment.index','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--Switchery--}}
@section('switching')
    @include('admin.developer.switching')
@endsection
{{--End Switchery--}}
@section('datatable_options')
    "searching":false,
@endsection
{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.payment.DataTable')}}",
    data: function (d) {
        d.payable_type = $('#payable_type').val();
        d.status = $('#status').val();
        d.order_id = $('#order_id').val();
        d.pay_type_id= $('#pay_type_id').val();
        d.transaction_id= $('#transaction_id').val();
        d.tracking_code= $('#tracking_code').val();
        d.ref_id= $('#ref_id').val();
        d.date_from = $('#date_from').val();
        d.date_to = $('#date_to').val();
        d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    { data: 'status', name: 'status' },
    { data: 'payable_type', name: 'payable_type' },
    { data: 'pay_type_id', name: 'pay_type_id' },
    { data: 'transaction_id', name: 'transaction_id' },
    { data: 'ref_id', name: 'ref_id' },
    { data: 'tracking_code', name: 'tracking_code' },
    { data: 'created_at', name: 'created_at' },
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}

{{--Sortable--}}
@section('sortable')
    @include('admin.developer.sortable')
@endsection
{{--End Sortable--}}
@section('js')
    @include('admin.developer.select2')
@endsection
@section('datePicker')
    @include('admin.developer.datepicker')
@endsection