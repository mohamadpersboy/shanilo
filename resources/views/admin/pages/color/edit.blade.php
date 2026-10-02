@extends('admin.master')
@section('content')

    @if($color)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_color')}}</p>
                <p class="title2">{{__('content.create_color')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.color.update',$color->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label">عنوان رنگ:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$color->title}}">
                            </div>
                        </li>

                        <li class="item width50 {{__('content.float')}} nospace">
                            <p class="field_label">کد رنگ:</p>
                            <div class="item_inner">
                                <input type="text" name="code" data-color-picker="" value="{{$color->code}}" class="clear_field tcenter en_words ltr valid" style="" aria-required="true" aria-invalid="false">
                            </div>
                        </li>
                    </ul>

                    <hr class="hr_style1 marginb20 margint20">

                    <div class="btn_group_style1">
                        <ul class="list clearfix">
                            <li class="item {{__('content.float')}}">
                                <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                            </li>
                            <li class="item {{__('content.float')}}">
                                <a href="{{route('admin.color.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_colors'))

{{--Active Menu--}}
@section('admin.color.index','active')
{{--End Active Menu--}}

{{--Color--}}
@section('Color')
    @include('admin.developer.color')
@endsection
{{--End Color--}}