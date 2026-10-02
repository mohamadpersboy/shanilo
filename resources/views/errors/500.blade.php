@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="page_500 box_shadow_style1">
                    <span class="image"></span>
                    <h3 class="text-1">خطای سمت سرور رخ داده</h3>
                    <a href="{{route('front.home.index')}}"  class="btn_style2   flex z_index4">
                        <span class="text">برگشت به صفحه اصلی</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
