@extends('admin.master')
@section('content')

    @if($send_type)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_send_type')}}</p>
                <p class="title2">{{__('content.edit_send_type')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.send_type.update',$send_type->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">عنوان:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$send_type->title}}">
                            </div>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">آیکن:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="icon" value="{{$send_type->icon}}">
                            </div>
                        </li>
                        <li class='item width50 {{__('content.float')}}'>
                            <hr class="hr_style2 margint15">
                            <div class='item_inner has_guide paddingl40'>
                                <input type='text' name='price' data-mask="000,000,000,000,000" data-mask-reverse="true" value='{{$send_type->price}}' class='ltr tleft number_format'>
                                <span class="guide_text right width40 tcenter fontsize12">قیمت</span>
                                <span class='guide_text left'>تومان</span>
                            </div>
                        </li>

                        <li class='item width50 {{__('content.float')}} nospace'>
                            <hr class="hr_style2 margint15">
                            <div class='item_inner has_guide paddingl40'>
                                <input type='text' name='free_from' data-mask="000,000,000,000,000" data-mask-reverse="true" value='{{$send_type->free_from}}' class='ltr tleft number_format'>
                                <span class="guide_text right width40 tcenter fontsize12">رایگان برای بالاتر از</span>
                                <span class='guide_text left'>تومان</span>
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">توضیحات<i class="required_style1">*</i></p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="description" class="autosize">{{$send_type->description}}</textarea>
                            </div>
                        </li>

                     {{--   <li class='item fright width100' id='file_cropper'>
                            <div class='clearfix'></div>
                            <div class='title_style4'>آیکون</div>
                            <hr class='hr_style2 margint5'/>
                            <div class='file_style1 file_style'>
                                <span class='file_label'>{{__('content.choose_file')}}</span>
                                <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='' data-y='' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                            </div>
                            <hr class='hr_style2 margint30'/>

                            <div class='cropper ltr tcenter' id='cropper1'>
                                <div class='data_remove_file_holder'>
                                    @php $image = $send_type->takeImage(); @endphp
                                    <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{$image}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                    <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                        <span class='inner cropper_preview' style="background-image:url({{$image}});width:500px;height:190px;background-size: contain"></span>
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
                                <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.send_type.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_send_types'))

{{--Active Menu--}}
@section('admin.send_type.index','active')
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