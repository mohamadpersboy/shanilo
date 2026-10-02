@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">جستجوی پیشرفته</p>
            <p class="title2">جستجوی پیشرفته سفارشات</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <div class="form_style2">
            {!! Form::open([
            'id'=>'search-form'
            ]) !!}
            <ul class="list clearfix">
                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">نام کاربر</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="name">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">نام خانوادگی کاربر</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="family">
                    </div>
                </li>
                <li class="item fleft width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره همراه کاربر</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="mobile">
                    </div>
                </li>

                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره فاکتور</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="order_id">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">وضعیت فاکتور</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="status" id="status" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            <option value="0">کنسل</option>
                            <option value="1">ثبت شده</option>
                            <option value="2">تایید شده</option>
                            <option value="3">تماس بین مشتری و فروشگاه</option>
                            <option value="4">ارسال شده</option>
                            <option value="5">دریافت شده</option>
                        </select>
                    </div>
                </li>
                <li class="item fleft width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">وضعیت پرداخت</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="payment_status" id="payment_status" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            <option value="pending">در انتظار پرداخت</option>
                            <option value="successful">موفق</option>
                            <option value="unsuccessful">ناموفق</option>
                        </select>
                    </div>
                </li>

                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">از تاریخ</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" data-date-picker id="date_from">
                    </div>
                </li>
                <li class="item fright width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">تا تاریخ</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" data-date-picker id="date_to">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginr40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره پیگیری تراکنش</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="tracking_code">
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
    @if(isset($orders) && $orders)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت سفارشات</p>
                    <p class="title2">نمایش سفارشات</p>
                </div>
            </div>

            <hr class="hr_style2 margint30">


            <hr class="hr_style2 margint20">
            <div class="table_style1">
                {!! $view !!}
            </div><!--table_style1-->
        </div>
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت سفارشات</p>
                <p class="title2">نمایش سفارشات</p>
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
@section('admin.order.index','active')
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


{{--Sortable--}}
@section('sortable')
    @include('admin.developer.sortable')
@endsection
{{--End Sortable--}}
@section('js')
    @include('admin.developer.select2')
    <script>
        $(function () {
           $('button#export').on('click',function (e) {
               e.preventDefault();
               var form=$(this).closest('form');
               form.find('input[name="name"]').val($("#name").val());
               form.find('input[name="family"]').val($("#family").val());
               form.find('input[name="mobile"]').val($("#mobile").val());
               form.find('input[name="order_id"]').val($("#order_id").val());
               form.find('input[name="status"]').val($("#status").val());
               form.find('input[name="payment_type"]').val($("#payment_type").val());
               form.find('input[name="date_from"]').val($("#date_from").val());
               form.find('input[name="date_to"]').val($("#date_to").val());
               form.submit();
           })
        });
    </script>
@endsection
@section('datePicker')
    @include('admin.developer.datepicker')
@endsection
