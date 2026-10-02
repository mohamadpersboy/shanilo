@extends('admin.master')
@section('css')
    <style>
        .form_style2 .tokenfield .token-input {
            padding-right: 10px !important;
            padding-left: 0 !important;
            direction: rtl !important;
            margin-top: 1px !important;
            border-radius: 2px;
            /*position: absolute;
            right: 0;
            top: 0;*/
        }

        .tokenfield.form-control {
            border: 1px solid #e5e5e5;
            border-radius: 2px;
        }

        .select_style2.height36 {
            height: 40px;
        }

        /*.form_style2 .tokenfield {
            height: 39px !important;
            overflow: hidden !important;
        }*/

        /*  .token.bg-teal {
              position: relative;
              z-index: 2;
              width: 97%;
          }*/
    </style>
@endsection
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">مدیریت صفحات</p>
            <p class="title2">ویرایش صفحات</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::model($page,['url'=>route('admin.page.update',$page->id),'method'=>'PATCH','class'=>'form-horizontal form-contact-us-validation','files'=>true]) !!}
        {!! Form::hidden('id',$page->id) !!}
        @include('admin.pages.page.form')
        {!! Form::close() !!}
    </div>
@endsection

{{--Active Menu--}}
@section('admin.page.index','active')
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

{{--Tag--}}
{{--@section('tag_source')
    source: [@foreach($artistNewsInfos as $artistNewsInfo) '{{$artistNewsInfo->title}}', @endforeach],
@endsection--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

{{--UploadFive--}}
@section('UploadFive')
    @include('admin.developer.upload_five')
@endsection
{{--End UploadFive--}}


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

{{--Sortable--}}
@section('sortable')
    @include('admin.developer.sortable')
@endsection
{{--End Sortable--}}

@section('js')
    @include('admin.developer.dynamic_field')
    <script>
        $(document).ready(function () {
            //////////////////////////////////////////////////////////////////////////////////////
            // UPLOADIFY
            var $uploadifive_gallery = $('#uploadifive_gallery');
            var _token = $('meta[name="csrf-token"]').attr('content');
            $uploadifive_gallery.uploadifive({
                'uploadScript' : "{{route('admin.page.gallery')}}",
                'method' : 'post',
                'fileType' : ["image\/png,image\/jpeg,image\/gif"],
                'multi': ($uploadifive_gallery.is('[multiple]'))?true:false,
                'formData' : {
                    'id': '{{$page->id}}',
                    '_token': _token
                },
                'onUpload' : function(filesToUpload) {
                    if(filesToUpload>6)
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
