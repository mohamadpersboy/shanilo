@extends('admin.master')
@section('content')
    @permission('create.guide')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_guide')}}</p>
            <p class="title2">{{__('content.create_guide')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.guide.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_guide')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="{{__('content.write_title_guide')}}">
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.content_guide')}}<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea  name="description" data-tinymce>{{ old('description') }}</textarea>
                        </div>
                    </li>

           {{--         <li class='item fright width100' id='file_cropper'>
                        <div class='clearfix'></div>
                        <div class='title_style4'>عکس<i class="required_style1">*</i></div>
                        <hr class='hr_style2 margint5'/>

                        <p class='field_text'>
                            {{__('content.minimum_width_photo')}} : 320px /
                            {{__('content.minimum_height_photo')}} : 200px
--}}{{--                            {{__('content.max_file_size_allowed')}} : 700KB--}}{{--
                        </p>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>{{__('content.choose_file')}}</span>
                            <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='5.5' data-y='4' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint30'/>

                        <div class='cropper ltr tcenter' id='cropper1'>
                            <div class='data_remove_file_holder'>
                                <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{asset('assets/admin/_images/default/default.png')}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                    <span class='inner cropper_preview' style="background-image:url({{asset('assets/admin/_images/default/default.png')}});width:296px;height:200px;"></span>
                                </span>
                            </div><!--data_remove_file_holder-->
                            <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                            <input data-crop-x type='hidden' name='cropper[x]' value=''>
                            <input data-crop-y type='hidden' name='cropper[y]' value=''>
                            <input data-crop-w type='hidden' name='cropper[w]' value=''>
                            <input data-crop-h type='hidden' name='cropper[h]' value=''>
                        </div>
                    </li>--}}

                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="ثبت اطلاعات" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    @endpermission

    @if(isset($data['objects']))
        @if(!$data['objects']->isEmpty())
            <div class="paper_style1">
                <div class="marginb100">
                    <div class="title_style1 {{__('content.float')}}">
                        <p class="title1">{{__('content.management_guide')}}</p>
                        <p class="title2">{{__('content.list_of_guide')}}</p>
                    </div>

                </div>

                <hr class="hr_style2 margint30">

                <div class="clearfix">
                    <div class="btn_group_style1 {{__('content.float')}}">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                @permission('delete.guide')
                                <a href="{{route('admin.guide.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
                                @endpermission
                            </li>
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
                            @permission('update.guide')
                            <th><i class="icon1 i-list-ol"></i></th>
                            @endpermission
                            @permission('delete.guide')
                            <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                            @endpermission
                            <th>عکس</th>
                            <th>{{__('content.title_guide')}}</th>
                            <th>{{__('content.tbl_creation_date')}}</th>
                            <th>{{__('content.tbl_date_modified')}}</th>
                            @permission('update.guide')
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
                        <p class="title1">{{__('content.management_guide')}}</p>
                        <p class="title2">{{__('content.list_of_guide')}}</p>
                    </div><!--title_style1-->

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="form_style2">
                        <div class="result_style2 disable_max_width sign i">
                            <div class="text icon">{{__('content.empty_guide')}}</div>
                        </div>
                    </div><!--paper_style-->
                </div>

        @endif


    @endif
@endsection


@section('PageHeading',__('content.management_guide'))

{{--Active Menu--}}
@section('admin.guide.index','active')
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
    url :"{{route('admin.guide.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.guide')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.guide')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'image', name: 'image', orderable: false, searchable: false},
    { data: 'title', name: 'title' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.guide')
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

{{--Editor--}}
@section('editor')
    @include('admin.developer.tinymce')
@endsection
{{--End Editor--}}

{{--Cropper--}}
@section('cropper')
    @include('admin.developer.cropper')
@endsection
{{--End Cropper--}}
