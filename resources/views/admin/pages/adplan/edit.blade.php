@extends('admin.master')
@section('css')
    <style>
        .form_style2 .tokenfield .token-input {
            padding-right: 10px !important;
            padding-left: 0 !important;
            direction: rtl !important;
            margin-top: 1px !important;
            border-radius: 2px;
        }

        .tokenfield.form-control {
            border: 1px solid #e5e5e5;
            border-radius: 2px;
        }

        .select_style2.height36 {
            height: 40px;
        }

        .form_style2 .tokenfield {
            height: 39px !important;
            overflow: hidden !important;
        }
    </style>
@endsection
@section('content')
    <div class="paper_style1">
        <div class="marginb100">
            <div class="title_style1 {{__('content.float')}}">
                <p class="title1">{{$header['edit']['title']}}</p>
                <p class="title2">{{$header['edit']['description']}}</p>
            </div>
        </div>

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.adplan.update',$adplan->id)}}" enctype="multipart/form-data">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">{{__('content.title_adplan')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{$adplan->title}}">
                        </div>
                    </li>

                    @php
                        $ad_section_array = array();
                        foreach($adplan->ad_sections as $adplan_ad_section){
                            array_push($ad_section_array,$adplan_ad_section->id);
                        }
                    @endphp
                    <li class="item {{__('content.float')}} width100">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">مکان تبلیغاتی :<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class='item_inner'>
                            <select name="ad_section[]" class="js-example-basic-single" multiple="multiple" data-placeholder="مکان تبلیغاتی">
                                <option value="">مکان تبلیغاتی</option>
                                @foreach($data['ad_sections'] as $ad_section)
                                    <option value="{{$ad_section->id}}" @if($ad_section_array != null && in_array($ad_section->id,$ad_section_array)) selected="selected" @endif>{{$ad_section->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="item width100 {{__('content.float')}} editor_style">
                        <hr class="hr_style2 margint15">
                        <p class="title_style4">{{__('content.content_adplan')}}<i class="required_style1">*</i></p>
                        <hr class="hr_style2 margint15">
                        <div class="item_inner">
                            <textarea name="description" class="autosize">{{$adplan->description}}</textarea>
                        </div>
                    </li>

                    <li class='item fright width100' id='file_cropper'>
                        <div class='clearfix'></div>
                        <div class='title_style4'>عکس<i class="required_style1">*</i></div>
                        <hr class='hr_style2 margint5'/>

                        <p class='field_text'>
                            {{__('content.minimum_width_photo')}} : 580px /
                            {{__('content.minimum_height_photo')}} : 180px
                            {{--{{__('content.max_file_size_allowed')}} : 700KB--}}
                        </p>
                        <div class='file_style1 file_style'>
                            <span class='file_label'>{{__('content.choose_file')}}</span>
                            <input type='file' accept='image/jpg,image/jpeg,image/png,image/gif' name='pic' data-image-info data-width='0' data-height='0' data-file-style data-run-cropper data-x='3.23' data-y='1' data-element='#cropper1' onChange='preview(this,$("#cropper1 .cropper_holder"));' class='valid_group1'/>
                        </div>
                        <hr class='hr_style2 margint30'/>

                        <div class='cropper ltr tcenter' id='cropper1'>
                            <div class='data_remove_file_holder'>
                                @php $image = $adplan->takeImage(); @endphp
                                <a href='#' class='rmv_file remove_file_style2 type3' data-remove-file data-scope='#file_cropper' data-input-name='pic' data-table='' data-pic-place='.cropper_preview' data-pic-default="{{$image}}" data-rmv-elm='.cropper_holder *' style='display:none;'></a>
                                <span class='pic_style1' onClick="$('input[name=pic]').click();">
                                    <span class='inner cropper_preview' style="background-image:url({{$image}});width:296px;height:200px;background-size: contain;"></span>
                                </span>
                            </div><!--data_remove_file_holder-->
                            <div class='cropper_holder' style='width:500px;max-height:190px;'></div>
                            <input data-crop-x type='hidden' name='cropper[x]' value=''>
                            <input data-crop-y type='hidden' name='cropper[y]' value=''>
                            <input data-crop-w type='hidden' name='cropper[w]' value=''>
                            <input data-crop-h type='hidden' name='cropper[h]' value=''>
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
                            <a href="{{route('admin.adplan.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
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
@section('admin.adplan.index','active')
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