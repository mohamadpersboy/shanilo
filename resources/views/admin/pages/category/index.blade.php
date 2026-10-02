@extends('admin.master')

@section('admin.category.index', 'active')

@section('content')

    @permission('create.category')
    <div class="paper_style1">
        <div class="title_style1 {{__('content.float')}}">
            <p class="title1">دسته بندی - گروه اصلی - ثبت گروه جدید</p>
            <p class="title2">از این بخش میتوانید به لیست دسته بندی سایت در گروه اصلی آیتم جدید اضافه نمائید</p>
        </div>
        <div class="clear"></div>
        <hr class="hr_style1 marginb20 margint20">

        @include('admin.layouts.formResult')

        <form method="post" class="form-horizontal form-contact-us-validation"
              action="{{route('admin.category.store')}}" enctype="multipart/form-data" data-valid-form>
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <li class="item fright width100">
                        <p class="field_label">عنوان :<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{old('title')}}" data-valid-required>
                        </div>
                    </li>

                    <li class='item fright width100' id='file_cropper'>
                        <div class='clearfix'></div>
                        <div class='title_style4'>{{__('content.image')}}<i class="required_style1">*</i></div>
                        <hr class='hr_style2 margint5'/>

                        {{--<p class='field_text'>--}}
                            {{--{{__('content.minimum_width_photo')}} : 250px /--}}
                            {{--{{__('content.minimum_height_photo')}} : 110px--}}
                            {{--{{__('content.max_file_size_allowed')}} : 700KB--}}
                        {{--</p>--}}
                        <div class='file_style1 file_style'>
                            <span class='file_label'>{{__('content.choose_file')}}</span>
                            <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='1' data-y='1' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint30'/>

                        <div class='cropper ltr tcenter' id='cropper1'>
                            <div class='data_remove_file_holder'>
                                <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{asset('assets/admin/_images/default/default.png')}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                    <span class='inner cropper_preview' style="background-image:url({{asset('assets/admin/_images/default/default.png')}});background-size: contain;width:296px;height:200px;"></span>
                                </span>
                            </div><!--data_remove_file_holder-->
                            <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                            <input data-crop-x type='hidden' name='cropper[x]' value=''>
                            <input data-crop-y type='hidden' name='cropper[y]' value=''>
                            <input data-crop-w type='hidden' name='cropper[w]' value=''>
                            <input data-crop-h type='hidden' name='cropper[h]' value=''>
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


    @permission('view.category')
    @if(isset($categories))
        @if($categories->isNotEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">لیست دسته بندی های ثبت شده</p>
                        <p class="title2">از این بخش میتوانید لیست دسته بندی های اصلی ثبت شده را مشاهده
                            نمائید</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.category')
                                <a href="{{route('admin.category.destroy', ['category' => 'all'])}}" data-colspan="6"
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
                    <div data-loading='loadingDataTable'><div id='as-preloading-wrapper'><div class='as-preloader'><span></span><span></span><span></span><span></span><span></span><span></span></div></div></div>
                    <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            @permission('update.category')
                            <th class="width15"><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.category')
                            <th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name=""
                                                                                              data-select-all="data-select-row"><span
                                            class="box"></span></label></th>
                            @endpermission
                            <th class="width30">عکس</th>
                            <th class="width30">عنوان</th>
                            <th class="width30">تعداد زیرگروه</th>
                            @permission('update.category')
                            <th>{{__('content.tbl_status')}}</th>
                            <th class="width15">ویرایش</th>
                            @endpermission
                        </tr>
                        </thead>
                    </table>
                </div><!--table_style1-->
            </div>

        @else
            <div class="paper_style1">
                <div class="title_style1 marginb50 {{__('content.float')}}">
                    <p class="title1">لیست دسته بندی های ثبت شده</p>
                    <p class="title2">از این بخش میتوانید لیست دسته بندی های اصلی ثبت شده را مشاهده
                        نمائید</p>
                </div>

                <hr class="hr_style1 marginb20 margint20">

                <div class="form_style2">
                    <div class="result_style2 disable_max_width sign i">
                        <div class="text icon">آیتمی برای نمایش وجود ندارد ...</div>
                    </div>
                </div><!--paper_style-->
            </div>

        @endif


    @endif
    @endpermission
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
    url :"{{route('admin.category.data-table')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.category')
    { data: 'position', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.category')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'image', name: 'image', orderable: false, searchable: false },
    { data: 'title', name: 'title', orderable: false, searchable: false },
    { data: 'product_count', name: 'product_count', orderable: false, searchable: false },
    @permission('update.category')
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

{{--Cropper--}}
@section('cropper')
    @include('admin.developer.cropper')
@endsection
{{--End Cropper--}}

@section('js')
    @include('admin.developer.deleteFile')
@endsection

