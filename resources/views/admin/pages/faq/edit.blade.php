@extends('admin.master')
@section('content')

    @if($faq)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_faq')}}</p>
                <p class="title2">{{__('content.create_faq')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.faq.update',$faq->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">{{__('content.title_faq')}}:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name="title" value="{{$faq->title}}" placeholder="{{__('content.write_title_faq')}}">
                            </div>
                        </li>

                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">{{__('content.content_faq')}}</p>
                            <hr class="hr_style2 margint15">
                            <div class="item_inner">
                                <textarea name="description" class="autosize">{{$faq->description}}</textarea>
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
                                <a href="{{route('admin.faq.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_faqs'))

{{--Active Menu--}}
@section('admin.faq.index','active')
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