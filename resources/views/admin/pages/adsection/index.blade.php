@extends('admin.master')
@section('content')
    @permission('create.adsection')
    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">{{$header['create']['title']}}</p>
                <p class="title2">{{$header['create']['description']}}</p>
            </div>
        </div>

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.adsection.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_adsection')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.width_adsection')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="width" value="{{ old('width') }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">{{__('content.height_adsection')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="height" value="{{ old('height') }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.name_adsection')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="name" value="{{ old('name') }}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">{{__('content.max_count_adsection')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="max_count" value="{{ old('max_count') }}">
                        </div>
                    </li>

                    <li class='item fright width100'>
                        <p class='field_label'>{{__('content.image')}}<i class="required_style1">*</i></p>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>--> {{__('content.choose_file')}}</span>
                            <input type='file' name='pic' data-file-style  data-image-info data-width='0' data-height='0' onChange='preview(this,$(".pic_preview_style1"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint25'/>
                        {{--<div class='pic_preview_style1 img_width300 tcenter cursor_pointer' onClick='$("input[name=pic]").click();'></div>--}}
                        <div class="tcenter">
                            <span class='pic_style1 tcenter' onClick="$('input[name=pic]').click();">
                                <span class='inner pic_preview_style1 img_width300 tcenter cursor_pointer' style="background-image:url({{asset('assets/admin/_images/default/default.png')}});width:500px;height:190px;"></span>
                            </span>
                        </div>
                    </li>

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

    @if(isset($data['adsections']) && !$data['adsections']->isEmpty())
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['list']['title']}}</p>
                    <p class="title2">{{$header['list']['description']}}</p>
                </div>
            </div>

            <hr class="hr_style2 margint30">

            <div class="clearfix">
                <div class="btn_group_style1 {{__('content.float')}}">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            @permission('delete.adsection')
                            <a href="{{route('admin.adsection.destroy','all')}}" data-colspan="6" class="btn_style4 red delete_from_list">{{__('content.remove_items')}}<i class="icon i-trash-o"></i></a>
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
                <div data-loading='loadingDataTable'><div id='as-preloading-wrapper'><div class='as-preloader'><span></span><span></span><span></span><span></span><span></span><span></span></div></div></div>
                <table id="data_table" class="display data_table sortable_table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        @permission('update.adsection')
                        <th><i class="icon1 i-list-ol"></i></th>
                        @endpermission
                        @permission('delete.adsection')
                        <th><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label></th>
                        @endpermission
                        <th>عکس</th>
                        <th>{{__('content.title_adsection')}}</th>
                        <th>{{__('content.tbl_creation_date')}}</th>
                        <th>{{__('content.tbl_date_modified')}}</th>
                        @permission('update.adsection')
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
                    <p class="title1">{{$header['list']['title']}}</p>
                    <p class="title2">{{$header['list']['description']}}</p>
                </div><!--title_style1-->

                <hr class="hr_style1 marginb20 margint20">

                <div class="form_style2">
                    <div class="result_style2 disable_max_width sign i">
                        <div class="text icon">هیچ موردی یافت نشد.</div>
                    </div>
                </div><!--paper_style-->
            </div>
    @endif
@endsection


{{--Active Menu--}}
@section('admin.adsection.index','active')
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
    url :"{{route('admin.adsection.DataTable')}}",
@endsection
@section('datatable_source')
    "order": [[ 0, "asc" ]],
    "columns": [
    @permission('update.adsection')
    { data: 'sorting', name: 'position', orderable: true, searchable: false,class:'td_padding_zero'},
    @endpermission
    @permission('delete.adsection')
    { data: 'check', name: 'check', orderable: false, searchable: false},
    @endpermission
    { data: 'image', name: 'image', orderable: false, searchable: false},
    { data: 'title', name: 'title' },
    { data: 'created_at', name: 'created_at' },
    { data: 'updated_at', name: 'updated_at' },
    @permission('update.adsection')
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

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

@section('js')
    <script>
        $(document).ready(function(){
           $('input[type=file]').change(function(){
               $('.pic_preview_style1').removeAttr('style');
           });
        });
    </script>
@endsection
