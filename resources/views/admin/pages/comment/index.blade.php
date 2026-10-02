@extends('admin.master')
@section('content')
    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_comment')}}</p>
                        <p class="title2">لیست نظرات</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item fright">
                                @permission('delete.comment')
                                <a href="{{route('admin.comment.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                                @endpermission
                            </li>
                            <li class="item fright">
                                <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                                <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                            </li>
                            <li class="item fright">
                                <form id='frm_page_status' method='get'>
                                    <div class='select_style select_style2 height36'>
                                        <span class='select_label'>همه موارد</span>
                                        <i class='select_arrow i-angle-down'></i>
                                        <select name='page_status'>
                                            <option value='' selected="selected" data-change-bgcolor='#fff'>همه موارد</option>
                                            <option value='pending'  data-change-bgcolor='#e7f3fd'>در انتظار تائید</option>
                                            <option value='confirmed' data-change-bgcolor='#e7fdeb'>تائید شده</option>
                                            <option value='denied' data-change-bgcolor='#EA6666'>رد شده</option>
                                        </select>
                                    </div><!--select_style2-->
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="hr_style2 margint20">
                <div class="table_style1">
                    <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            @permission('delete.comment')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>کاربر</th>
                            <th>محصول / فروشگاه</th>
                            <th>تاریخ ثبت نظر</th>
                            @permission('update.comment')
                            <th>{{__('content.tbl_status')}}</th>
                            <th>مشاهده نظر</th>
                            @endpermission
                        </tr>
                        </thead>
                    </table>
                </div><!--table_style1-->
            </div>


            <!--======================== MODAL ==========================-->
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
                        <p class="title1">{{__('content.management_comment')}}</p>
                        <p class="title2">لیست نظرات</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_comment')}}</div>
                        </div>
{{--                        <a href="{{route('admin.comment.create')}}" class=" btn btn-info btn-labeled btn_style2 green"><b><i class="icon-plus2"></i></b>{{__('content.create_comment')}}</a>--}}
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_comment'))

{{--Active Menu--}}
@section('admin.comment.index','active')
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
{{--End Delete Selected--}}

{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.comment.DataTable')}}",
    data: function (d) {
    d.status = $('select[name=page_status]').val();
    d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 2, "desc" ]],
    "columns": [
    @permission('delete.comment')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'user', name: 'user' , orderable: false, searchable: false},
    { data: 'title', name: 'title', orderable: false, searchable: false},
    { data: 'created_at', name: 'created_at' },
    @permission('update.comment')
    { data: 'status', name: 'status'},
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    @endpermission
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}

@section('js')
    <script>
        $(document).ready(function(){
            $('.select_style select:has(option[data-change-bgcolor])').change(function(){
                var $this = $(this);
                var option_color = $this.find("option:selected[data-change-bgcolor]").attr("data-change-bgcolor");
                var option_text = $this.find("option:selected[data-change-bgcolor]").text();
                if(option_color != ""){
                    $this.closest('form').trigger('submit');
                    $this.closest(".select_style").css("background-color",option_color);
                    $(".select_style .select_label").text(option_text);
                }
            });
            $('#frm_page_status').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });
        });

        $(document).ajaxComplete(function(){
            /////////////////////////////////////////////////////////////////////////
            // view_comment
            $(".show_msg").click(function(e){
                e.preventDefault();
                var $this = $(this);
                var text = $this.parent('a').siblings('.data_msg').html();
                $("#view_comment .content .text").html(text);
                modal_box('#view_comment');
            });
            $('.modal .modal_scroll,.modal .modal_close').click(function(){
                hide_modal("#view_comment");
                $("#view_comment .content .text").html('');
            });
            $(".modal .window").click(function(e){e.stopPropagation();});
        });
    </script>
@endsection