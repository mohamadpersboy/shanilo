@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="timeline_part">
                    @include('front.partial.parts.timeline-header')
                    <div class="box_style7">
                        @if($articles->count())
                            <ul id="article-container" class="step no_bullet flex">
                                @include('front.partial.items.articles')
                                <li class="gap before-list"></li>
                                <li class="gap"></li>
                                <li class="gap"></li>
                            </ul>
                            @if(hasMorePage($articles))
                                <a data-url="{{route('front.timeline.'.kabab_case($activeMenu))}}"
                                   data-parent="#article-container"
                                   data-item=".before-list"
                                   data-page="1" href="javascript:void(0)"
                                   class="see_more_style1 btn-load-more type2">
                                    <span>مشاهده بیشتر</span>
                                </a>
                            @endif
                        @else
                            <div class="noItem_style2 flex">موردی اضافه نشده!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {
            // filter_style2 click
            $('.filter_style2 .category_btn').click(function(){
                $('.filter_style2 .category_sub').fadeToggle(200);
            })

            $("body").click(function (e) {
                if (!$(e.target).is(".filter_style2 .category_select") && !$(e.target).is(".filter_style2 .category_select *")) {
                    $('.filter_style2 .category_sub').fadeOut(200);
                }
            });//body click

        });//document ready

    </script>

@endsection