<div class="unit_style1 mt30">
    <ul class="step no_bullet flex">
        <li class="item {{in_array(1,$checked)?'checked':''}} {{$activeMenu==1?'active':''}}"><!-- has class = 'checked' 'active' -->
            <a href="{{in_array(1,$checked)?route('front.cart.step1'):'javascript:void(0)'}}" title="" class="link">
                <div class="num">1.</div>
                <div class="title">انتخاب فروشگاه</div>
            </a>
        </li>
        <li class="item {{in_array(2,$checked)?'checked':''}} {{$activeMenu==2?'active':''}}">
            <a href="{{in_array(2,$checked)?route('front.cart.step2',$cartDetail):'javascript:void(0)'}}" title="" class="link">
                <div class="num">2.</div>
                <div class="title">ورود / عضویت</div>
            </a>
        </li>
        <li class="item {{in_array(3,$checked)?'checked':''}} {{$activeMenu==3?'active':''}}">
            <a href="{{in_array(3,$checked)?route('front.cart.step3',$cartDetail):'javascript:void(0)'}}" title="" class="link">
                <div class="num">3.</div>
                <div class="title">اطلاعات پستی گیرنده</div>
            </a>
        </li>
        <li class="item {{in_array(4,$checked)?'checked':''}} {{$activeMenu==4?'active':''}}" >
            <a href="{{in_array(4,$checked)?route('front.cart.step4',$cartDetail):'javascript:void(0)'}}" title="" class="link">
                <div class="num">4.</div>
                <div class="title">روش ارسال</div>
            </a>
        </li>
        <li class="item {{in_array(5,$checked)?'checked':''}} {{$activeMenu==5?'active':''}}">
            <a href="{{in_array(5,$checked)?route('front.cart.step5',$cartDetail):'javascript:void(0)'}}" title="" class="link">
                <div class="num">5.</div>
                <div class="title">بازبینی سفارش</div>
            </a>
        </li>
        <li class="item {{in_array(6,$checked)?'checked':''}} {{$activeMenu==6?'active':''}}">
            <a href="{{in_array(6,$checked)?route('front.cart.step6',$cartDetail):'javascript:void(0)'}}" title="" class="link">
                <div class="num">6.</div>
                <div class="title">انتخاب روش پرداخت</div>
            </a>
        </li>
    </ul>
</div>