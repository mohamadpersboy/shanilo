@extends('admin.master')
@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">تنظیمات</p>
            <p class="title2">تنظیمات شبکه های اجتماعی</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.social.update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    @foreach($data['objects'] as $object)
                        @if($object->name != 'latlong' && $object->type == 'string')
                            @include('admin.forms.input_text',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value,'inputClass'=>"ltr tleft en_words"])
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
@section('admin.social.index','active')
{{--End Active Menu--}}
