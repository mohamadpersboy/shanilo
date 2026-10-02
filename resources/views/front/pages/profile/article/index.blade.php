@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')
                        <div id="pjax-container" data-url="{{route('front.profile.article.index',['page'=>1])}}" class='panel_content'>
                            <div class="title_style8"><span>لیست مجلات من</span></div>
                            <a href="{{route('front.profile.article.create')}}" class="add_style1 flex"><i
                                        class="i-003-color"></i><span class="title">افزودن مجله جدید</span></a>
                            <div class="filter_style1 mb30">
                                <ul class="step no_bullet flex">
                                    <li class="item responsive_100">
                                        <div class="select_part">
                                            <select name="shop_id" class="profile-filter" data-group="shop_id" id="">
                                                <option value="">فروشگاه ها</option>
                                                @foreach($shops as $index=>$shop)
                                                    <option {{$shop->id==$selectedShopId?'selected':''}} value="{{$shop->id}}">{{$shop->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @if($articles->count())
                                <div id="table-block" class="panel_table table_style2">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="w5">تصویر</th>
                                            <th class="w40">عنوان مجله</th>
                                            <th class="w10">تاریخ انتشار</th>
                                            <th class="w5">مشاهده</th>
                                            <th class="w5">ویرایش</th>
                                            <th class="w5">حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($articles as $index=>$article)
                                            <tr id="article-{{$article->id}}">
                                                <td><img class="t_image" src="{{$article->takeImage('main','100/60')}}" alt=""></td>
                                                <td>{{$article->title}}</td>
                                                <td>{{ShowDate($article->created_at)}}</td>
                                                <td><a href="{{$article->path()}}" target="_blank"><i class="i-020-arrow"></i></a></td>
                                                <td><a href="{{route('front.profile.article.edit',$article)}}"><i class="i-045-mark"></i></a></td>
                                                <td><a class="cursor-pointer btn-delete" data-url="{{route('front.profile.article.destroy',$article)}}" data-block="#table-block" ><i class="i-031-trash"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- table_style2 -->
                                <div class="pagination_style2">
                                  {{$articles->render('vendor.pagination.dashboard')}}
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