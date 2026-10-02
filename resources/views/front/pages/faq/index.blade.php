@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="faq_page">
                    <div class="title_style5"><span class="title">پرسش و پاسخ متداول</span></div>
                    <ul class="step no_bullet">
                        @foreach($faqs as $index=>$faq)
                            <li class="item {{$index==0?'active':''}}">
                                <div class="question flex">
                                    <span class="text  box_shadow_style1">{{$faq->title}}</span>
                                    <span class="icon_part">
                                    <span class="icon"><i class="i-download-arrow open"></i><i class="i-help close"></i></span>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 286 262" style="enable-background:new 0 0 286 262;" xml:space="preserve">
<path d="M266.3,0H143H19.7c-30.6,0-20.2,23.9-5.4,31.6c0.3,0.2,0.7,0.3,1,0.5c0,0,0,0,0.1,0l0.2,0.1c0.4,0.2,0.8,0.4,1.1,0.6l0.1,0
	l0,0C81.9,65.8,143,131.6,143,262c0-130.4,61.1-196.2,126.2-229.2l0,0l0.1,0c0.4-0.2,0.8-0.4,1.1-0.6l0.2-0.1c0,0,0,0,0.1,0
	c0.3-0.2,0.7-0.3,1-0.5C286.5,23.9,296.9,0,266.3,0z"/>
</svg>
                                </span>
                                </div>
                                <div class="answer" style="display: {{$index==0?'block':''}};">{{$faq->description}}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


    <script>

        $(document).ready(function () {
            // open answer
            $('.faq_page .item .question').click(function () {
                $(this).parent('.item').children('.answer').stop(true,false).slideDown(250);
                $(this).parent('.item').siblings('.item').children('.answer').stop(true,false).slideUp(250);
                $(this).parent('.item').addClass('active');
                $(this).parent('.item').siblings('.item').removeClass('active');
            });
        });//document ready

    </script>

@endsection