@extends('admin.master')
@section('content')

    @if($bank)

        <div class="paper_style1">
            <div class="title_style1">
                <p class="title1">{{__('content.management_bank')}}</p>
                <p class="title2">{{__('content.edit_bank')}}</p>
            </div><!--title_style1-->

            <hr class="hr_style1 marginb20 margint20">

            <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.bank.update',$bank->id)}}" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                <div class="form_style2">
                    <ul class="list clearfix">
                        <li class="item fright width50">
                            <p class="field_label">نام بانک:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name='title' value="{{$bank->title}}" placeholder='به طور مثال پارسیان'>
                            </div>
                        </li>

                        <li class="item fright width50 nospace">
                            <p class="field_label">نام صاحب حساب:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" name='name' value="{{$bank->name}}" placeholder='نام صاحب حساب'>
                            </div>
                        </li>

                        <li class="item fright width50">
                            <p class="field_label">شماره حساب:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" class="ltr tleft" name='account_number' value="{{$bank->account_number}}" placeholder='5404953584'>
                            </div>
                        </li>

                        <li class="item fright width50 nospace">
                            <p class="field_label">شماره کارت:<i class="required_style1">*</i></p>
                            <div class="item_inner">
                                <input type="text" class="ltr tleft" name='account_card' value="{{$bank->account_card}}" placeholder='5022-2910-0131-4531' data-mask="0000-0000-0000-0000">
                            </div>
                        </li>

                        <li class="item {{__('content.float')}} width100">
                            <p class="field_label">شماره شبا:</p>
                            <div class="item_inner">
                                <input type="text" name="account_shaba" class="ltr tleft en_words" value="{{$bank->account_shaba}}" placeholder="IR040120020000005404953584">
                            </div>
                        </li>

                        <li class='item fright width100'>
                            <p class='field_label'> لوگو بانک :<i class='required_style1'>*</i></p>
                            <div class='file_style1 file_style'>
                                <span class='file_label'>--> انتخاب فایل</span>
                                <input type='file' accept='image/png' name='pic' data-file-style  data-image-info data-width='0' data-height='0' onChange='preview(this,$(".pic_preview_style1"));' class='valid_group1'/>
                            </div>
                            <hr class='hr_style2 margint25'/>
                            <div class='pic_preview_style1 img_width300 tcenter cursor_pointer' onClick='$("input[name=pic]").click();'>
                                <img src="{{$bank->takeImage()}}">
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
                                <a href="{{route('admin.bank.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

@section('PageHeading',__('content.management_banks'))

{{--Active Menu--}}
@section('admin.bank.index','active')
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