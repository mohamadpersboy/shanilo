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
            <p class="title1">مدیریت فروش ویژه</p>
            <p class="title2">افزودن فروش ویژه</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        {!! Form::open(['url'=>route('admin.firstPageSpecialSell.store'),'files'=>true]) !!}
         @include('admin.specific.specialsell.form')
        {!! Form::close() !!}
    </div>
@endsection

{{--Active Menu--}}
@section('admin.firstpagespecialsell.create','active')
{{--End Active Menu--}}

@section('js')
    @include('admin.developer.select2')
    @include('admin.developer.select-auto-fill')
@endsection


