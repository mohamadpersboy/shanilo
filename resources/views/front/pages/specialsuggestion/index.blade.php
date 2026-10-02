@extends('front.master')

@section('section')
    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div id="pjax-container" data-url="{{route('front.specialSuggestion.index')}}" class="market_archive">
                    <input type="hidden" id="plan" value="{{$selectedPlan}}">
                    <input type="hidden" id="limit" value="{{$limit}}">
                    <div class="title_style3 flex">
                        <div class="title_part flex">
                            <div class="title">پیشنهادات ویژه</div>
                            <div class="tag_part z_index2">
                                <ul class="step no_bullet flex ">
                                    <li class="item {{!$selectedPlan?'mixitup-control-active':''}}">
                                        <a href="{{route('front.specialSuggestion.index')}}" class="pjax-link" data-no-query="true">
                                            <span class="tag">همه</span>
                                            <span class="icon"></span>
                                        </a>
                                    </li>
                                    @foreach($plans as $index=>$plan)
                                        <li class="item {{$selectedPlan==$plan->id?'mixitup-control-active':''}}">
                                            <a href="{{route('front.specialSuggestion.index',['plan'=>$plan->id])}}" class="pjax-link" data-no-query="true">
                                                <span class="tag">{{$plan->title}}</span>
                                                <span class="icon"></span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <a href="javascript:void(0)" title="" rel="nofollow" class="btn_part disabled"><i
                                    class="i-link"></i></a>
                    </div>
                    <div class="box_style2">
                        {{--<div class="loading_style1"></div>--}}
                        @if($specialSuggestions->count())
                            <ul class="step no_bullet flex">
                                @foreach($specialSuggestions as $index=>$specialSuggestion)
                                    @include('front.partial.items.product',['productDetail'=>$specialSuggestion->productDetail])
                                @endforeach
                                <li class="gap"></li>
                                <li class="gap"></li>
                                <li class="gap"></li>
                            </ul>
                            @if($hasMorePage)
                                <a data-url="{{route('front.specialSuggestion.index')}}"
                                   href="javascript:void(0)"
                                   class="see_more_style1 btn-load-more-pjax type2">
                                    <span>مشاهده بیشتر</span>
                                </a>
                            @endif
                        @else
                            <div class="noItem_style2 flex">موردی یافت نشد!</div>
                        @endif

                    </div><!-- .box_style2 -->
                </div>
            </div>
        </div>
    </section>

@endsection
