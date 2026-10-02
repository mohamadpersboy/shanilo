{!! Form::open([
    'url'=>$route,
]) !!}
{!! Form::hidden('suggestion_id',$suggestion->id) !!}
{!! Form::hidden('suggestion_sid',bcrypt($suggestion->id)) !!}
<ul class="list_step no_bullet">
    @foreach($plans as $index=>$plan)
        <li class="list_item">
            <label for="modal-plan-{{$plan->id}}" class="flex">
            <span class="flex">
                <span class="check_radio_style1">
                    <input id="modal-plan-{{$plan->id}}" type="radio" value="{{$plan->id}}" name="plan_id" {{$index==0?"checked":''}}>
                    <span></span>
                </span>
                <span>{{$plan->title}}</span>
            </span>
                <span>{{showPrice($plan->price)}}</span>
            </label>
        </li>
    @endforeach
</ul>
<div class="title_style8"><span>انتخاب شیوه پرداخت</span></div>
<ul class="list_step no_bullet">
    @foreach($payTypes as $index=>$payType)
        <li class="list_item">
            <label for="modal-pay-type-{{$payType->id}}" class="flex">
            <span class="flex">
                <span class="check_radio_style1">
                    <input id="modal-pay-type-{{$payType->id}}" type="radio" value="{{$payType->id}}" name="pay_type_id" {{$index==0?"checked":''}}>
                    <span></span>
                </span>
                <span>{{$payType->title}}</span>
            </span>
                @if($payType->type=='credit')
                <span> اعتبار شما: {{showPrice(auth()->user()->credit)}}</span>
                @endif
            </label>
        </li>
    @endforeach
</ul>
<button class="btn_style2">
    <span class="btn">پرداخت و ثبت</span>
</button>
{!! Form::close() !!}