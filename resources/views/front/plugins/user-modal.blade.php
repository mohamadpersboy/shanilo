@php
$title=Route::getCurrentRoute()->getName()=='front.product.show'?'مشتریانی که این محصول را خریداری کرده اند':
'مشتریانی که از این فروشگاه خرید کرده اند.';
@endphp
<div class="modal_style1 user_modal w550">
    <div class="modal_scroll flex">
        <div class="close_bg"></div>
        <div class="wrapper">
            <div class="wrapper_box">
                <div class="close_btn"><i class="i-cancel"></i></div>
                <div class="title_style7"><span class="title">{{$title}}</span></div>
                <div class="user_style2">
                    <ul style="min-height: 200px;" class="step no_bullet">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>