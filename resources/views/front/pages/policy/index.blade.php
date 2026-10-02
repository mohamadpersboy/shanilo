@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="policy_page box_shadow_style1">
                    <div class="title_style7"><span>قوانین و سیاست ها</span></div>
                    <article class="content_style1">
                        @php
                            $classes=[1,2];
                            $class=1;
                        @endphp
                        @foreach($policies as $index=>$policy)
                            <h3 class="title{{$classes[$class]}}">{{$policy->title}}</h3>
                            <div>
                                {!! $policy->description !!}
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