@extends('admin.master')
@section('content')
    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_videogallery')}}</p>
                        <p class="title2">{{__('content.list_of_videogallery')}}</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.videogallery')
                                <a href="{{route('admin.videogallery.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                            @permission('update.videogallery')
                            <th><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.videogallery')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>{{__('content.image_videogallery')}}</th>
                            <th>{{__('content.tbl_creation_date')}}</th>
                            <th>{{__('content.tbl_date_modified')}}</th>
                            @permission('update.videogallery')
                            <th>{{__('content.status')}}</th>
                            <th>{{__('content.edit')}}</th>
                            @endpermission
                        </tr>
                        </thead>
                    </table>
                </div><!--table_style1-->
            </div>

        @else
                <div class="paper_style1">
                    <div class="title_style1">
                        <p class="title1">{{__('content.management_videogallery')}}</p>
                        <p class="title2">{{__('content.list_of_videogallery')}}</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_videogallery')}}</div>
                        </div>
                        <a href="{{route('admin.videogallery.create')}}" class=" btn btn-info btn-labeled btn_style2 green"><b><i class="icon-plus2"></i></b>{{__('content.create_videogallery')}}</a>
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_videogallery'))

{{--Active Menu--}}
@section('video-gallery','active')
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
    url :"{{route('admin.videogallery.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.videogallery')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.videogallery')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'image', name: 'image', orderable: false, searchable: false},
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.videogallery')
    { data: 'display', name: 'display'},
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
