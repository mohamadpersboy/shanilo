@extends('front.master')

@section('section')

    <section class="other_page">
        <div class="container">
            <div class="inner">
                <div class="contact_page">
                    <div class="contact_part1">
                        <div class="content_part flex">
                            <div class="title flex">تماس با ما</div>
                            <div class="content">
                                {{optional(optional($contact))->description}}
                            </div>
                        </div>
                        <div class="contact_info_part flex">
                            <div class="contact_info flex box_shadow_style1">
                                <div class="icon"><i class="i-017-mail"></i></div>
                                <div class="content">
                                    <ul class="step no_bullet flex">
                                        <li class="item">{{optional($contact)->email}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="contact_info flex left box_shadow_style1">
                                <div class="icon"><i class="i-phone-reciever"></i></div>
                                <div class="content">
                                    <ul class="step no_bullet flex">
                                        <li class="item">{{optional($contact)->phone}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact_part2">
                        <div class="title_style6"><span>فرم تماس با ما</span></div>
                        <div class="form_style1">
                            {!! Form::open([
                            'url'=>route('front.contact.store'),
                            'data-ajax',
                            'data-type'=>'json',
                            'data-on-success'=>'alert-message',
                            'data-on-error'=>'inline-message',
                            'data-clear'=>'true'
                            ]) !!}
                            <ul class="frm_step no_bullet">
                                <li class="frm_item w100 flex">
                                    <input class="frm_input" name="name" type="text">
                                    <div class="frm_title">نام و نام خانوادگی</div>
                                </li>
                                <li class="frm_item w100 flex">
                                    <input class="frm_input" name="email" type="text">
                                    <div class="frm_title">ایمیل</div>
                                </li>
                                <li class="frm_item w100 flex">
                                    <textarea class="frm_input frm_textarea" name="description"></textarea>
                                    <div class="frm_title">متن پیام شما</div>
                                </li>
                                <li class="frm_item w100 flex">
                                    <button class="frm_submit">ارسال پیام</button>
                                </li>
                            </ul>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="contact_part3">
                        <div class="address_part box_shadow_style1">{{optional($contact)->address}}</div>
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
