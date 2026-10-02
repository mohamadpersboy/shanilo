@extends('admin.master')

@section('admin.tag2.index', 'active')

@section('content')

    @permission('create.tag2')
    <div class="paper_style1">
        <div class="title_style1 {{__('content.float')}}">
            <p class="title1">تگ محصولات - زیر گروه ها - ثبت زیر گروه جدید</p>
            <p class="title2">از این بخش میتوانید به لیست تگ محصولات سایت در زیر گروه ها آیتم جدید اضافه نمائید</p>
        </div>
        <div class="clear"></div>
        <hr class="hr_style1 marginb20 margint20">

        @include('admin.layouts.formResult')

        <form method="post" class="form_validationn" action="{{route('admin.tag2.store')}}" enctype="multipart/form-data" data-valid-form>
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <li class='item fright width100 pos_rel ltr'>
                        <p class='field_label'>گروه اصلی :<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <div class='select_style3 select_style tcenter ltr'>
                                <i class='select_arrow i-angle-down'></i>
                                <select data-select-box name='parent_id' class="ltr" data-valid-required>
                                    <option value=''>-- انتخاب گروه اصلی --</option>
                                    @foreach($data['categoriesFirstLevel'] as $tag)
                                        <option value='{{ $tag->id }}' @if($tag->id == old('parent_id')) selected="selected" @endif>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div><!--select_style3-->
                        </div>
                    </li>

                    <li class="item fright width100">
                        <p class="field_label">عنوان :<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="name" value="{{old('name')}}" data-valid-required>
                        </div>
                    </li>

                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    @endpermission

    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">لیست زیر گروه های ثبت شده</p>
                <p class="title2">از این بخش میتوانید لیست زیر گروه های ثبت شده در تگ محصولات را مشاهده
                    نمائید</p>
            </div>

        </div>

        <hr class="hr_style2 margint30">

        <div class="clearfix">
            <div class="btn_group_style1 {{__('content.float')}}">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}}">
                        @permission('delete.tag')
                        <a href="{{route('admin.tag2.destroy', ['tag' => 'all'])}}" data-colspan="6"
                           class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i
                                    class="icon i-trash-o"></i></a>
                        @endpermission
                    </li>
                    <li class="item {{__('content.float')}}">
                        <a href="#" class="btn_style2 green refresh_table"><i class="icon icon-sync"></i></a>
                        <a href="#" class="btn_style2 green data_table_load hide"><img
                                    src="{{asset('assets/admin/_images/loading/ajax-loader.gif')}}"/></a>
                    </li>
                    <li class="item fright" id="frm_list_search">
                        <form id='frm_page_status' method='get'>
                            <div class='select_style select_style2 height36'>
                                <span class='select_label'>همه موارد</span>
                                <i class='select_arrow i-angle-down'></i>
                                <select name='parent_id' data-select-style>
                                    <option value='' selected="selected">همه موارد</option>
                                    @foreach($data['categoriesFirstLevel'] as $tag)
                                        <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                                    @endforeach
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
                    @permission('update.tag2')
                    <th class="width15"><i class="icon1 i-list-ol"></i></th>
                    @endpermission
                    @permission('delete.tag2')
                    <th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name=""
                                                                                      data-select-all="data-select-row"><span
                                    class="box"></span></label></th>
                    @endpermission
                    <th class="width30">عنوان</th>
                    <th class="width30">گروه</th>
                    <th class="width30">تعداد محصولات</th>
                    @permission('update.tag2')
                    <th>{{__('content.status')}}</th>
                    <th>{{__('content.edit')}}</th>
                    @endpermission
                </tr>
                </thead>
            </table>
        </div><!--table_style1-->
    </div>
@endsection

{{--Delete Selected--}}
@section('delete_selected')
    @include('admin.developer.delete_selected')
@endsection
{{--End Delete Selected--}}

{{--DataTable--}}
@section('datatable_url_data')
    url :"{{route('admin.tag2.data-table')}}",
    data: function (d) {
        d.parent_id = $('#frm_list_search select[name=parent_id]').val();
        d._token = _token;
    },
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.tag2')
    { data: 'position', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.tag2')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'name', name: 'name', orderable: false, searchable: false },
    { data: 'parent_id', name: 'parent_id', orderable: false, searchable: false },
    { data: 'product_count', name: 'product_count', orderable: false, searchable: false },
    @permission('update.tag2')
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

{{--Switchery--}}
@section('switching')
    @include('admin.developer.switching')
@endsection
{{--End Switchery--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

@section('js')
    <script>
        $(document).ready(function() {
            $('#frm_list_search select').on('change', function(e) {
                table.draw();
                e.preventDefault();
            });
        });
    </script>
@endsection

