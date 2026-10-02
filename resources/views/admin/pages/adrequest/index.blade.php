@extends('admin.master')
@section('content')

    @if(isset($data['adrequests']) && !$data['adrequests']->isEmpty())
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
                            @permission('delete.adrequest')
                            <a href="{{route('admin.adrequest.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                            @endpermission
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                            <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                        </li>
                        <li class="item fright">
                            <form id='frm_page_status' method='get'>
                                <div class='select_style select_style2 height36'>
                                    <span class='select_label'>پیگیری نشده</span>
                                    <i class='select_arrow i-angle-down'></i>
                                    <select name='status'>
                                        <option value='1' selected="selected" data-change-bgcolor='#e7f3fd'>پیگیری نشده</option>
                                        <option value='2' data-change-bgcolor='#e7fdeb'>پیگیری شده</option>
                                        <option value='4' data-change-bgcolor='#fff'>همه موارد</option>
                                    </select>
                                </div><!--select_style2-->
                            </form>
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
                        @permission('delete.adrequest')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>اطلاعات درخواست</th>
                        <th>اطلاعات شخص</th>
                        {{-- <th>کاربر رسمی سایت</th> --}}
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>وضعیت</th>
                        @permission('update.adrequest')
                        <th>ثبت تبلیغ</th>
                        @endpermission
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
@section('admin.adrequest.index','active')
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
@section('datatable_url_data')
    url :"{{route('admin.adrequest.DataTable')}}",
    data: function (d) {
        d.status = $('select[name=status]').val();
        d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('delete.adrequest')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'planDetail', name: 'planDetail', orderable: false, searchable: false,class:'tright'},
    { data: 'userDetail', name: 'userDetail', orderable: false, searchable: false,class:'tright'},
    {{-- { data: 'user_id', name: 'user_id'}, --}}
    { data: 'created_at', name: 'created_at' },
    { data: 'status', name: 'status', orderable: false, searchable: false,class:'color_bg_change'},
    @permission('update.adrequest')
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
