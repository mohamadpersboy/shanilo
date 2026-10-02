<div class="form_style2">
    <ul class="list clearfix">
        <li class="item {{__('content.float')}} width50">
            <hr class="hr_style2 margint15">
            <p class="title_style4">وضعیت پرداخت</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="payment_status" class="js-example-basic-single">
                    <option {{$order->payment->status=='successful'?'selected':''}} value="successful">موفق</option>
                    <option {{$order->payment->status=='unsuccessful'?'selected':''}} value="unsuccessful">ناموفق</option>
                    <option {{$order->payment->status=='pending'?'selected':''}} value="pending">در انتظار پرداخت</option>
                </select>
            </div>
        </li>
        <li class="item {{__('content.float')}} width50 nospace">
            <hr class="hr_style2 margint15">
            <p class="title_style4">وضعیت:</p>
            <hr class="hr_style2 margint15">
            <div class="item_inner">
                <select name="status" class="js-example-basic-single">
                    <option {{$order->status=='pending'?'selected':''}} value="pending">در انتظار تایید</option>
                    <option {{$order->status=='accepted'?'selected':''}} value="accepted">تایید شده</option>
                    <option {{$order->status=='sent'?'selected':''}} value="sent">ارسال شد</option>
                    <option {{$order->status=='denied'?'selected':''}} value="denied">رد شده</option>
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
