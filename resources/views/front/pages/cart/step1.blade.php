@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="cart_page">
            <div class="container">
                <div class="inner">
                    <div class="title_style8"><span>سبد خرید شما</span></div>
                    @forelse(Cart::details()  as $index=>$cartDetail)
                        <div class="table_style3">
                            <table>
                                <thead>
                                <tr>
                                    <th class="w30">
                                        <a href="{{$cartDetail->shop->path()}}" target="_blank"
                                           class="product_info_style2 flex">
                                            <span class="pic"
                                                  style="background-image: url('{{$cartDetail->shop->takeImage('avatar','60/60')}}');"></span>
                                            <span class="name">{{$cartDetail->shop->title}}</span>
                                        </a>
                                    </th>
                                    <th class="w20">
                                        مشخصه
                                    </th>
                                    <th class="w20">قیمت (تومان)</th>
                                    <th class="w10">تعداد</th>
                                    <th class="w20">قیمت کل (تومان)</th>
                                    <th class="w10">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartDetail->details as $index=>$cartDetailProduct)
                                    <tr id="cart-item-{{$cartDetailProduct->id}}">
                                        <td>
                                            <a href="{{$cartDetailProduct->productDetail->path()}}" target="_blank"
                                               class="product_info_style1 flex">
                                                <img src="{{$cartDetailProduct->productDetail->product->takeImage('main','270/150')}}"
                                                     alt="">
                                                <span style="display: block;"
                                                      class="name">{{$cartDetailProduct->productDetail->product->title}}</span>
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $feature=$cartDetailProduct->productDetail->feature;
                                                $color=$cartDetailProduct->productDetail->color;
                                            @endphp
                                            <span class="cart-feature name">{{$feature?$feature.' ':''}}{{$color->code!='#00NANNAN'?$color->title:''}}</span>
                                        </td>
                                        <td>
                                            <span class="org_price">{{showPrice($cartDetailProduct->productDetail->pure_price)}}</span>
                                        </td>
                                        <td>
                                            <div class="quantity_style1 flex">
                                                <span class="inc qty_btn">+</span>
                                                <input class="cart-product-count"
                                                       data-url="{{route('front.cart.update-count',$cartDetailProduct)}}"
                                                       type="text" value="{{$cartDetailProduct->count}}">
                                                <span class="dec qty_btn">-</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="total_price total-product-price">{{showPrice($cartDetailProduct->count*$cartDetailProduct->productDetail->pure_price)}}</span>
                                        </td>
                                        <td>
                                            <div class="dlt_btn btn-delete"
                                                 data-block="#cart-item-{{$cartDetailProduct->id}}"
                                                 data-url="{{route('front.cart.destroy',$cartDetailProduct->productDetail)}}">
                                                <i class="i-031-trash"></i></div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="cart_btn_part flex">
                                <a href="{{route('front.cart.step2',$cartDetail)}}" title=""
                                   class="btn_style8 green"><span
                                            class="text">پرداخت خرید شما از این فروشگاه</span><span class="icon"><i
                                                class="i-back"></i></span></a>
                                <span class="btn_style8">
                                        <span class="text">مجموع : <span
                                                    class="price total-cart-price">{{showPrice($cartDetail->total(true),null,null)}}</span>
                                        </span>
                                    </span>
                                <label class="check_radio_style1">
                                    <input type="checkbox" value="1"
                                           data-url="{{route('front.cart.update-show-as-customer',$cartDetail)}}"
                                           name="dont_show_as_customer" {{!$cartDetail->show_as_customer?'checked':''}}>
                                    <span class="icon"></span> عدم نمایش در لیست مشتریان
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="noItem_style2 flex">در حال حاضر سبد خرید شما خالی می باشد!</div>
                    @endforelse
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>


@endsection

@section('js')


    <script>

      $(document).ready(function () {
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        // quantity
        $('.quantity_style1 .qty_btn').on('click', function () {
          var i = $(this).siblings('input:text').val();
//            var max = 99;
          var final;
          var get_price;
          if ($(this).hasClass('inc')) {
            i++;
            $(this).siblings(':text').val(i);
            /*                final = i * get_price;
             send_price(final, this);*/
          }//endif
          else if ($(this).hasClass('dec') && i > 1) {
            i--;
            var input_value = $(this).siblings(':text').val();

            $(this).siblings(':text').val(i);

          }//endelseif
          $(this).siblings(':text').trigger('change');
        });
        /*endclick*/
        ///////////////////////////////////////////////////////////////////////////////////
        /*keypress*/
        $('.quantity_style1 input[type=text]').keyup(function (e) {

          var num = this.value.replace(/[^\d]/g, '');
          if (num.length > 3) {
            num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ' ');
          }
          this.value = num;

          var val = $(this).val();
          var max = 20;
          var min = 1;
          var final;
          if (val > 0) {
            //maximum_input
            if (val > max) {
              alert('بیشتر از حد مجاز');
              $(this).val(max);
              final = max * get_price(this);
              send_price(final, this);
            } else {
              final = val * get_price(this);
              send_price(final, this);
            }
          } else if (val <= min) {
            $(this).val(min);
          }
        });
        /*endkeypress*/

      });//document ready


    </script>

@endsection
