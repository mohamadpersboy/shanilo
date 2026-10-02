@extends('admin.master')
@section('content')
        <div class="paper_style1">
            <div class="marginb100">
                <div class="title_style1 {{__('content.float')}}">
                    <p class="title1">{{$header['edit']['title']}}</p>
                    <p class="title2">{{$header['edit']['description']}}</p>
                </div>
            </div>

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.contact.update',$contact->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">

                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label"> نام: {{$contact->name}}</p>
                        </li>
                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label"> شرکت: {{$contact->company}}</p>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">ایمیل: {{$contact->email}}</p>
                        </li>
                        <li class="item {{__('content.float')}} width50">
                            <p class="field_label"> موضوع: {{$contact->subject}}</p>
                        </li>
                        <li class="item {{__('content.float')}} width50 nospace">
                            <p class="field_label">موبایل: {{$contact->mobile}}</p>
                        </li>
                        <li class="item width100 {{__('content.float')}} editor_style">
                            <hr class="hr_style2 margint15">
                            <p class="title_style4">پیام:</p>
                            <hr class="hr_style2 margint15">
                            <p class="field_label">{!! nl2br($contact->description) !!}</p>
                        </li>

                    </ul>
                </div>
            </form>
        </div>

        {{--<div class="paper_style1">--}}
            {{--<div class="title_style1">--}}
                {{--<p class="title1">ارسال پاسخ</p>--}}
                {{--<p class="title2">شما میتوانید توسط فرم زیر به کاربر مورد نظر پیام خود را ارسال کنید.</p>--}}
            {{--</div><!--title_style1-->--}}

            {{--<hr class="hr_style1 marginb20 margint20">--}}

            {{--<form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.contact.store')}}" enctype="multipart/form-data">--}}
                {{--{{csrf_field()}}--}}
                {{--<div class="form_style2">--}}
                    {{--<ul class="list clearfix">--}}
                        {{--<li class="item {{__('content.float')}} width100">--}}
                            {{--<p class="field_label">عنوان پیام:<i class="required_style1">*</i></p>--}}
                            {{--<div class="item_inner">--}}
                                {{--<input type="text" name="title" value="{{ old('title') }}">--}}
                            {{--</div>--}}
                        {{--</li>--}}

                        {{--<li class="item width100 {{__('content.float')}} editor_style">--}}
                            {{--<hr class="hr_style2 margint15">--}}
                            {{--<p class="title_style4">متن پیام<i class="required_style1">*</i></p>--}}
                            {{--<hr class="hr_style2 margint15">--}}
                            {{--<div class="item_inner">--}}
                                {{--<textarea name="contact">{{ old('contact') }}</textarea>--}}
                            {{--</div>--}}
                        {{--</li>--}}

                    {{--</ul>--}}

                    {{--<hr class="hr_style1 marginb20 margint20">--}}

                    {{--<div class="btn_group_style1">--}}
                        {{--<ul class="list clearfix">--}}
                            {{--<li class="item {{__('content.float')}}">--}}
                                {{--<input type="submit" name="submit" value="ارسال پیام" class="btn_style2 green">--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}

@endsection

{{--Active Menu--}}
@section('admin.message','active')
@section('admin.contact.index','active')
{{--End Active Menu--}}