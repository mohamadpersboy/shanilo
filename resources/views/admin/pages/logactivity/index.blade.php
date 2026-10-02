@extends('admin.master')
@section('content')
    @if(isset($data['logactivity']) && !$data['logactivity']->isEmpty())
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['list']['title']}}</p>
                    <p class="title2">{{$header['list']['description']}}</p>
                </div>
            </div>

            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.logactivity.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                <table id="data_table" class="display data_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        <th>توضیحات</th>
                        <th>تاریخ فعالیت</th>
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
@section('admin.logactivity.index','active')
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
    url :"{{route('admin.logactivity.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 2, "desc" ]],
    "columns": [
        { data: 'check', name: 'check', orderable: false, searchable: false},
        { data: 'show_description', name: 'show_description', orderable: false, searchable: false,class:'tright'},
        { data: 'created_at', name: 'created_at'},
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}