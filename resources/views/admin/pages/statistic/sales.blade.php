@extends('admin.master')
@section('css')

@endsection
@section('content')
<section class='product_list_part1'>
    <div class='paper_style1'>
        <div class='title_style1'>
            <p class='title1'>جستجوی گزارش فروش کالا</p>
        </div><!--title_style1-->
        <hr class='hr_style1 margint5 marginb15' />
        <form method="POST" id="search-form" class="form-inline" role="form">
            {{csrf_field()}}
            <div class='form_style2'>
                <ul class='list clearfix' data-catpro-select>
                    <li class='item fright width33_3'>
                        <div class='item_inner'>
                            <input type='text' name='s_model' value='' placeholder='جستجو بر اساس: مدل محصول ...'>
                        </div>
                    </li>
                    <li class='item select width33_3 fright'>
                        <div class='item_inner'>
                            <div class='select_style3 select_style tcenter'>
                                <i class='select_arrow i-angle-down'></i>
                                <select data-select-box name='s_brand' data-cat1pro-select='انتخاب برند محصول'>
                                    <option value=''>-- انتخاب برند محصول --</option>
                                    @foreach($data['brands'] as $brand)
                                        <option value='{{$brand->id}}'>{{$brand->title}} - {{$brand->title_en}}</option>
                                    @endforeach
                                </select>
                            </div><!--select_style3-->
                        </div>
                    </li>
                    <li class='item select width33_3 fright nospace'>
                        <div class='item_inner'>
                            <div class='select_style3 select_style tcenter'>
                                <i class='select_arrow i-angle-down'></i>
                                <select data-select-box name='s_category' data-cat2pro-select>
                                    <option value=''>-- انتخاب نوع محصول --</option>
                                    @foreach($data['categories'] as $category)
                                        <option value='{{$category->id}}'>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div><!--select_style3-->
                        </div>
                    </li>
                    <li class='item width50 fright'>
                        <p class='field_label'>روش ارسال:</p>
                        <div class='item_inner'>
                            <div class='select_style3 select_style'>
                                <i class='select_arrow i-angle-down'></i>
                                <select data-select-box name='s_send'>
                                    <option value=''>-- انتخاب نمائید --</option>
                                     @foreach($data['send_types'] as $send_type)
                                        <option value='{{$send_type->id}}'>{{$send_type->title}}</option>
                                     @endforeach
                                </select>
                            </div><!--select_box_style1-->
                        </div>
                    </li>
                    <li class='item width50 fright nospace'>
                        <p class='field_label'>روش پرداخت:</p>
                        <div class='item_inner'>
                            <div class='select_style3 select_style'>
                                <i class='select_arrow i-angle-down'></i>
                                <select data-select-box name='s_pay'>
                                    <option value=''>-- انتخاب نمائید --</option>
                                    @foreach($data['pay_types'] as $pay_type)
                                        <option value='{{$pay_type->id}}'>{{$pay_type->title}}</option>
                                    @endforeach
                                </select>
                            </div><!--select_box_style1-->
                        </div>
                    </li>
                    <li class='item fright width50'>
                        <p class='field_label'>از تاریخ :</p>
                        <input type='text' name='s_date_from' id='s_date_from' data-date-picker value='' class='tcenter' autocomplete='off' >
                    </li>
                    <li class='item fright width50 nospace'>
                        <p class='field_label'>تا تاریخ :</p>
                        <input type='text' name='s_date_to' id='s_date_to' data-date-picker value='' class='tcenter' autocomplete='off' >
                    </li>
                </ul>
            </div><!--form_style2-->
            <hr class='hr_style1 margint5 marginb10'/>
            <div class='btn_group_style1' id='viewport1'>
                <ul class='list clearfix'>
                    <li class='item fright'>
                        <input type='submit' value='جستجو نمائید' class='btn_style2 green'>
                    </li>
                    
                    <li class='item fright'><a href='' class='btn_style2'>لغو جستجو</a></li>
                </ul>
            </div><!--btn_group_style1-->
        </form>
    </div><!--paper_style1-->
</section><!--product_list_part1-->

<section class='product_list_part2'>
    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">لیست کالاهای فروخته شده</p>
                <p class="title2">لیست کالاهای فروخته شده را میتوانید از این قسمت مشاهده نمائید</p>
            </div>

        </div>

        <hr class="hr_style2 margint30">

        <div class="clearfix">
            <div class="btn_group_style1 {{__('content.float')}}">
                <ul class="list clearfix">
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
                        <th>عکس محصول</th>
                        <th>برند - مدل - قیمت</th>
                        <th>تعداد فروش</th>
                        <th>درآمد - تومان</th>
                    </tr>
                </thead>
            </table>
        </div><!--table_style1-->
    </div>
</section>
@endsection

{{--Active Menu--}}
@section('admin.statistic.sales','active')
{{--End Active Menu--}}

@section('datePicker')
    @include('admin.developer.datepicker')
@endsection

{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.statistic.DataTable')}}",
    data: function (d) {
    d.s_model = $('input[name=s_model]').val();
    d.s_brand = $('select[name=s_brand]').val();
    d.s_category = $('select[name=s_category]').val();
    d.s_send = $('select[name=s_send]').val();
    d.s_pay = $('select[name=s_pay]').val();
    d.s_date_from = $('input[name=s_date_from]').val();
    d.s_date_to = $('input[name=s_date_to]').val();
    d._token = _token;
    },
@endsection
@section('datatable_source')
    {{-- "order": [[ 0, "asc" ]], --}}
    "columns": [
    { data: 'image', name: 'image', orderable: false, searchable: false},
    { data: 'product_info', name: 'product_info', orderable: false, searchable: false, class:'tright info'},
    { data: 'total_quantity', name: 'total_quantity', orderable: true, searchable: false},
    { data: 'total_price', name: 'total_price', orderable: true, searchable: false},
    ],
@endsection
@section('datatable')
    @include('admin.developer.datatable')
@endsection
{{--End DataTable--}}

@section('js')
    <script>
        $(document).ready(function(){
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });
        });
    </script>
@endsection