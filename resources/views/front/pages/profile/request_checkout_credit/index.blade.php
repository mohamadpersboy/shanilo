@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>
                        @include('front.partial.dashboard')
                        <div id="pjax-container" class='panel_content'>
                            @include('front.partial.parts.wallet-header')
                            <div class="title_style8"><span>تسویه حساب</span></div>
                            <div class="panel_cart_give_money flex">
                                <div class="form_style2">
                                    <form action="{{ route('front.profile.credit.request.store') }}" method="post">
                                        {!! csrf_field() !!}
                                        <ul class="frm_step flex no_bullet">
                                            <li class="frm_item flex w30 not_empty">
                                                <input disabled value="{{ $user->credit }}" type="text"
                                                       class="frm_input currency">
                                                <div class="frm_title">موجودی شما (تومان)</div>
                                            </li>
                                            <li class="frm_item flex w40 not_empty">

                                                <select name="bank_cart_id" class="frm_select" id="">
                                                    <option value="">کارت بانکی</option>
                                                    @foreach($bankCarts as $index=>$bankCart)
                                                        <option @if(old('bank_cart_id') == $bankCart->id) selected
                                                                @endif value="{{$bankCart->id}}">{{$bankCart->owner}}
                                                            ({{$bankCart->cart_no}})
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <div class="frm_title">کارت بانکی</div>
                                            </li>
                                            <li class="frm_item flex w30 not_empty">

                                                <input type="text" class="frm_input currency" value="{{ old('price') }}"
                                                       name="price"
                                                       placeholder="مبلغ درخواستی  ">
                                                <div class="frm_title">مبلغ درخواستی (تومان)</div>

                                            </li>

                                            <li class="frm_item w100 row_flex flex">
                                                <button class="btn_style2 flex">
                                                    <span class="icon"><i class="i-044-checked"></i></span>
                                                    <span class="text">درخواست تسویه</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>

                            @if($request_checkout_credits->count())
                                <div class="table_style1 mt70">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>شماره درخواست</th>
                                            <th> مبلغ درخواستی</th>
                                            <th>شماره پیگیری</th>
                                            <th> تاریخ درخواست</th>
                                            <th>تاریخ تسویه</th>
                                            <th>وضعیت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($request_checkout_credits as $request_checkout_credit)
                                            <tr>
                                                <td>{{ $request_checkout_credit->id }}</td>
                                                <td><span class="price">{{ $request_checkout_credit->price }}</span>
                                                </td>
                                                <td>{{$request_checkout_credit->tracking_code}}</td>
                                                <td>{{$request_checkout_credit->request_at}}</td>
                                                <td>{{$request_checkout_credit->done_at}}</td>
                                                <td>
                                                    @if($request_checkout_credit->status=='done')
                                                        <span class="condition_show green">تسویه شد</span>
                                                    @elseif($request_checkout_credit->status=='reject')
                                                        <span class="condition_show red">رد شد</span>
                                                    @else
                                                        <span class="condition_show orange">درحال بررسی</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination_style2">
                                    {{$request_checkout_credits->render('vendor.pagination.dashboard')}}
                                </div>
                            @else
                                <div class="noItem_style2 flex">موردی اضافه نشده!</div>
                            @endif
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    <script>

      $(document).ready(function () {
        /////////////////////////////
        //modal style2
        $('.cart_box_style1 .item.modal_btn.cart_modal_btn ').click(function () {
          $('.modal_style1.cart_box_modal').fadeIn(300);
          $('body').css('overflow', 'hidden');
        });
        //modal style2
        $('.add_cart_btn.modal_btn ').click(function () {
          $('.modal_style1.add_cart_modal').fadeIn(300);
          $('body').css('overflow', 'hidden');
        });
        //////////////////////////////
        // delete click
        $('.box_style8 .item .dlt_btn > i').click(function () {
          $(this).parent('.dlt_btn').addClass('active');
        });
        $('.box_style8 .item .dlt_btn .short_request .btn.no').click(function () {
          $(this).parents('.dlt_btn').removeClass('active');
        });

      });//document ready
    </script>







    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

      $(document).ready(function () {

      });//document ready

    </script>

@endsection
