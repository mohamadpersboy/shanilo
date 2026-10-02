@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">جستجوی پیشرفته</p>
            <p class="title2">جستجوی پیشرفته محصولات</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <div class="form_style2">
            {!! Form::open([
            'id'=>'search-form'
            ]) !!}
            <ul class="list clearfix">
                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">عنوان محصول</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <input type="text" id="title">
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">فروشگاه</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="shop" id="shop" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            @foreach($shops as $index=>$shop)
                                <option value="{{$shop->id}}">{{$shop->title}}</option>
                            @endforeach

                        </select>
                    </div>
                </li>
                <li class="item fleft width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">کاربر</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="user" id="user" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            @foreach($users as $index=>$user)
                                <option value="{{$user->id}}">{{getUsersFullName($user)}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl40">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">دسته بندی</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="category" id="category" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            @foreach($categories as $index=>$category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach

                        </select>
                    </div>
                </li>
                <li class="item {{__('content.float')}} width30 marginl30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">نوع فروش</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="sellType" id="sellType" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            <option value="specialSell">فروش ویژه</option>
                            <option value="specialSuggestion">پیشنهاد ویژه</option>
                        </select>
                    </div>
                </li>
                <li class="item fleft width30">
                    <hr class="hr_style2 margint15">
                    <p class="title_style4">وضعیت</p>
                    <hr class="hr_style2 margint15">
                    <div class="item_inner">
                        <select name="display" id="display" class="js-example-basic-single">
                            <option value="">انتخاب کنید</option>
                            <option value="1">تایید شده</option>
                            <option value="0">در انتظار تایید</option>
                        </select>
                    </div>
                </li>
            </ul>
            <hr class="hr_style1 marginb20 margint20">
            <div class="btn_group_style1">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}}">
                        <input type="submit" name="submit" value="{{__('content.search')}}" class="btn_style2 green">
                    </li>
                </ul>
            </div>
            {!! Form::close() !!}
        </div><!--paper_style-->
    </div>
    @if(isset($products) && $products)
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">مدیریت محصولات وبسایت</p>
                    <p class="title2">نمایش محصولات</p>
                </div>
            </div>
            <hr class="hr_style2 margint30">
            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            @permission('delete.product')
                            <a href="{{route('admin.product.destroy','all')}}" data-colspan="6"
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
                        @permission('update.product')
                        <th><i class="icon1 i-list-ol"></i></th>
                        @endpermission
                        @permission('delete.product')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>{{__('content.tbl_image')}}</th>
                        <th>{{__('content.tbl_title')}}</th>
                        <th>فروشگاه</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>{{__('content.tbl_date_modified')}}</th>
                        @permission('update.product')
                        <th>{{__('content.status')}}</th>
                        <th>نمایش</th>
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
                <p class="title1">مدیریت محصولات وبسایت</p>
                <p class="title2">نمایش محصولات</p>
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
@section('admin.product.index','active')
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
@section('datatable_url_data')
    url :"{{route('admin.product.DataTable')}}",
    data: function (d) {
    d.title = $('#title').val();
    d.category = $('#category').val();
    d.user = $('#user').val();
    d.shop = $('#shop').val();
    d.display = $('#display').val();
    d.sellType = $('#sellType').val();
    d._token = _token;
    },
@endsection
{{--DataTable--}}
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.product')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.product')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'image', name: 'image', orderable: false, searchable: false},
    { data: 'title', name: 'title' },
    { data: 'shop_id', name: 'shop.title' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.product')
    { data: 'display', name: 'display'},
    { data: 'show', name: 'show', orderable: false, searchable: false},
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
    @include('admin.developer.select2')
@endsection