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
                <li class="item {{__('content.float')}} width100 ">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">فروشگاه</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="shop_id" id="shop_id" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            @foreach($shops as $index=>$shop)
                                <option value="{{$shop->id}}">{{$shop->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 ">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">وضعیت تسویه</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="status" id="status" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            <option value="done">تسویه شد</option>
                            <option value="pending">در انتظار تسویه</option>
                            <option value="denied">رد شد</option>
                        </select>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 nospace">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">شماره پیگیری</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="tracking_code">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width50 ">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">از تاریخ</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" data-date-picker id="date_from">
                    </div>
                </li>
                <li class="item fright width50 nospace">
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
    @if(isset($checkouts) && $checkouts)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت درخواست های تسویه</p>
                    <p class="title2">لیست درخواست ها</p>
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
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
               {!! $view !!}
            </div><!--table_style1-->
        </div>
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت درخواست های تسویه</p>
                <p class="title2">لیست درخواست ها</p>
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
@section('admin.checkout.index','active')
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
                form.find('input[name="shop_id"]').val($("#shop_id").val());
                form.find('input[name="status"]').val($("#status").val());
                form.find('input[name="tracking_code"]').val($("#tracking_code").val());
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
