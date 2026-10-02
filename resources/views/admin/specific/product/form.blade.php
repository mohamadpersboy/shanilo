<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">وضعیت محصول :<i class="required_style1">*</i></p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="display" class="js-example-basic-single">
                    <option value="0" {{$product->display==0?'selected':''}}>در انتظار تایید</option>
                    <option value="1" {{$product->display==1?'selected':''}}>تایید</option>
                </select>
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
