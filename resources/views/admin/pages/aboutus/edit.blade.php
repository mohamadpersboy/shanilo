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
            <p class="title1">{{__('content.about_us_management')}}</p>
            <p class="title2">{{__('content.edit_about_us')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::model($aboutUs,['url'=>route('admin.aboutUs.update',$aboutUs->id),'method'=>'PATCH','class'=>'form-horizontal','files'=>true]) !!}
        {!! Form::hidden('id',$aboutUs->id) !!}
        @include('admin.pages.aboutus.form')
        {!! Form::close() !!}
    </div>
@endsection

{{--Active Menu--}}
@section('admin.aboutus.index','active')
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

