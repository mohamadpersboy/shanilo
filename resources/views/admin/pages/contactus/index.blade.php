@extends('admin.master')
@section('content')
    @if(isset($data['contactUsMessages']) && !$data['contactUsMessages']->isEmpty())
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت پیامهای تماس با ما</p>
                    <p class="title2">پیامهای تماس باما</p>
                </div>
            </div>

            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        @permission('delete.contact')
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.contactUs.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                        </li>
                        @endpermission
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1">
                <div data-loading='loadingDataTable'><div id='as-preloading-wrapper'><div class='as-preloader'><span></span><span></span><span></span><span></span><span></span><span></span></div></div></div>
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @permission('delete.contact')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>ارسال کننده</th>
                        <th>تاریخ ایجاد</th>
                        @permission('update.contact')
                        <th>خواندن پیام</th>
                        @endpermission
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>

    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت پیامهای تماس با ما</p>
                <p class="title2">پیامهای تماس باما</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <div class="form_style2">
                <div class="result_style2 disable_max_width sign i">
                    <div class="text icon">هیچ پیامی یافت نشد.</div>
                </div>
            </div><!--paper_style-->
        </div>
    @endif
@endsection


@section('PageHeading',__('content.management_contact'))

{{--Active Menu--}}
@section('admin.message','active')
@section('admin.contact.message','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--DataTable--}}
@section('datatable_url')
    url :"{{route('admin.contactUs.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 2, "desc" ]],
    "columns": [
    @permission('delete.contact')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'name', name: 'name' },
    { data: 'created_at', name: 'created_at' },
    @permission('update.contact')
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
