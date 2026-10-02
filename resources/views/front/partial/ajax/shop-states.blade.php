{!! Form::open([
'url'=>route('front.profile.shop.set-covered-states',$shop),
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
    @foreach($states as $index=>$state)
        <li  class="item">
                <div class="table_style2">
                    <table>
                        <tbody>
                        <tr>
                            <td  width="70" style="width: 50px;">
                                <label class="check_radio_style1">
                                    <input type="checkbox" name="states[]" class="all-child" value="{{$state->id}}" {{in_array($state->id,$shopStates)?'checked':''}}>
                                    <span class="icon"></span>
                                </label>
                            </td>
                            <td  width="220">
                                {{$state->name}}
                            </td>
                            <td  width="220">
                                <input type="text" placeholder="قیمت (تومان)" name="price_{{$state->id}}" class="frm_input all-child currency">
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