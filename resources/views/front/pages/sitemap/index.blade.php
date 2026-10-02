@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="site_map flex">
                    <div class="box">
                        <ul class="step no_bullet">
                            <li class="item"><a href="{{route('front.home.index')}}" title="" class="link">صفحه اصلی</a></li>
                            <li class="item"><a href="{{route('front.guide.index')}}" title="" class="link">راهنمای سایت</a></li>
                            <li class="item"><a href="{{route('front.about.index')}}" title="" class="link">درباره ما</a></li>
                            <li class="item"><a href="{{route('front.contact.index')}}" title="" class="link">تماس با ما</a></li>
                            <li class="item"><a href="{{route('front.faq.index')}}" title="" class="link">پرسش و پاسخ متداول</a></li>
                            <li class="item"><a href="{{route('front.policy.index')}}" title="" class="link">قوانین و سیاست ها</a></li>
                            <li class="item"><a href="{{route('front.sitemap.index')}}" title="" class="link">نقشه سایت</a></li>
                        </ul>
                    </div>
                    <div class="box">
                        <ul class="step no_bullet">
                            @foreach($productCategories as $index=>$firstLevelCategory)
                                <li class="item">
                                    <a href="{{$firstLevelCategory->path()}}" title="" class="link">{{$firstLevelCategory->title}}</a>
                                    @if($firstLevelCategory->children->count())
                                        <ul class="step2 no_bullet">
                                            @foreach($firstLevelCategory->children as $index=>$secondLevelCategory)
                                                <li class="item2">
                                                    <a href="{{$secondLevelCategory->path()}}" title="" class="link2">{{$secondLevelCategory->title}}</a>
                                                    @if($secondLevelCategory->children->count())
                                                    <ul class="step2 no_bullet">
                                                        @foreach($secondLevelCategory->children as $index=>$thirdLevelCategory)
                                                            <li class="item2"><a href="{{$thirdLevelCategory->path()}}" title="" class="link2">{{$thirdLevelCategory->title}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {

        });//document ready

    </script>

@endsection