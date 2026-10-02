@extends('admin.master')
@section('content')

    @if($guide)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_guide')}}</p>
                <p class="title2">{{__('content.create_guide')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.guide.update',$guide->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">{{__('content.title_guide')}}:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$guide->title}}" placeholder="{{__('content.write_title_guide')}}">
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">{{__('content.content_guide')}}<i class="required_style1">*</i></p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea  name="description" data-tinymce>{{$guide->description}}</textarea>
                            </div>
                        </li>
                        @role('atlas-administrator')
                     {{--   <li class='item fright width100' id='file_cropper'>
                            <div class='clearfix'></div>
                            <div class='title_style4'>عکس<i class="required_style1">*</i></div>
                            <hr class='hr_style2 margint5'/>

                            <p class='field_text'>
                                {{__('content.minimum_width_photo')}} : 320px /
                                {{__('content.minimum_height_photo')}} : 200px
                                --}}{{--{{__('content.max_file_size_allowed')}} : 700KB--}}{{--
                            </p>
                            <div class='file_style1 file_style'>
                                <span class='file_label'>{{__('content.choose_file')}}</span>
                                <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='5.5' data-y='4' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                            </div>
                            <hr class='hr_style2 margint30'/>

                            <div class='cropper ltr tcenter' id='cropper1'>
                                <div class='data_remove_file_holder'>
                                    @php $image = $guide->takeImage(); @endphp
                                    <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{$image}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                    <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                        <span class='inner cropper_preview' style="background-image:url({{$image}});width:296px;height:200px;"></span>
                                    </span>
                                </div><!--data_remove_file_holder-->
                                <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                                <input data-crop-x type='hidden' name='cropper[x]' value=''>
                                <input data-crop-y type='hidden' name='cropper[y]' value=''>
                                <input data-crop-w type='hidden' name='cropper[w]' value=''>
                                <input data-crop-h type='hidden' name='cropper[h]' value=''>
                            </div>
                        </li>--}}
                        @endrole
                    </ul>

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.guide.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_guides'))

{{--Active Menu--}}
@section('admin.guide.index','active')
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