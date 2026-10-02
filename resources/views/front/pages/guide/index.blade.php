@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="policy_page box_shadow_style1">
                    <div class="title_style7"><span>راهنمای سایت</span></div>
                    <article class="content_style1">
                        @php
                            $classes=[1,2];
                            $class=1;
                        @endphp
                        @foreach($guides as $index=>$guide)
                            <h3 class="title{{$classes[$class]}}">{{$guide->title}}</h3>
                            <div>
                                {!! $guide->description !!}
                            </div>
                            @php
                                $class=!$class;
                            @endphp
                        @endforeach
                    </article>
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