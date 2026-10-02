@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="register_part1">
                    <div class="text_style1">{{mainSetting('registerPage')}}</div>
                    <div class="box_shadow_style1 mt30">
                        <div class="title_style7"><span>فرم ثبت نام</span></div>
                        <div class="unit_style1 mt30">
                            <ul class="step no_bullet flex">
                                <li class="item checked"><!-- has class = 'checked' 'active' -->
                                    <a href="#" title="" class="link">
                                        <div class="num">1.</div>
                                        <div class="title">ثبت اطلاعات</div>
                                    </a>
                                </li>
                                <li class="item checked">
                                    <a href="#" title="" class="link">
                                        <div class="num">2.</div>
                                        <div class="title">دریافت کد تایید</div>
                                    </a>
                                </li>
                                <li class="item active">
                                    <a href="#" title="" class="link">
                                        <div class="num">3.</div>
                                        <div class="title">انتخاب علاقه مندی</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="form_style2">
                            {!! Form::open([
                                'url'=>route('front.auth.register.set-favorites'),
                                'data-ajax',
                                'data-type'=>'json',
                                'data-on-success'=>'redirect',
                                'data-on-error'=>'alert-message',
                            ]) !!}
                                <ul class="frm_step flex no_bullet">
                                    @foreach($productCategories as $index=>$productCategory)
                                        <li class="frm_item flex not_empty">
                                            <div class="check_style1">
                                                <input type="checkbox" name="categories[]" value="{{$productCategory->id}}">
                                                <div class="check_icon"><i class="i-checked"></i></div>
                                                <div class="check_title flex">
                                                    <div class="icon"><i class="{{$productCategory->icon}}"></i></div>
                                                    <div class="text">{{$productCategory->title}}</div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="frm_item w100">
                                        <button class="btn_style2 flex">
                                            <span class="icon"><i class="i-007-arrow-2"></i></span>
                                            <span class="text">مرحله بعدی</span>
                                        </button>
                                    </li>
                                </ul>
                           {!! Form::close() !!}
                        </div>
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