<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">نام کشور:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('name',null,['placeholder'=>'نام کشور را وارد نمایید.']) !!}
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
