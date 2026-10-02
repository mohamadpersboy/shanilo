@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>
                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            <div class="product_edit flex">
                                <div class="form_style2">
                                    {!! Form::model($product,[
                                    'url'=>route('front.profile.product.update',$product),
                                    'data-ajax',
                                    'data-type'=>'json',
                                    'method'=>'PATCH',
                                    'data-on-success'=>'alert-message',
                                    'data-on-error'=>'inline-message',
                                    ]) !!}
                                    @include('front.pages.profile.product.form')
                                    {!! Form::close() !!}
                                </div>
                                @include('front.partial.parts.side-product-info')
                            </div>
                            <div class="product_edit2">
                                <div class="btn_part_style1 flex">
                                    <a href="{{route('front.profile.productDetail.create',$product)}}"
                                       class="btn_style7 flex">
                                        <div class="text z_index2">ایجاد تنوع جدید</div>
                                        <div class="icon"><i class="i-049-add"></i></div>
                                    </a>
                                </div>
                                @if($product->details->count())
                                    <div class="panel_table table_style2">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th class="w10">مشخصه</th>
                                                <th class="w10">قیمت</th>
                                                <th class="w10">موجودی</th>
                                                <th class="w10">رنگ</th>
                                                <th class="w10">شاخص</th>
                                                <th class="w20">پیشنهاد ویژه</th>
                                                <th class="w20">فروش ویژه</th>
                                                <th class="w5">ویرایش</th>
                                                <th class="w5">حذف</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($product->details as $index=>$detail)
                                                <tr id="productDetail-{{$detail->id}}">
                                                    <td>{{$detail->feature?:'-'}}</td>
                                                    <td>{{showPrice($detail->pure_price)}}</td>
                                                    <td>{{$detail->count}}</td>
                                                    <td>
                                                        <div class="color_style1 flex">
                                                            <span class="title">{{$detail->color->title}}</span>
                                                            <span class="color"
                                                                  style="background-color: {{$detail->color->code}};"></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label for="detail-radio-{{$detail->id}}"
                                                               class="check_radio_style1">
                                                            <input data-url="{{route('front.profile.productDetail.setAsIndex',$detail)}}"
                                                                   id="detail-radio-{{$detail->id}}" name="index"
                                                                   type="radio" {{$detail->index?'checked':''}}>
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td id="detail-suggestion-{{$detail->id}}">
                                                        @if($detail->product->display)
                                                            @if($specialSuggestion=$detail->specialSuggestion)
                                                                @if($specialSuggestion->inFirstPage())
                                                                    <div>
                                                                        <span>انقضا:</span><span>{{ShowDate($specialSuggestion->firstPageSpecialSuggestion->expires_at)}}</span>
                                                                    </div>
                                                                @else
                                                                    <div data-url="{{route('front.profile.firstPageSpecialSuggestion.create',$specialSuggestion)}}"
                                                                         class="btn_style2 type2 type3 modal_btn home_page_price_modal_btn">
                                                                        افزودن به صفحه اصلی
                                                                    </div>
                                                                @endif
                                                                <a data-url="{{route('front.profile.specialSuggestion.destroy',$specialSuggestion)}}"
                                                                   data-block="#detail-suggestion-{{$detail->id}}"
                                                                   class="btn_style2 btn-delete type2 type3 dlt_btn"
                                                                   href="javascript:void(0)"><i
                                                                            class="i-031-trash"></i><span>حذف از پیشنهاد ویژه</span>
                                                                </a>
                                                            @else
                                                                {!! Form::open([
                                                                    'url'=>route('front.profile.specialSuggestion.store',$detail),
                                                                    'data-ajax',
                                                                    'data-on-success'=>'redirect',
                                                                    'data-on-error'=>'alert-message',
                                                                    'data-type'=>'json'
                                                                ]) !!}
                                                                <button class="btn_style2 type2" href="">افزودن به
                                                                    پیشنهاد
                                                                    ویژه
                                                                </button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                                    <td id="special-sell-{{$detail->id}}">
                                                        @if($detail->product->display)
                                                            @if($specialSell=$detail->specialSell)
                                                                @if($specialSell->inFirstPage())
                                                                    <div>
                                                                        <span>انقضا:</span><span>{{ShowDate($specialSell->firstPageSpecialSell->expires_at)}}</span>
                                                                    </div>
                                                                @else
                                                                    <div
                                                                            data-block="#special-sell-{{$detail->id}}"
                                                                            data-url="{{route('front.profile.firstPageSpecialSell.create',$specialSell)}}"
                                                                            class="btn_style2 type2 type3 modal_btn home_page_price_modal_btn">
                                                                        افزودن به صفحه اصلی
                                                                    </div>
                                                                @endif
                                                                <a data-url="{{route('front.profile.specialSell.destroy',$specialSell)}}"
                                                                   data-block="#special-sell-{{$detail->id}}"
                                                                   class="btn_style2 type2 type3 btn-delete dlt_btn"
                                                                   href="javascript:void(0)">
                                                                    <i class="i-031-trash"></i><span>حذف از فروش ویژه</span>
                                                                </a>
                                                            @else
                                                                {!! Form::open([
                                                                   'url'=>route('front.profile.specialSell.store',$detail),
                                                                   'data-ajax',
                                                                   'data-on-success'=>'redirect',
                                                                   'data-on-error'=>'alert-message',
                                                                   'data-type'=>'json'
                                                               ]) !!}
                                                                <button class="btn_style2 type2">افزودن به فروش ویژه
                                                                </button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{route('front.profile.productDetail.edit',$detail)}}"><i
                                                                    class="i-045-mark"></i></a></td>
                                                    <td id="prd-{{$detail->id}}"><a
                                                                data-url="{{route('front.profile.productDetail.destroy',$detail)}}"
                                                                data-block="#prd-{{$detail->id}}" class="btn-delete"
                                                                href="javascript:void(0)"><i
                                                                    class="i-031-trash"></i></a></td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- table_style2 -->
                                @else
                                    <div class="noItem_style2 flex">هیج رنگی اضافه نشده!</div>
                                @endif
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.upload-img-profile')
    <div class="modal_style1 modal_style2 home_page_price_modal w550">
        <div class="modal_scroll flex">
            <div class="close_bg"></div>
            <div class="wrapper">
                <div class="wrapper_box">
                    <div class="close_btn"><i class="i-cancel"></i></div>
                    <div class="title_style8"><span>تعرفه های نمایش محصول شما در صفحه اصلی شانیلو</span></div>
                    <div style="min-height: 200px;" class="side_container">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal_style1 modal_style2 home_page_price_modal2 w550">
        <div class="modal_scroll flex">
            <div class="close_bg"></div>
            <div class="wrapper">
                <div class="wrapper_box">
                    <div class="close_btn"><i class="i-cancel"></i></div>
                    <div class="title_style8"><span>نتیجه پرداخت نمایش محصول در صفحه اصلی</span></div>
                    <div style="min-height: 200px;" class="side_container">
                        @if($result=Session::get('planOrdered'))
                            <div class="cart_result flex">
                                @if($result['type']=='success')
                                    <div class="success_cart box side_box_shadow">
                                        <div class="cart_icon"><i class="i-checked"></i></div>
                                        <div class="cart_text">{{$result['header']}}</div>
                                        <ul class="step cart_step no_bullet">
                                            <li class="item">{{$result['message']}}</li>
                                            <li class="item">شماره تراکنش: {{Session::get('payment')->ref_id}}</li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="error_cart box side_box_shadow" style="display: none;">
                                        <div class="cart_icon"><i class="i-cancel"></i></div>
                                        <div class="cart_text">متاسفانه مشکلی در هنگام پرداخت رخ داده!</div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--cropper-->
    <link href='_plugins/cropper/cropper.min.css' rel='stylesheet' type='text/css'>
    <script src='_plugins/cropper/cropper.min.js'></script>

    <script>

        $(document).ready(function () {
            /////////////////////////////
            //modal style2
            var atlasweb = new Atlasweb();
            $('.home_page_price_modal_btn').click(function () {
                var modal = $('.modal_style2.home_page_price_modal').fadeIn(300);
                $('body').css('overflow', 'hidden');
                var url = $(this).data('url'),
                    container = modal.find('.side_container');
                container.html("");
                atlasweb.block(container);
                $.getJSON(url, function (response) {
                    atlasweb.unblock(container);
                    container.html(response.view);
                }).fail(function (error) {
                    atlasweb.showAlertErrorMessages(error);
                });

            });
            @if(Session::get('planOrdered'))
            $('.modal_style2.home_page_price_modal2').fadeIn(300);
            $('body').css('overflow', 'hidden');
            @endif
        });//document ready

    </script>

@endsection
@section('js')
    @include('front.plugins.city-select-2')
@endsection
