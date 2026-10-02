@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="policy_page box_shadow_style1">
                    <div class="title_style7"><span>درباره ما</span></div>
                    <article class="content_style1">
                        <h3 class="title2">{{$about->title}}</h3>
                        <div>
                            {!! $about->description !!}
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

@endsection
