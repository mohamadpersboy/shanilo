@extends('admin.master')

@section('css_after')
    <style type="text/css">
        .form_style2 .tokenfield .token-input {
            direction: ltr !important;
            float: left;
            width: 100px !important;
            max-width: auto !important;
            min-width: auto !important;
            display: inline-block !important;
        }
        .tokenfield .token {
            float: left !important;
            margin-left: 3px !important;
            margin-right: 0 !important;
        }
    </style>
@endsection

@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">تنظیمات</p>
            <p class="title2">تنظیمات پیش شماره های موبایل</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.mobilepreorder.update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    @foreach($data['objects'] as $object)
                        @if($object->name != 'latlong' && $object->type == 'string')
                            <li class="item {{__('content.float')}} width100">
                                <p class="field_label">{{$object->title}}:<i class="required_style1">*</i></p>
                                <div class="item_inner">
                                    <input class="form-control tokenfieldNoSource input-lg ltr tleft en_words" type="text" name="{{$object->name}}" value="{{$object->value}}" id="tag_show">
                                </div>
                            </li>
                        @endif
                        @if($object->name != 'latlong' && $object->type == 'text')
                            @include('admin.forms.input_textarea',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value,'inputRow'=>3])
                        @endif
                        @if($object->name == 'latlong')
                            <input id="latInput" type="hidden" name="lat" value="">
                            <input id="longInput" type="hidden" name="long" value="">
                        @endif
                    @endforeach

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

@endsection

{{--Active Menu--}}
@section('admin.mobilepreorder.index','active')
{{--End Active Menu--}}

{{--Tag--}}
@section('tag')
    @include('admin.developer.tag')
@endsection
{{--End Tag--}}
