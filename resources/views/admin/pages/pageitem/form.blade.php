<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">عنوان:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('title',null,['placeholder'=>'عنوان آیتم را وارد نمایید.']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">زیر عنوان:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('subtitle',null,['placeholder'=>'زیر عنوان آیتم را وارد نمایید.']) !!}
            </div>
        </li>
        @php
        $class=Auth::guard('admins')->user()->role_id=='1'?'width50 nospace':'width100';
        @endphp
        @role('atlas-administrator')
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">آیکن:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('icon',null,['placeholder'=>'آیکن آیتم را وارد نمایید.']) !!}
            </div>
        </li>
        @endrole
        <li class="item {{__('content.float')}} {{$class}}">
            <hr class="hr_style2 margint15">
            <p class="title_style4">لینک:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('link',null,['placeholder'=>'لینک آیتم را وارد نمایید.']) !!}
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
