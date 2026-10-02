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
                                    <div class="preview_style1 flex">
                                        <div class="pic_part"><img src="files/images/product/1.jpg" alt=""></div>
                                        <div class="content_part">
                                            <div class="name">دسته بازی ایکس باکس XboX-3000</div>
                                            <div class="price_part">
                                                <div class="price_style1 flex">
                                                    <span class="org_price price">30,000،000</span>
                                                    <span class="off_price price">25,000،000</span>
                                                </div>
                                            </div>
                                            <div class="store_name">فروشگاه بازی اطلس گیم</div>
                                        </div>
                                    </div>
                                    <form data-valid-form>
                                        <ul class="frm_step flex no_bullet">
                                            <li class="frm_item w50 flex not_empty">
                                                <select class="frm_select color_select_style1" name="s2" data-valid-required>
                                                    <option>انتخاب رنگ</option>
                                                    <option data-color="#000" value="1">مشکی</option>
                                                    <option data-color="#0f0fa2" value="1">مشکی</option>
                                                    <option data-color="#FEC10C" value="1">زرد</option>
                                                    <option data-color="#0a730a" value="1">مشکی</option>
                                                </select>
                                                <div class="color"></div>
                                                <div class="frm_title">انتخاب رنگ</div>
                                            </li>
                                            <li class="frm_item w50 flex not_empty">
                                                <input type="text" class="frm_input" name="r3" placeholder="موجودی" data-valid-required data-valid-regex="^[0-9]*$">
                                                <div class="frm_title">موجودی</div>
                                            </li>
                                            <li class="frm_item w50 flex not_empty">
                                                <input type="text" class="frm_input" name="r3" placeholder="قیمت تخفیف خورده (تومان)" data-valid-required data-valid-regex="^[0-9]*$">
                                                <div class="frm_title">قیمت تخفیف خورده (تومان)</div>
                                            </li>
                                            <li class="frm_item w50 flex not_empty">
                                                <input type="text" class="frm_input" name="r4" placeholder="قیمت (تومان)" data-valid-required data-valid-regex="^[0-9]*$">
                                                <div class="frm_title">قیمت (تومان)</div>
                                            </li>
                                            <li class="frm_item w50">
                                                <button class="btn_style2 flex">
                                                    <span class="icon"><i class="i-007-arrow-2"></i></span>
                                                    <span class="text">ثبت محصول</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                                <div class="product_info">
                                    <div class="title_style8"><span>اطلاعات محصول</span></div>
                                    <ul class="step no_bullet">
                                        <li class="item flex">
                                            <div class="rate_style1 pointer_event">
                                                <div class="rate_inner clearfix">
                                                    <input type="radio" id="star5_5" name="rating[10]" value="5"><label class="full star" for="star5_5" title=" امتیاز"></label>
                                                    <input type="radio" id="star5_4" name="rating[10]" value="4" checked=""><label class="full star" for="star5_4" title=" امتیاز"></label>
                                                    <input type="radio" id="star5_3" name="rating[10]" value="3"><label class="full star" for="star5_3" title=" امتیاز"></label>
                                                    <input type="radio" id="star5_2" name="rating[10]" value="2"><label class="full star" for="star5_2" title=" امتیاز"></label>
                                                    <input type="radio" id="star5_1" name="rating[10]" value="1"><label class="full star" for="star5_1" title=" امتیاز"></label>
                                                </div>
                                                <div class="rate_text">امتیاز ثبت شده میان <spna>203</spna> نفر</div>
                                            </div>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-011-eye"></i></span>
                                            <span class="title">تعداد بازدید</span>
                                            <span class="content">163</span>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-009-shopping-cart"></i></span>
                                            <span class="title">تعداد فروخته شده</span>
                                            <span class="content">163</span>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-016-bubble"></i></span>
                                            <span class="title">تعداد نظرات</span>
                                            <span class="content">163</span>
                                        </li>
                                        <li class="item flex">
                                            <span class="icon"><i class="i-027-clock"></i></span>
                                            <span class="title">تاریخ انتشار</span>
                                            <span class="content">1396/12/30</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_edit2">
                                <div class="btn_part_style1 flex">
                                    <a href="#" class="btn_style7 flex">
                                        <div class="text z_index2">افزودن رنگ جدید</div>
                                        <div class="icon"><i class="i-049-add"></i></div>
                                    </a>
                                </div>
                                <div class="panel_table table_style2">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="t_pic">تصویر</th>
                                            <th class="t_name">نام محصول</th>
                                            <th class="t_date">رنگ</th>
                                            <th class="t_count">موجودی</th>
                                            <th class="t_edit">ویرایش</th>
                                            <th class="t_dlt">حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><img class="t_image" src="files/images/product/1.jpg" alt=""></td>
                                            <td>دسته بازی ایکس باکس 3000</td>
                                            <td><div class="color_style1 flex"><span class="title">قرمز</span><span class="color" style="background-color: #ff6452;"></span></div></td>
                                            <td>30</td>
                                            <td><a href="user-product-add.php"><i class="i-045-mark"></i></a></td>
                                            <td><a href="#"><i class="i-031-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td><img class="t_image" src="files/images/product/1.jpg" alt=""></td>
                                            <td>دسته بازی ایکس باکس 3000</td>
                                            <td><div class="color_style1 flex"><span class="title">قرمز</span><span class="color" style="background-color: #55a9ff;"></span></div></td>
                                            <td>30</td>
                                            <td><a href="user-product-add.php"><i class="i-045-mark"></i></a></td>
                                            <td><a href="#"><i class="i-031-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td><img class="t_image" src="files/images/product/1.jpg" alt=""></td>
                                            <td>دسته بازی ایکس باکس 3000</td>
                                            <td><div class="color_style1 flex"><span class="title">قرمز</span><span class="color" style="background-color: #ff9000;"></span></div></td>
                                            <td>30</td>
                                            <td><a href="user-product-add.php"><i class="i-045-mark"></i></a></td>
                                            <td><a href="#"><i class="i-031-trash"></i></a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!-- table_style2 -->
                            </div>
                        </div><!--clsoe .panel_content-->
                    </div>
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>

    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

        $(document).ready(function () {
            //Select color
            $('.color_select_style1').change(function(){
                var color = $('.color_select_style1 option:selected').attr('data-color');
                $('.color_select_style1 ~ .color').css('background-color',color);
            })

        });//document ready

    </script>

@endsection