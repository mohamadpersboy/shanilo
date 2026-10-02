@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_videogallery')}}</p>
            <p class="title2">{{__('content.create_videogallery')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.videogallery.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_videogallery')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="{{__('content.write_title_videogallery')}}">
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}}">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.description_videogallery')}}</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea name="description"  placeholder="{{__('content.write_description_videogallery')}}">{{ old('description') }}</textarea>
                        </div>
                    </li>

                    <li class='item fright width100' id='file_cropper'>
                        <div class='clearfix'></div>
                        <div class='title_style4'>{{__('content.image_videogallery')}}<i class="required_style1">*</i></div>
                        <hr class='hr_style2 margint5'/>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>{{__('content.choose_file')}}</span>
                            <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='video_pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='2.9' data-y='2.8' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint30'/>

                        <div class='cropper ltr tcenter' id='cropper1'>
                            <div class='data_remove_file_holder'>
                                <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='video_pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{asset('assets/admin/_images/default/default.png')}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                <span class='pic_style1' onClick="$('input[name=video_pic]').click();">
                                    <span class='inner cropper_preview' style="background-image:url({{asset('assets/admin/_images/default/default.png')}});width:290px;height:280px;"></span>
                                </span>
                            </div><!--data_remove_file_holder-->
                            <div class='cropper_holder' style='width:290px;max-height:280px;'></div>
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
                            <input type="submit" name="submit" value="{{__('content.save_and_continue')}}" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.videogallery.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('PageHeading',__('content.management_videogallery'))

{{--Active Menu--}}
@section('admin.videogallery.create','active')
{{--End Active Menu--}}

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