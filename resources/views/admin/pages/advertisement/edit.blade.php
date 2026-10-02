@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">{{__('content.management_advertisement')}}</p>
            <p class="title2">{{__('content.create_advertisement')}}</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.advertisement.update',$advertisement->id)}}" enctype="multipart/form-data">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    
                    @if($data['end']->diffInDays($data['now']) < 10)
                        <li class="item {{__('content.float')}} width80">
                            <div class="item_inner">
                                <input type="text" disabled="" class="tcenter letter0_5" style="color:#f00;" value="تاریخ این تبلیغ به زودی به پایان می رسد در صورت تمایل جهت تمدید آن تعداد روز آن را در فیلد مقابل وارد نمایید.">
                            </div>
                        </li>

                        <li class='item width20 {{__('content.float')}} nospace'>
                            <div class='item_inner has_guide paddingl40'>
                                <input type='text' name="extend" class='ltr tcenter' data-mask="000" data-mask-reverse="true">
                                <span class='guide_text left'>روز</span>
                            </div>
                        </li>
                    @endif

                    <div class='clearfix'></div>
                    <div class='title_style4 margint5 marginb10'>اطلاعات درخواست کننده</div>
                    <hr class='hr_style2'/>

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">نام:</p>
                        <div class="item_inner">
                            <input type="text" name="name" value="{{$advertisement->name}}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">نام خانوادگی:</p>
                        <div class="item_inner">
                            <input type="text" name="family" value="{{$advertisement->family}}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width33_3">
                        <p class="field_label">تلفن ثابت:</p>
                        <div class="item_inner">
                            <input type="text" name="tel" value="{{$advertisement->tel}}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width33_3">
                        <p class="field_label">تلفن همراه:</p>
                        <div class="item_inner">
                            <input type="text" name="mobile" value="{{$advertisement->mobile}}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width33_3 nospace">
                        <p class="field_label">ایمیل:</p>
                        <div class="item_inner">
                            <input type="text" name="email" value="{{$advertisement->email}}" class="ltr tleft en_words">
                        </div>
                    </li>

                    
                    <div class='clearfix'></div>
                    <div class='title_style4 margint20 marginb10'>اطلاعات تبلیغ</div>
                    <hr class='hr_style2'/>

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">پلن:<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <select name="ad_plan_id" class="js-example-basic-single" data-placeholder="پلن" id="category" data-change-plan>
                                <option value="">پلن</option>
                                @foreach($data['adplans'] as $adplan)
                                    <option value="{{$adplan->id}}" @if($advertisement->ad_plan_id == $adplan->id) selected="" @endif>{{$adplan->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">زمان:<i class="required_style1">*</i></p>
                        <div class='item_inner'>
                            <select name="ad_time_id" class="js-example-basic-single" data-placeholder="زمان" id="category" data-change-time>
                                <option value="">زمان</option>
                                @foreach ($data['addetails'] as $adDetail)
                                    <option value="{{$adDetail->adtime->id}}" @if($advertisement->ad_time_id == $adDetail->adtime->id) selected="" @endif>{{$adDetail->adtime->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="width100 {{__('content.float')}}" data-price-wrapper>
                        <ul class="clearfix">
                            <li class='item width33_3 {{__('content.float')}}'>
                                <p class='field_label'>قیمت:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' disabled="" value="{{$data['addetail']->price}}" class='ltr tcenter' data-show-price data-price-value data-mask="000,000,000,000,000" data-mask-reverse="true">
                                    <span class='guide_text left'>تومان</span>
                                </div>
                            </li>
                            <li class='item width33_3 {{__('content.float')}}'>
                                <p class='field_label'>درصد تخفیف:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' disabled="" value="{{$data['addetail']->discount}}" class='ltr tcenter' data-show-discount data-discount-value>
                                    <span class='guide_icon left'><i class='i-percent-symbol' style='font-size:1.3rem;'></i></span>
                                </div>
                            </li>
                            <li class='item width33_3 {{__('content.float')}} nospace'>
                                <p class='field_label'>قیمت تخفیف خورده:</p>
                                <div class='item_inner has_guide paddingl40'>
                                    <input type='text' disabled="" value="{{$data['addetail']->price_discount}}" class='ltr tcenter' data-show-price-discount data-price-discount-value data-mask="000,000,000,000,000" data-mask-reverse="true">
                                    <span class='guide_text left'>تومان</span>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">لینک:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="link" value="{{$advertisement->link}}" class="ltr tleft en_words">
                        </div>
                    </li>
                    
                    @foreach ($data['adplan']->ad_sections as $ad_section)                    
                        <li class='item fright width100'>
                            <p class='field_label'>{{__('content.image')}} تبلیغ در مکان {{$ad_section->title}}<i class="required_style1">*</i></p>
                            <p class='field_text'>
                                {{__('content.minimum_width_photo')}} : {{$ad_section->width}}px /
                                {{__('content.minimum_height_photo')}} : {{$ad_section->height}}px
                            </p>
                            <div class='file_style1 file_style'>
                                <span class='file_label'>--> {{__('content.choose_file')}}</span>
                                <input type='file' name="{{$ad_section->name}}" data-file-style data-image-info data-width='0' data-height='0'
                                onChange='preview(this,$(".pic_preview_style_{{$ad_section->id}}"));$(".pic_preview_style_{{$ad_section->id}}").removeAttr("style")' class='valid_group1'/>
                            </div>
                            <hr class='hr_style2 margint25'/>
                            <div class="tcenter">
                            <span class='pic_style1 tcenter' onClick="$('input[name={{$ad_section->name}}]').click();">
                                <span class='inner pic_preview_style_{{$ad_section->id}} img_width400 tcenter cursor_pointer'>
                                    @if($advertisement->checkImage($ad_section->name))
                                        <img src="{{$advertisement->takeImage($ad_section->name,$ad_section->width.'/'.$ad_section->height)}}"/>
                                    @else
                                        <img src="{{$ad_section->takeImage()}}"/>
                                    @endif
                                </span>
                            </span>
                            </div>
                        </li>
                    @endforeach

                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                        </li>
                        <li class="item {{__('content.float')}}">
                            <a href="{{route('admin.advertisement.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

    @if($data['logactivity']->count())
        <div class="paper_style1">
            <div class="title_style1 marginb10 tcenter">
                <p class="title1">{{__('content.log_history')}}</p>
            </div><!--title_style1-->

            <div class="clearfix">
                <div class="table_style1 type2">
                    <table>
                        <thead>
                            <tr>
                                <th class="width50">توضیحات</th>
                                <th class="width10">تاریخ</th>
                            </tr>
                        </thead>
                        @php

                        @endphp
                        <tbody>
                            @foreach ($data['logactivity'] as $log)
                                <tr>
                                    <td class="tright">
                                        @if(isset($log->changes()['old']))
                                            @php $details = null; @endphp
                                            @foreach($log->changes()['attributes'] as $key => $value)
                                                @php $details .= "<i class='logTitle'>".__('log.'.$key).": </i>".$value." "; @endphp
                                            @endforeach
                                            @php $oldDetails = null; @endphp
                                            @foreach($log->changes()['old'] as $key => $value)
                                                @php $oldDetails .= "<i class='oldLogTitle'>".__('log.'.$key).": </i>".$value." "; @endphp
                                            @endforeach
                                            {{showLogActivity($log->description)}} {{$log->subject_type::getName()}} توسط کاربر {{$log->causer_type::find($log->causer_id)->fullName()}} با اطلاعات زیر : <br>{!! $details !!}<br> [ اطلاعات قدیمی ] {!! $oldDetails !!}
                                        @else
                                            @php $details = null; @endphp
                                            @foreach($log->changes()['attributes'] as $key => $value)
                                                @php $details .= "<i class='logTitle'>".__('log.'.$key).": </i>".$value." "; @endphp
                                            @endforeach
                                            {{showLogActivity($log->description)}} {{$log->subject_type::getName()}} توسط کاربر {{$log->causer_type::find($log->causer_id)->fullName()}} با اطلاعات زیر : <br>{!! $details !!}
                                        @endif
                                    </td>
                                    <td>
                                        {{ShowTime($log->created_at)}} - {{ShowDate($log->created_at)}} <br/>
                                        {{showAgoTime($log->created_at)}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

{{--Active Menu--}}
@section('admin.advertisement.index','active')
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

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

@section('js')
    @include('admin.developer.choose-advertisement')
   {{--  <script>
        $(document).ready(function(){
            $('input[type=file]').change(function(){
                $('.pic_preview_style1').removeAttr('style');
            });
        });
    </script> --}}
@endsection