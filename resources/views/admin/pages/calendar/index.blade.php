@extends('admin.master')
@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">فیلتر تاریخ</p>
        </div><!--title_style1-->
        <hr class="hr_style1 margint5 marginb15">
        <form method="get" id="search-form" class="form-inline" role="form">
            <div class="form_style2">
                <ul class="list clearfix">
                    <li class="item fright width50">
                        <div class='item_inner'>
                            <select name="year" class="js-example-basic-single" data-placeholder="انتخاب سال">
                                <option value="">انتخاب سال</option>
                                <option value="{{$data['jalali'][0]}}" selected="selected">{{$data['jalali'][0]}}</option>
                                <option value="{{$data['jalali'][0]+1}}">{{$data['jalali'][0]+1}}</option>
                            </select>
                        </div>
                    </li>
                    <li class="item fright width50 nospace">
                        <div class="item_inner">
                            @php
                                $months = array(
                                "فروردین"=>"1",
                                "اردیبهشت"=>"2",
                                "خرداد"=>"3",
                                "تیر"=>"4",
                                "مرداد"=>"5",
                                "شهریور"=>"6",
                                "مهر"=>"7",
                                "آبان"=>"8",
                                "آذر"=>"9",
                                "دی"=>"10",
                                "بهمن"=>"11",
                                "اسفند"=>"12"
                                )
                            @endphp
                            <select name="month" class="js-example-basic-single" data-placeholder="انتخاب ماه">
                                <option value="">انتخاب ماه</option>
                                @foreach($months as $key => $value)
                                    <option value="{{$value}}" @if($data['jalali'][1] == $value) selected="selected" @endif>{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                </ul>
            </div><!--form_style2-->
            <hr class="hr_style1 margint5 marginb10">
            <div class="btn_group_style1" id="viewport1">
                <ul class="list clearfix">
                    <li class="item fright">
                        <input type="submit" value="اعمال فیلتر" class="btn_style2 green search_button">
                    </li>
                    <li class="item fright"><a href="{{route('admin.calendar.index')}}" class="btn_style2">لغو فیلتر</a></li>
                </ul>
            </div><!--btn_group_style1-->
        </form>
    </div>

    <div class="paper_style1">
        <div class="clearfix">
            <div class="table_style1 type2">
                <table>
                    <thead>
                        <tr>
                            <th class="width10">روز</th>
                            <th class="width40">تاریخ</th>
                            <th class="width10">صبح</th>
                            <th class="width10">ظهر</th>
                            <th class="width10">عصر</th>
                        </tr>
                    </thead>
                    @php

                    @endphp
                    <tbody>
                        @for($i=$day;$i<$last_day;$i++)
                        <tr id="dt_{{$i}}">
                            @if(in_array(\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0),$data['calendar']))
                                @php $index = array_search(\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0), $data['calendar']) @endphp
                                <input type="hidden" class="date" value="{{\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0)}}">
                                <td>{{show_persian_day_string(\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0))}}</td>
                                <td>{{show_persian_with_month_no_slash(\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0))}}</td>
                                <td><label class="checkradio_style1 type2"><input type="checkbox" class="morning" name="morning" data-id="{{$i}}" value="1" @if($data['calendars'][$index]['morning'] == 1) checked="" @endif><span class="box"></span></label></td>
                                <td><label class="checkradio_style1 type2"><input type="checkbox" class="noon" name="noon" data-id="{{$i}}" value="1" @if($data['calendars'][$index]['noon'] == 1) checked="" @endif><span class="box"></span></label></td>
                                <td><label class="checkradio_style1 type2"><input type="checkbox" class="afternoon" name="afternoon" data-id="{{$i}}" value="1" @if($data['calendars'][$index]['afternoon'] == 1) checked="" @endif><span class="box"></span></label></td>
                            @else
                                <input type="hidden" class="date" value="{{\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0)}}">
                                <td>{{show_persian_day_string(\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0))}}</td>
                                <td>{{show_persian_with_month_no_slash(\Carbon\Carbon::create($dt->year, $dt->month, $i,0,0,0))}}</td>
                                <td><label class="checkradio_style1 type2"><input type="checkbox" class="morning" name="morning" data-id="{{$i}}" value="1" checked=""><span class="box"></span></label></td>
                                <td><label class="checkradio_style1 type2"><input type="checkbox" class="noon" name="noon" data-id="{{$i}}" value="1" checked=""><span class="box"></span></label></td>
                                <td><label class="checkradio_style1 type2"><input type="checkbox" class="afternoon" name="afternoon" data-id="{{$i}}" value="1" checked=""><span class="box"></span></label></td>
                            @endif
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('PageHeading',__('content.management_calendar'))

{{--Active Menu--}}
@section('admin.calendar.index','active')
{{--End Active Menu--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}

@section('js')
    <script>
        $(document).ready(function(){
            $('input[type=checkbox]').click(function(){
                var id = $(this).data('id');
                var date = $('#dt_'+id+" input.date").val();
                var morning,noon,afternoon;
                if($('#dt_'+id+" input.morning").is(':checked')){ morning = 1; } else { morning = 0; }
                if($('#dt_'+id+" input.noon").is(':checked')){ noon = 1; } else { noon = 0; }
                if($('#dt_'+id+" input.afternoon").is(':checked')){ afternoon = 1; } else { afternoon = 0; }
                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('_token', _token);
                formData.append('date', date);
                formData.append('morning', morning);
                formData.append('noon', noon);
                formData.append('afternoon', afternoon);
                $.ajax({
                    type: 'post',
                    url: '{{route('admin.calendar.store')}}',
                    data: formData,
                    success: function () {
                        show_notif('',"عملیات با موفقیت انجام شد.",'s',5000)
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function() {
                        show_notif('',"متاسفانه عملیات با موفقیت انجام نشد.",'e',false)
                    }
                });

            });
        });
    </script>
@endsection