@extends('admin.master')

@section('admin.tag.index', 'active')

@section('content')

    @permission('create.tag')
    <div class="paper_style1">
        <div class="title_style1 {{__('content.float')}}">
            <p class="title1">تگ محصولات - گروه اصلی - ثبت گروه جدید</p>
            <p class="title2">از این بخش میتوانید به لیست تگ محصولات سایت در گروه اصلی آیتم جدید اضافه نمائید</p>
        </div>
        <div class="clear"></div>
        <hr class="hr_style1 marginb20 margint20">

        @include('admin.layouts.formResult')

        <form method="post" class="form-horizontal form-contact-us-validation"
              action="{{route('admin.tag.store')}}" enctype="multipart/form-data" data-valid-form>
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

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
                            <input type="submit" name="submit" value="{{__('content.save_changes')}}"
                                   class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    @endpermission


    @if(isset($tags))
        @if($tags->isNotEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">لیست گروه های ثبت شده</p>
                        <p class="title2">از این بخش میتوانید لیست گروه اصلی ثبت شده در تگ محصولات را مشاهده
                            نمائید</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.tag')
                                <a href="{{route('admin.tag.destroy', ['tag' => 'all'])}}" data-colspan="6"
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
                            @permission('update.tag')
                            <th class="width15"><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.tag')
                            <th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th class="width30">عنوان</th>
                            <th class="width30">تعداد زیرگروه</th>
                            @permission('update.tag')
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
                    <p class="title1">لیست تگ های ثبت شده</p>
                    <p class="title2">از این بخش میتوانید لیست تگ اصلی ثبت شده در تگ محصولات را مشاهده
                        نمائید</p>
                </div><!--title_style1-->

                <hr class="hr_style1 marginb20 margint20">

                <div class="form_style2">
                    <div class="result_style2 disable_max_width sign i">
                        <div class="text icon">آیتمی برای نمایش وجود ندارد ...</div>
                    </div>
                </div><!--paper_style-->
            </div>

        @endif
    @endif
@endsection

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
    url :"{{route('admin.tag.data-table')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.tag')
    { data: 'position', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.tag')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'name', name: 'name', orderable: false, searchable: false },
    { data: 'child_count', name: 'child_count', orderable: false, searchable: false },
    @permission('update.tag')
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
