@extends('admin.master')
@section('content')
    @permission('create.faq')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_faq')}}</p>
            <p class="title2">{{__('content.create_faq')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.faq.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_faq')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="{{__('content.write_title_faq')}}">
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.content_faq')}}<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea name="description" class="autosize">{{ old('description') }}</textarea>
                        </div>
                    </li>
                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="ثبت اطلاعات" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    @endpermission

    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_faq')}}</p>
                        <p class="title2">{{__('content.list_of_faq')}}</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.faq')
                                <a href="{{route('admin.faq.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                            @permission('update.faq')
                            <th><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.faq')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>{{__('content.title_faq')}}</th>
                            <th>{{__('content.tbl_creation_date')}}</th>
                            <th>{{__('content.tbl_date_modified')}}</th>
                            @permission('update.faq')
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
                        <p class="title1">{{__('content.management_faq')}}</p>
                        <p class="title2">{{__('content.list_of_faq')}}</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_faq')}}</div>
                        </div>
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_faq'))

{{--Active Menu--}}
@section('admin.faq.index','active')
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
    url :"{{route('admin.faq.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.faq')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.faq')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'title', name: 'title' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.faq')
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

{{--Editor--}}
@section('editor')
    @include('admin.developer.tinymce')
@endsection
{{--End Editor--}}