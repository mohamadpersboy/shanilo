@extends('admin.master')
@section('content')
    @if(isset($messages) && $messages)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت پیامهای وبسایت</p>
                    <p class="title2">لیست پیامهای وبسایت</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            @permission('delete.message')
                            <a href="{{route('admin.message.destroy','all')}}" data-colspan="6"
                               class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i
                                        class="icon i-trash-o"></i></a>
                            @endpermission
                        </li>
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
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @permission('delete.message')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>جدید</th>
                        <th>ارسال کننده</th>
                        <th>دریافت کننده</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        @permission('update.message')
                        <th>خواندن پیام و پاسخ</th>
                        @endpermission
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>

    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت پیامهای وبسایت</p>
                <p class="title2">لیست پیامهای وبسایت</p>
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
@section('admin.message.index','active')
@section('admin.message','active')
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

{{--DataTable--}}
@section('datatable_url')
    url :"{{route('admin.message.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('delete.message')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'id', name: 'id' },
    { data: 'user_id', name: 'user_id' },
    { data: 'receiver_id', name: 'receiver_id' },
    { data: 'created_at', name: 'created_at' },
    @permission('update.message')
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    @endpermission
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
