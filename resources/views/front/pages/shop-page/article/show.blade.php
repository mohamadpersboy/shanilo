@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_page">
            <div class="container">
                <div class="inner">
                    @include('front.partial.market-page-menu')
                    @include('front.partial.items.article-detail')
                </div><!-- .inner -->
            </div><!-- .container -->
        </div><!-- .user_page -->
    </section>


    @if(canEditShop($shop))
        @include('front.partial.upload-img-profile-shop')
        @include('front.partial.upload-img-shop')
    @endif
    @include('front.partial.shop-page-modals')

@endsection

@section('js')


    <script>

        $(document).ready(function () {


        });//document ready

    </script>

@endsection
