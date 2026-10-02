@extends('admin.master')
@section('css')
    <style>
        .form_style2 .tokenfield .token-input {
            padding-right: 10px !important;
            padding-left: 0 !important;
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
            <p class="title1">مدیریت آیتم های صفحه</p>
            <p class="title2">افزودن آیتم صفحه</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::open(['url'=>route('admin.pageItem.store'),'files'=>true]) !!}
        {!! Form::hidden('page_id',$page->id) !!}
         @include('admin.pages.pageitem.form')
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

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
    @include('admin.developer.select-auto-fill')
@endsection
{{--End Select2--}}



@section('js')
    {{--Dynamic field--}}
    @include('admin.developer.dynamic_field')
    {{--Dynamic field--}}
    <script>
        $(function () {
            $('.select_style select:has(option[data-change-bgcolor])').change(function(){
                var $this = $(this);
                var option_color = $this.find("option:selected[data-change-bgcolor]").attr("data-change-bgcolor");
                var option_text = $this.find("option:selected[data-change-bgcolor]").text();
                if(option_color != ""){
                    $this.closest('form').trigger('submit');
                    $this.closest(".select_style").css("background-color",option_color);
                    $(".select_style .select_label").text(option_text);
                }
            });
        });
    </script>
@stop
