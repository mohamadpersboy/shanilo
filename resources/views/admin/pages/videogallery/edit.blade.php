@extends('admin.master')
@section('content')

    @if($videogallery)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_videogallery')}}</p>
                <p class="title2">{{__('content.create_videogallery')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.videogallery.update',$videogallery->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">{{__('content.title_videogallery')}}:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$videogallery->title}}" placeholder="{{__('content.write_title_videogallery')}}">
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}}">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">{{__('content.description_videogallery')}}</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="description" placeholder="{{__('content.write_description_videogallery')}}">{{$videogallery->description}}</textarea>
                            </div>
                        </li>

                        <li class='item fright width100' id='file_cropper'>
                            <div class='clearfix'></div>
                            <div class='title_style4'>{{__('content.image_videogallery')}}</div>
                            <hr class='hr_style2 margint5'/>
                            <div class='file_style1 file_style'>
                                <span class='file_label'>{{__('content.choose_file')}}</span>
                                <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='video_pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='2.9' data-y='2.8' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                            </div>
                            <hr class='hr_style2 margint30'/>

                            <div class='cropper ltr tcenter' id='cropper1'>
                                <div class='data_remove_file_holder'>
                                    @php $image = $videogallery->takeImage('video_picture_preview'); @endphp
                                    <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='video_pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{$image}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                    <span class='pic_style1' onClick="$('input[name=video_pic]').click();">
                                        <span class='inner cropper_preview' style="background-image:url({{$image}});width:290px;height:280px;"></span>
                                    </span>
                                </div><!--data_remove_file_holder-->
                                <div class='cropper_holder' style='width:290px;max-height:280px;'></div>
                                <input data-crop-x type='hidden' name='cropper[x]' value=''>
                                <input data-crop-y type='hidden' name='cropper[y]' value=''>
                                <input data-crop-w type='hidden' name='cropper[w]' value=''>
                                <input data-crop-h type='hidden' name='cropper[h]' value=''>
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}}">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">{{__('content.file_videogallery')}}</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <div id='fineuploader_file'></div>
                            </div>
                        </li>
                        @if($videogallery->attachments('video_file')->count() && $videogallery->attachments('video_picture_preview')->count())
                            <li class="item width100 {{__('content.float')}}">
                                <div class='video_style1'>
                                    <div data-video-player id='video_player1'
                                    data-image="{{$videogallery->takeImage('video_picture_preview')}}"
                                    data-file="{{$videogallery->takeVideo('video_file')}}"
                                    data-width='100%'
                                    data-height='380px'></div>
                                </div>
                            </li>
                        @endif
                    </ul>

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" id="finish_edit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.videogallery.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_videogallerys'))

{{--Active Menu--}}
@section('admin.videogallery.index','active')
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

@section('fine_uploader')
    @include('admin.developer.fine_uploader')
    <script>
        $(document).ready(function(){
            //////////////////////////////////////////////////////////////////////////////////////
            // FineUploader
            var fine_error = 0;
            var fineuploader_file = new qq.FineUploader({
                element: document.getElementById("fineuploader_file"),
                template: 'qq-template',
                multiple: false,
                validation: {
                    allowedExtensions: ['mp4'],
                    sizeLimit: 300000000 // 300000 kB = 300000 * 1024 bytes
                },
                messages: {
                    typeError: 'The file type is invalid. valid extensions are: {extensions}',
                    sizeError: 'The file size is more than allowed file size :{sizeLimit}'
                },
                request: {
                    endpoint: "{{route('admin.uploader.upload')}}",
                    forceMultipart: true,
                    params: {
                        'go_video_file':'',
                        '_token':$('meta[name="csrf-token"]').attr('content'),
                        object_id: '{{$videogallery->id}}',
                        object_tbl: '{{implode(' ',explode('\\',get_class($videogallery)))}}',
                        object_slug: 'video_file',
                        object_multi: 'false',
                        base_directory: 'completed',
                        object_function_pre:'video',
                        sub_directory: null,
                        optimus_uploader_allowed_extensions: [],
                        optimus_uploader_size_limit: 0,
                        optimus_uploader_thumbnail_height: 0,
                        optimus_uploader_thumbnail_width: 0
                    }
                },
                resume: {
                    enabled: true
                },
                forceMultipart: {
                    enabled: true
                },
                chunking: {
                    enabled: true,
//                    partSize: 200000, //200KB per chunk
                    concurrent: {
                        enabled: false
                    }
                },
                retry: {
                    enableAuto: false,
                    showButton: true
                },
                callbacks: {
                    onError:function(){
                        fine_error = 1;
                    },
                    onUploadChunkSuccess:function(){
                        fine_error = 0;
                    },
                    onComplete: function() {
                        if(fine_error == 0){
                            $('#finish_edit').trigger('click');
                        }
                    },
                    onSubmit: function(){}
                }
            });// FineUploader

            //home_part4 video player
            run_player();

        });//document ready
    </script>
@endsection