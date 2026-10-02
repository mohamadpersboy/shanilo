@extends('admin.master')
@section('content')

<div class="paper_style1">
    <div class="clearfix">
        <div class="table_style1 type2">
            <form action="{{route('admin.week.store')}}" method="post">
                {{csrf_field()}}
                <table>
                    <thead>
                        <tr>
                            <th class="width10">روز</th>
                            <th class="width10">از ساعت</th>
                            <th class="width10">تا ساعت</th>
                        </tr>
                    </thead>
                    @php

                    @endphp
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($data['weeks'] as $week)
                            <tr>
                                <td>
                                    {{$week['shamsi']}}
                                    <input type="hidden" name="week[]" value="{{$week['milady']}}">
                                </td>
                                <td>
                                    <select name="from[]" class="js-example-basic-single">
                                        @foreach($data['times'] as $time)
                                            <option value="{{$time['value']}}" @if($data['queryWeeks'][$i]['from'] == $time['value']) selected="" @endif>{{$time['show']}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="to[]" class="js-example-basic-single">
                                        @foreach($data['times'] as $time)
                                            <option value="{{$time['value']}}" @if($data['queryWeeks'][$i]['to'] == $time['value']) selected="" @endif>{{$time['show']}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @php $i++; @endphp
                        @endforeach
                        <tr>
                            <td colspan="3">
                                <button type="submit" class="btn_style2 green" style="width: 100%;">ثبت تغییرات</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

@endsection


{{--Active Menu--}}
@section('admin.week.index','active')
{{--End Active Menu--}}

{{--Select2--}}
@section('select2')
    @include('admin.developer.select2')
@endsection
{{--End Select2--}}