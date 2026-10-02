@extends('admin.master')
@section('content')
    @if(isset($violationReports) && $violationReports)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت گزارشات تخلف</p>
                    <p class="title2">لیست گزارشات</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">
            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            @permission('delete.violationreport')
                            <a href="{{route('admin.violationReport.destroy','all')}}" data-colspan="6"
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
                        @permission('update.violationreport')
                        <th><i class="icon1 i-list-ol"></i></th>
                        @endpermission
                        @permission('delete.violationreport')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name=""
                                                                          data-select-all="data-select-row"><span
                                        class="box"></span></label></th>
                        @endpermission
                        <th>نوع گزارش</th>
                        <th>گزارش کننده</th>
                        <th>{{__('content.tbl_title')}}</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>{{__('content.tbl_link')}}</th>
                        <th>توضیحات</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table_style1-->
        </div>
        <div class='modal modal_over'>
            <div class='modal_scroll'>
                <div class='modal_dynamic'></div><!--modal_dynamic-->

                <div class='modal_static'>

                    <div class='window modalwin_style2' id='view_comment' style='width:600px;'>
                        <i class='modal_close'>X</i>
                        <div class='inner'>
                            <h4 class='title'>مشاهده نظر کاربر</h4>
                            <div class='content'>
                                <p class='text noselect'></p>
                            </div>
                        </div>
                    </div><!--window-->

                </div><!--modal_static-->
            </div><!--modal_scroll-->
        </div><!--modal-->
    @else
        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">مدیریت گزارشات تخلف</p>
                <p class="title2">لیست گزارشات</p>
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
@section('admin.message','active')
@section('admin.violationreport.index','active')
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
    url :"{{route('admin.violationReport.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.violationreport')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.violationreport')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'type', name: 'type',orderable: false, searchable: false },
    { data: 'user_id', name: 'user_id',orderable: false, searchable: false },
    { data: 'title', name: 'title',orderable: false, searchable: false },
    { data: 'created_at', name: 'created_at',orderable: false, searchable: false },
    { data: 'url', name: 'url',orderable: false, searchable: false },
    { data: 'show', name: 'show', orderable: false, searchable: false},
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
@section('js')
    <script>
        $(document).ajaxComplete(function () {
            /////////////////////////////////////////////////////////////////////////
            // view_comment
            $(".show_msg").click(function (e) {
                e.preventDefault();
                var $this = $(this);
                var text = $this.parent('a').siblings('.data_msg').html();
                $("#view_comment .content .text").html(text);
                modal_box('#view_comment');
                if ($(this).closest('tr').find('span.label.label-info').length) {
                    var span = $(this).closest('tr').find('span.label.label-info').hide();
                    $.ajax({
                        url: span.data('url'),
                        type: 'POST',
                        data: {
                            _method: 'PATCH',
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            seen: 1
                        },
                        success: function (response) {

                        }, error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });
            $('.modal .modal_scroll,.modal .modal_close').click(function () {
                hide_modal("#view_comment");
                $("#view_comment .content .text").html('');
            });
            $(".modal .window").click(function (e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection
