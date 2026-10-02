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
            <p class="title1">مدیریت دسته بندیهای محصولات</p>
            <p class="title2">ویرایش دسته بندی محصولات</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::model($productCategory,['url'=>route('admin.productCategory.update',$productCategory->id),'method'=>'PATCH','class'=>'form-horizontal form-contact-us-validation','files'=>true]) !!}
        {!! Form::hidden('id',$productCategory->id) !!}
        @include('admin.specific.productcategory.form')
        {!! Form::close() !!}
    </div>
@endsection

{{--Active Menu--}}
@section('admin.productcategory.index','active')
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

@section('js')
    @include('admin.specific.productcategory.js')
@stop





