<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">عنوان :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('title',null,['placeholder'=>'عنوان پلن']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">قیمت :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('price',null,['placeholder'=>'قیمت پلن']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">نوع زمان :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="func" id="func" class="js-example-basic-single">
                    <option value="">انتخاب کنید</option>
                    @foreach($funcs as $index=>$func)
                        <option {{(isset($edit) && $plan->func==$index)?'selected':''}} value="{{$index}}">{{$func}}</option>
                    @endforeach
                </select>
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">مقدار :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('amount',null,['placeholder'=>'مقدار زمان']) !!}
            </div>
        </li>
    </ul>
    <hr class="hr_style1 marginb20 margint20">
    <div class="btn_group_style1">
        <ul class="list clearfix">
            <li class="item {{__('content.float')}}">
                <input type="submit" name="submit" value="{{__('content.submit')}}" class="btn_style2 green">
            </li>
        </ul>
    </div>
</div>
