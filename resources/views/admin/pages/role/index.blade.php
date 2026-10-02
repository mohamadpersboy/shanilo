@extends('admin.master')
@section('content')
    @if(isset($data['roles']) && !$data['roles']->isEmpty())
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['list']['title']}}</p>
                    <p class="title2">{{$header['list']['description']}}</p>
                </div>

                <div class="title_style1 {{__('content.floatr')}} margint10" >
                    <a href="{{route('admin.role.create')}}" class=" btn btn-info btn-labeled btn_style2 green">
                        <b><i class="icon-plus2"></i></b>{{__('content.create_role')}}
                    </a>
                </div>
            </div>

            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.role.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="hr_style2 margint20">
            <div class="table_style1" id="redips-drag">
                <div data-loading='loadingDataTable'><div id='as-preloading-wrapper'><div class='as-preloader'><span></span><span></span><span></span><span></span><span></span><span></span></div></div></div>
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><i class="icon1 i-list-ol"></i></th>
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        <th>{{__('content.title_role')}}</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>{{__('content.tbl_date_modified')}}</th>
                        <th>{{__('content.edit')}}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{$header['list']['title']}}</p>
                <p class="title2">{{$header['list']['description']}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <div class="form_style2">
                <div class="result_style2 disable_max_width sign i">
                    <div class="text icon">هیچ موردی یافت نشد.</div>
                </div>
            </div><!--paper_style-->
        </div>
    @endif
@endsection

{{--Active Menu--}}
@section('admin.role.index','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--Sortable--}}
@section('sortable')
    @include('admin.developer.sortable')
@endsection
{{--End Sortable--}}

{{--DataTable--}}
@section('datatable_url')
    url :"{{route('admin.role.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    { data: 'check', name: 'check', orderable: false, searchable: false},
    { data: 'name', name: 'name' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}