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

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.adtime.update',$adtime->id)}}" enctype="multipart/form-data">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    <li class="item {{__('content.float')}} width50">
                        <p class="field_label">{{__('content.title_adtime')}}:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="title" value="{{$adtime->title}}">
                        </div>
                    </li>

                    <li class="item {{__('content.float')}} width50 nospace">
                        <p class="field_label">زمان به روز:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <input type="text" name="day" value="{{$adtime->day}}">
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
                            <a href="{{route('admin.adtime.index')}}" class="btn_style2">{{__('content.cancel_and_return')}}</a>
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
@section('admin.adtime.index','active')
{{--End Active Menu--}}