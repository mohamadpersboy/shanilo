@extends('admin.master')
@section('content')
    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_user')}}</p>
                        <p class="title2">{{__('content.list_of_user')}}</p>
                    </div>

                    <div class="title_style1 fleft margint10">
                        <form method="post" class="form-horizontal form-contact-us-validation"
                              action="{{route('admin.user.export')}}">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-info btn-labeled btn-xs mg-bottom-3  mg-left-3">
                                <b><i class="icon-file-excel"></i></b>{{__('content.export_excel')}}
                            </button>
                        </form>
                    </div>
                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.user')
                                <a href="{{route('admin.user.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                                @endpermission
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                                <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="hr_style2 margint20">
                <div class="table_style1">
                    <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            @permission('delete.user')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>نام</th>
                            <th>ایمیل</th>
                            <th>لاگین</th>
                            <th>تایید شده</th>
                            <th>تاریخ ایجاد</th>
                            @permission('update.user')
                            <th>ویرایش</th>
                            @endpermission
                        </tr>
                        </thead>
                    </table>
                </div><!--table_style1-->
            </div>

        @else
                <div class="paper_style1">
                    <div class="title_style1">
                        <p class="title1">{{__('content.management_user')}}</p>
                        <p class="title2">{{__('content.list_of_user')}}</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_user')}}</div>
                        </div>
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_user'))

{{--Active Menu--}}
@section('admin.user','active')
@section('admin.user.index','active')
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
    url :"{{route('admin.user.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 3, "asc" ]],
    "columns": [
    @permission('delete.user')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'name', name: 'name' },
    { data: 'email', name: 'email' },
    { data: 'login', name: 'login',orderable: false, searchable: false },
    { data: 'confirmed_by_admin', name: 'confirmed_by_admin',orderable: false, searchable: false },
    { data: 'created_at', name: 'created_at' },
    @permission('update.user')
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
