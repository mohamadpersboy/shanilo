@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="user_panel">
                <div class="container">
                    <div class="inner">
                        <div class='panel_style1 other_page_section'>

                            @include('front.partial.dashboard')
                            <div class='panel_content'>
                                <div class="product_edit article_edit flex">
                                    <div class="form_style2">
                                       {!! Form::model($article,[
                                        'url'=>route('front.profile.article.update',$article),
                                        'method'=>'patch',
                                        'data-ajax',
                                        'data-type'=>'json',
                                        'data-on-success'=>'alert-message',
                                        'data-on-error'=>'alert-message',
                                       ]) !!}
                                           @include('front.pages.profile.article.form')
                                       {!! Form::close() !!}
                                    </div>
                                    <div class="product_info">
                                        <div class="title_style8"><span>اطلاعات مجله</span></div>
                                        <ul class="step no_bullet">
                                            <li class="item flex">
                                                <span class="icon"><i class="i-011-eye"></i></span>
                                                <span class="title">تعداد بازدید</span>
                                                <span class="content">{{$article->views}}</span>
                                            </li>
                                            <li class=" item flex">
                                                <span class="icon"><i class="i-027-clock"></i></span>
                                                <span class="title">تاریخ انتشار</span>
                                                <span class="content">{{ShowDate($article->created_at)}}</span>
                                            </li>
                                            <li class=" item flex">
                                                <span class="icon"><i class="i-003-color"></i></span>
                                                <span class="title">منبع</span>
                                                <span class="content">{{$article->source}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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