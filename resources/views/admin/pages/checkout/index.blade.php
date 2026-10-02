@extends('admin.master')
@section('content')
    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_checkout')}}</p>
                        <p class="title2">لیست درخواست های تسویه حساب</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item fright">
                                @permission('delete.checkout')
                                <a href="{{route('admin.course.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                                @endpermission
                            </li>
                            <li class="item fright">
                                <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                                <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                            </li>
                            <li class="item fright">
                                <form id='frm_page_status' method='get'>
                                    <div class='select_style select_style2 height36'>
                                        <span class='select_label'>در انتظار تائید</span>
                                        <i class='select_arrow i-angle-down'></i>
                                        <select name='page_status'>
                                            <option value='1' selected="selected" data-change-bgcolor='#e7f3fd'>در انتظار تائید</option>
                                            <option value='2' data-change-bgcolor='#e7fdeb'>تائید شده</option>
                                            <option value='3' data-change-bgcolor='#fde7e7'>تائید نشده</option>
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
                    <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            @permission('delete.checkout')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>مبلغ درخواستی (تومان)</th>
                            <th>نوع درخواست</th>
                            <th>تاریخ درخواست</th>
                            <th>وضعیت</th>
                            @permission('update.checkout')
                            <th>جزئیات</th>
                            @endpermission
                        </tr>
                        </thead>
                    </table>
                </div><!--table_style1-->
            </div>

        @else
                <div class="paper_style1">
                    <div class="title_style1">
                        <p class="title1">{{__('content.management_checkout')}}</p>
                        <p class="title2">لیست درخواست های تسویه حساب</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_checkout')}}</div>
                        </div>
{{--                        <a href="{{route('admin.checkout.create')}}" class=" btn btn-info btn-labeled btn_style2 green"><b><i class="icon-plus2"></i></b>{{__('content.create_checkout')}}</a>--}}
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_checkout'))

{{--Active Menu--}}
@section('admin.checkout.index','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.checkout.DataTable')}}",
    data: function (d) {
    d.status = $('select[name=page_status]').val();
    d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 3, "asc" ]],
    "columns": [
    @permission('delete.checkout')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'price', name: 'price' },
    { data: 'pay_type', name: 'pay_type' },
    { data: 'created_at', name: 'created_at' },
    { data: 'pay_status', name: 'pay_status', orderable: true, searchable: true,class:'color_bg_change'},
    @permission('update.checkout')
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
    </script>
@endsection
