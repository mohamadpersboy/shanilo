{!! Form::open([
'url'=>route('front.profile.shop.set-covered-cities',[$shop,$state]),
'data-ajax',
'data-type'=>'json',
'data-on-success'=>'alert-message',
'data-on-error'=>'alert-message',
]) !!}
<ul class="step no_bullet">
    <li  class="item">
        <label>
            <div class="table_style2">
                <table>
                    <tbody>
                    <tr>
                        <td  width="70" style="width: 50px;">
                            <label class="check_radio_style1">
                                <input type="checkbox" class="all">
                                <span class="icon"></span>
                            </label>
                        </td>
                        <td  width="220">
                            همه
                        </td>
                        <td  width="220">
                            <input type="text" placeholder="قیمت (تومان)" class="frm_input all currency">
                        </td>
                    </tr>
                    </tbody>
                </table><!-- close .table1 -->
            </div>
        </label>
    </li>
    <li class="item">
        <hr class="hr_style1">
    </li>
    @foreach($cities as $index=>$city)
        <li  class="item">
            <div class="table_style2">
                <table>
                    <tbody>
                    <tr>
                        @php
                            $exists=array_key_exists($city->id,$shopCities);
                            $price=$exists?$shopCities[$city->id]:null
                        @endphp
                        <td  width="70" style="width: 50px;">
                            <label class="check_radio_style1">
                                <input type="checkbox" name="cities[]" class="all-child" {{$exists?'checked':''}} value="{{$city->id}}">
                                <span class="icon"></span>
                            </label>
                        </td>
                        <td  width="220">
                            {{$city->name}}
                        </td>

                        <td  width="220">
                            <input type="text" placeholder="قیمت (تومان)" value="{{$price}}" name="price_{{$city->id}}" class="frm_input all-child currency">
                        </td>
                    </tr>
                    </tbody>
                </table><!-- close .table1 -->
            </div>
        </li>
    @endforeach
    <li class="frm_item w50">
        <button class="btn_style2 flex">
            <span class="icon"><i class="i-007-arrow-2"></i></span>
            <span class="text">ثبت</span>
        </button>
    </li>
</ul>
{!! Form::close() !!}