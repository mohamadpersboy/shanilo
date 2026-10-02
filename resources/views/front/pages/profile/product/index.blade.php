@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
                <div class="container">
                    <div class="inner">
                        <div class='panel_style1 other_page_section'>
                            @include('front.partial.dashboard')
                            <div id="pjax-container" data-url="{{route('front.profile.product.index',['page'=>1])}}" class='panel_content'>
                                <div class="title_style8"><span>لیست محصولات اضافه شده</span></div>
                                <a href="{{route('front.profile.product.create')}}" class="add_style1 flex"><i class="i-049-add"></i><span class="title">افزودن محصول جدید</span></a>
                                <div class="filter_style1 mb30">
                                    <ul class="step no_bullet flex">
                                        <li class="item">
                                            <div class="select_part">
                                                <select name="shop_id" class="profile-filter" data-group="shop_id" id="">
                                                    <option value="">فروشگاه ها</option>
                                                    @foreach($shops as $index=>$shop)
                                                        <option {{$shop->id==$selectedShopId?'selected':''}} value="{{$shop->id}}">{{$shop->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <div class="select_part">
                                                <select name="in_stock" class="profile-filter" data-group="in_stock" id="">
                                                    <option value="">همه کالاها</option>
                                                    <option {{$selectedInStock=="yes"?'selected':''}} value="yes">کالاهای موجود</option>
                                                    <option {{$selectedInStock=="no"?'selected':''}} value="no">کالاهای ناموجود</option>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="item responsive_100">
                                            <input type="text" value="{{$selectedTitle}}" class="profile-filter" data-group="title" placeholder="جستجو بر اساس نام">
                                        </li>
                                    </ul>
                                </div>
                                @if($products->count())
                                <div class="panel_table table_style2">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="w10">تصویر</th>
                                                <th class="w40">نام محصول</th>
                                                <th class="w10">تاریخ انتشار</th>
                                                <th class="w10">تعداد فروخته شده</th>
                                                <th class="w10">وضعیت</th>
                                                <th class="w5">ویرایش</th>
                                                <th class="w5">حذف</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $index=>$product)
                                            <tr id="product-{{$product->id}}">
                                                <td><img class="t_image" src="{{$product->takeImage('main','100/50')}}" alt=""></td>
                                                <td>{{$product->title}}</td>
                                                <td>{{ShowDate($product->created_at)}}</td>
                                                <td>{{$product->sell_count}}</td>
                                                <td><div class="condition_show {{$product->display?'green':'orange'}}">{{$product->display?'تایید شده':'در انتظار تایید'}}</div></td>
                                                <td><a href="{{route('front.profile.product.edit',$product)}}"><i class="i-045-mark"></i></a></td>
                                                <td id="bock-product-{{$product->id}}">
                                                    <a style="cursor:pointer;" data-block="#block-product-{{$product->id}}" class="btn-delete" data-url="{{route('front.profile.product.destroy',$product)}}">
                                                        <i class="i-031-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- table_style2 -->
                                <div class="pagination_style2">
                                   {{$products->render('vendor.pagination.dashboard')}}
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

    @include('front.partial.upload-img-profile')

@endsection

@section('js')


    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection
