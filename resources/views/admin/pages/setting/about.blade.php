@extends('admin.master')
@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">تنظیمات</p>
            <p class="title2">تنظیمات متن درباره ما</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.about.update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="about_page" value="1" >
            <div class="form_style2">
                <ul class="list clearfix">
                    @foreach($data['objects'] as $object)
                        @if($object->name != 'latlong' && $object->type == 'string')
                            @include('admin.forms.input_text',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value,'inputClass'=>"ltr tleft en_words"])
                        @endif
                        @if($object->name != 'latlong' && $object->type == 'text')
                            @if($object->name == "about-us-long")
                                @include('admin.forms.input_tinymce',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value,'inputRow'=>3])
                            @else
                                @include('admin.forms.input_textarea',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value,'inputRow'=>3])
                            @endif
                        @endif
                        @if($object->name == 'latlong')
                            <input id="latInput" type="hidden" name="lat" value="">
                            <input id="longInput" type="hidden" name="long" value="">
                        @endif
                    @endforeach

                    {{--<li class="item {{__('content.float')}} width100">--}}
                        {{--<p class="field_label">نقشه:<i class="required_style1">*</i></p>--}}
                        {{--<div class="item_inner">--}}
                            {{--<div id="map" style="width: 100%; height: 400px;"></div>--}}
                        {{--</div>--}}
                    {{--</li>--}}

                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.news.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection

{{--Active Menu--}}
@section('admin.about.index','active')
{{--End Active Menu--}}

{{--Editor--}}
@section('editor')
    @include('admin.developer.tinymce')
@endsection
{{--End Editor--}}