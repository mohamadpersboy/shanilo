@extends('admin.master')
@section('content')
    @permission('create.about')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_about')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.about.update',1)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PATCH')}}
            <div class="form_style2">
                <ul class="list clearfix">
                    {{-- <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_about')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="{{__('content.write_title_about')}}">
                        </div>
                    </li> --}}

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">متن بالا<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea data-tinymce name="description">{{ $data['about']->description }}</textarea>
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">متن پایین</p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea data-tinymce name="description2">{{ $data['about']->description2 }}</textarea>
                        </div>
                    </li>

                    <!--group btn-->
                    {{-- <li class='item' data-select-file-wrapper>
                        <div class='clearfix'></div>
                        <hr class='hr_style2 margint20'/>
                        <div class='title_style4 noselect'>تصاویر گالری</div>
                        <hr class='hr_style2 margint15'/>
                        <div class='file_style1 file_style uploadifive'>
                            <div class='file_btns'>
                                <a href="{{route('admin.about.gallery_destroy')}}" data-token="{{csrf_token()}}" class='btn_style5 bg_red hover_opac' data-remove-selected-file='data-select-file' style='display:none;'>
                                    <i class='i-cancel icon'></i> حذف فایل های انتخابی
                                </a>
                            </div>
                            <span class='file_label'>--> انتخاب فایل</span>
                            <input id='uploadifive_gallery' type='file' name='pic_gallery' multiple='multiple' />
                        </div>
                        <hr class='hr_style2 margint30'/>

                        <div class='pic_style2 tcenter'>
                            @foreach($data['about']->attachments->where('slug','gallery') as $gallery)
                                <span class='pic_item' style='background-image:url({{$data['about']->takeImageWithName($gallery->file_name)}});'
                                data-file-item data-view-pic-preview='{{$data['about']->takeImageWithName($gallery->file_name)}}'>
                                        <label class='checkradio_style3 noselect select_file'><input type='checkbox' name='id[]' value='{{$gallery->id}}' data-select-file><span class='box'></span></label>
                                    </span>
                            @endforeach

                        </div>
                    </li> --}}

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

    <!--======================== MODAL : PIC_PREVIEW ==========================-->
    <div class='modal modal_over'>
        <div class='modal_scroll'>
            <div class='modal_dynamic'></div><!--modal_dynamic-->

            <div class='modal_static'>

                <div class='window modalwin_style1' id='view_pic_preview'>
                    <i class='modal_close'>X</i>
                    <div class='inner'>
                        <div class='pic_preview' style="height: 300px;background-size: contain;background-repeat: no-repeat;"></div>
                    </div><!--inner-->
                </div>

            </div><!--modal_static-->
        </div><!--modal_scroll-->
    </div><!--modal-->

    @endpermission
@endsection


{{--Active Menu--}}
@section('admin.about.index','active')
{{--End Active Menu--}}

{{--Editor--}}
@section('editor')
    @include('admin.developer.tinymce')
@endsection
{{--End Editor--}}

{{--UploadFive--}}
@section('UploadFive')
    @include('admin.developer.upload_five')
@endsection
{{--End UploadFive--}}

@section('js')
    <script>
        $(document).ready(function () {
            //////////////////////////////////////////////////////////////////////////////////////
            // UPLOADIFY
            var $uploadifive_gallery = $('#uploadifive_gallery');
            var _token = $('meta[name="csrf-token"]').attr('content');
            $uploadifive_gallery.uploadifive({
                'uploadScript' : "{{route('admin.about.gallery')}}",
                'method' : 'post',
                'fileType' : ["image\/png,image\/jpeg,image\/gif"],
                'multi': ($uploadifive_gallery.is('[multiple]'))?true:false,
                'formData' : {
                    'id': '{{$data['about']->id}}',
                    '_token': _token
                },
                'onUpload' : function(filesToUpload) {
                    if(!$uploadifive_gallery.is('[multiple]')){
                        $('.uploadifive-queue-item.complete').first().remove();
                    }
                },
                'onUploadComplete' : function(file,response) {
                    var data = $.parseJSON(response);
                    //set remove btn & delete cancel btn
                    //$('.uploadifive-queue-item.complete .filename:contains('+file.name+')').last().closest('.uploadifive-queue-item').append(data.remove_btn);
                    $('.uploadifive-queue-item.complete .filename:contains('+data.file_name+')').last().closest('.uploadifive-queue-item').find('.close').remove();
                    $('.uploadifive-queue-item.complete .filename:contains('+data.file_name+')').last().closest('.uploadifive-queue-item').slideUp(100,function(){
                        $(this).remove();
                    });
                    var pic_item_html = "";
                    pic_item_html += "<span class='pic_item' style='background-image:url("+data.image_link+");' data-view-pic-preview='"+data.image_link+"' data-file-item=''>";
                    pic_item_html += "<label class='checkradio_style3 noselect select_file'><input type='checkbox' name='id[]' value='"+data.image_id+"' data-select-file=''><span class='box'></span></label>";
                    pic_item_html += "</span>";
                    $('#uploadifive_gallery').closest("[data-select-file-wrapper]").find(".pic_style2").append(pic_item_html);

                }//onUploadComplete
            });

            ///////////////////////////////////////////////
            // pic item -> view big pic
            $("body").on("click","[data-view-pic-preview]",function(e){
                if(!$(e.target).is(".select_file") && !$(e.target).is(".select_file *") &&
                    !$(e.target).is(".checkbox_selected") && !$(e.target).is(".checkbox_selected *")){
                    var big_pic_src = $(this).attr("data-view-pic-preview");
                    $("#view_pic_preview .pic_preview").css("background-image","url("+big_pic_src+")");
                    modal_box("#view_pic_preview");
                }
            });
            $('.modal .modal_scroll,.modal .modal_close').click(function(){hide_modal("#view_pic_preview");});
            $(".modal .window").click(function(e){e.stopPropagation();});
        });
    </script>
@endsection