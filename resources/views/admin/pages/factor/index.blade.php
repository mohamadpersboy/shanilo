@extends('admin.master')
@section('content')
    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="title_style1">
                    <p class="title1">جستجوی فاکتور</p>
                </div><!--title_style1-->
                <hr class="hr_style1 margint5 marginb15">
                <form method="POST" id="search-form" class="form-inline" role="form">
                    {{csrf_field()}}
                    <div class="form_style2">
                        <ul class="list clearfix">
                            <li class="item fright width33_3">
                                <div class='item_inner'>
                                    <select name="user_id" class="js-example-basic-single" data-placeholder="انتخاب کاربر">
                                        <option value="">انتخاب کاربر</option>
                                        @foreach($data['users'] as $user)
                                            <option value="{{$user->id}}">{{$user->name}} - {{$user->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="item fright width33_3">
                                <div class="item_inner">
                                    <select name="factor_id" class="js-example-basic-single" data-placeholder="انتخاب شماره فاکتور">
                                        <option value="">انتخاب شماره فاکتور</option>
                                        @foreach($data['factors'] as $factor)
                                            <option value="{{$factor->id}}">{{$factor->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="item fright width33_3 nospace">
                                <div class="item_inner">
                                    <select name="pay_type_id" class="js-example-basic-single" data-placeholder="روش پرداخت">
                                        <option value="">روش پرداخت</option>
                                        <option value="1">پرداخت آنلاین</option>
                                        <option value="2">پرداخت با موجودی</option>
                                        <option value="3">پرداخت در محل</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div><!--form_style2-->
                    <hr class="hr_style1 margint5 marginb10">
                    <div class="btn_group_style1" id="viewport1">
                        <ul class="list clearfix">
                            <li class="item fright">
                                <input type="submit" value="جستجو نمائید" class="btn_style2 green search_button">
                            </li>
                            <li class="item fright"><button type="reset" class="btn_style2" onclick="clear_search()">لغو جستجو</button></li>
                        </ul>
                    </div><!--btn_group_style1-->
                </form>
            </div>



            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">مدیریت فاکتور های خرید محصول</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item fright">
                                @permission('delete.factor')
                                <a href="{{route('admin.factor.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                                @endpermission
                            </li>
                            <li class="item fright">
                                <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                                <a href="#" class="btn_style2 green data_table_load hide"><img src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}" /></a>
                            </li>
                            <li class="item fright">
                                <form id='frm_page_status' method='get'>
                                    <div class='select_style select_style2 height36'>
                                        <span class='select_label'>پیگیری نشده</span>
                                        <i class='select_arrow i-angle-down'></i>
                                        <select name='visited'>
                                            <option value='1' selected="selected" data-change-bgcolor='#e7f3fd'>پیگیری نشده</option>
                                            <option value='2' data-change-bgcolor='#e7fdeb'>پیگیری شده</option>
                                            <option value='3' data-change-bgcolor='#fde7e7'>لـــغو شـده</option>
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
                            @permission('delete.factor')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>مشخصات سفارش</th>
                            <th>مشخصات خریدار</th>
                            <th>تاریخ</th>
                            <th>روش پرداخت</th>
                            <th>وضعیت</th>
                            @permission('update.factor')
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
                        <p class="title1">{{__('content.management_factor')}}</p>
                        <p class="title2">لیست فاکتور ها</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_factor')}}</div>
                        </div>
{{--                        <a href="{{route('admin.factor.create')}}" class=" btn btn-info btn-labeled btn_style2 green"><b><i class="icon-plus2"></i></b>{{__('content.create_factor')}}</a>--}}
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_factor'))

{{--Active Menu--}}
@section('admin.factor.index','active')
{{--End Active Menu--}}

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.factor.DataTable')}}",
    data: function (d) {
    d.visited = $('select[name=visited]').val();
    d.factor_id = $('select[name=factor_id]').val();
    d.user_id = $('select[name=user_id]').val();
    d.pay_type_id = $('select[name=pay_type_id]').val();
    d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 3, "desc" ]],
    "columns": [
    @permission('delete.factor')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'order_detail', name: 'order_detail', orderable: false, searchable: false,class:'tright'},
    { data: 'order_user', name: 'order_user', orderable: false, searchable: false,class:'tright'},
    { data: 'created_at', name: 'created_at' },
    { data: 'pay_type', name: 'pay_type', orderable: true, searchable: true},
    { data: 'visited', name: 'visited', orderable: false, searchable: false,class:'color_bg_change'},
    @permission('update.factor')
    { data: 'edit', name: 'edit', orderable: false, searchable: false},
    @endpermission
    ],
    search: {
    "regex": true
    },
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
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });

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
        function clear_search(){
            document.getElementById("search-form").reset();
            $("span.select2-selection__rendered").each(function() {
                $(this).text($(this).closest('.select2-container').siblings('select').data('placeholder'));
            });
            $('.search_button').trigger('click');
        }
    </script>
@endsection

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}
