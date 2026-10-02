@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_picturegallery')}}</p>
            <p class="title2">{{__('content.create_picturegallery')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.picturegallery.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.title_picturegallery')}}:<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="{{__('content.write_title_picturegallery')}}">
                        </div>
                    </li>

                    <li class='item fright width100'>
                        <p class='field_label'>{{__('content.image_picturegallery')}}<i class="required_style1">*</i></p>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>--> Choose file</span>
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
                            <input type="submit" name="submit" value="{{__('content.save_and_continue')}}" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.picturegallery.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('PageHeading',__('content.management_picturegallery'))

{{--Active Menu--}}
@section('admin.picturegallery.create','active')
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

@section('js')
    <script>
        $(document).ready(function(){
           $('input[type=file]').change(function(){
               $('.pic_preview_style1').removeAttr('style');
           });
        });
    </script>
@endsection

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}
