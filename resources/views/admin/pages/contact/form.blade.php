<div class="form_style2">
    <ul class="list clearfix">
        {{--<li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">عنوان:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('title',null,['placeholder'=>'عنوان را وارد نمایید']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">زیر عنوان:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('subtitle',null,['placeholder'=>'زیر عنوان را وارد نمایید.']) !!}
            </div>
        </li>--}}

        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">تلفن:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('phone',null,['placeholder'=>'شماره تلفن را وارد نمایید.']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">ایمیل:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('email',null,['placeholder'=>'ایمیل را وارد نمایید.']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">فکس:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('fax',null,['placeholder'=>'شماره فکس را وارد نمایید.']) !!}
            </div>
        </li>
        {{--<li class="item {{__('content.float')}} width50 ">
            <hr class="hr_style2 margint15">
            <p class="title_style4">موبایل:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('mobile',null,['placeholder'=>'شماره موبایل را وارد نمایید.']) !!}
            </div>
        </li>--}}

        <li class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">آدرس:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('address',null,['placeholder'=>'آدرس را وارد نمایید.']) !!}
            </div>
        </li>
       {{-- <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">کد پستی:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('postal_code',null,['placeholder'=>'کد پستی را وارد نمایید.']) !!}
            </div>
        </li>--}}

        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">عرض جغرافیایی:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('latitude',null,['placeholder'=>'عرض جغرافیایی را وارد نمایید.']) !!}
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">طول جغرافیایی:<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::text('longitude',null,['placeholder'=>'طول جغرافیایی']) !!}
            </div>
        </li>
        <li  class="item {{__('content.float')}} width100">
            <hr class="hr_style2 margint15">
            <p class="title_style4">توضیحات:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                {!! Form::textarea('description',null,['placeholder'=>'توضیحات را وارد نمایید.']) !!}
            </div>
        </li>
        <hr class="hr_style1 marginb20 margint20">
       {{-- <li class="item {{__('content.float')}} width20">
            <div class="item_inner">
                <label for="main">اطلاعات اصلی</label>
                <input type="checkbox" name="main" id="main" value="1" {{(isset($edit) && $contact->main)?'checked':''}}>
            </div>
        </li>--}}
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
