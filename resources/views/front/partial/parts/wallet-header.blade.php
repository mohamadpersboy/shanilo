<div class="btn_part_style1 flex mb30 type2 user_wallet_header_btn">
    <a href="{{route('front.profile.wallet.index')}}" class="btn_style6 gray {{$subActiveMenu=='wallets'?'active':''}}">کیف پول ها</a>
    <a href="{{route('front.profile.bankCart.index')}}" class="btn_style6 gray {{$subActiveMenu=='bankcarts'?'active':''}}">کارت ها</a>
    <a href="{{route('front.profile.checkout.index')}}" class="btn_style6 gray {{$subActiveMenu=='checkouts'?'active':''}}">تسویه حساب</a>
    <a href="{{route('front.profile.credit.request.index')}}" class="btn_style6 gray {{$subActiveMenu=='request-credit'?'active':''}}">تسویه موجودی</a>
    <a href="{{route('front.profile.credit.index')}}" class="btn_style6 gray {{$subActiveMenu=='credit'?'active':''}}">افزایش موجودی</a>
</div>
