@extends('front.master')
@section('v1-front-style')
    <style>
        .container-chat {
            border: 2px solid #ccccff;
            color: #000000;
            background-color: #ccccff;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
        }

        .response-chat {
            border-color: #f3f3f3;
            background-color: #f3f3f3;
        }

        .container-chat::after {
            content: "";
            clear: both;
            display: table;
        }

        .left-comment {
            direction: ltr;
        }

        .right-comment {
            direction: rtl;
        }

        .container-chat img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .left-right-line {
            display: flex;
            justify-content: space-between;
        }


        input,
        textarea {
            font: 14px/1.4 sans-serif;
        }

        .input-group {
            display: table;
            border-collapse: collapse;
            width: 99%;
            margin: 5px;
        }

        .input-group > div {
            display: table-cell;
            border: 1px solid #ddd;
            vertical-align: middle;
            /* needed for Safari */
        }

        .input-group-icon {
            background: #eee;
            color: #777;
            padding: 0 12px
        }

        .input-group-area {
            width: 100%;
        }

        .input-group input {
            border: 0;
            display: block;
            width: 100%;
            padding: 8px;
        }

        .pointer {
            cursor: pointer;
        }

        .attachment-file:hover {
            color: #e29a00;
        }

        .send-msg-button:hover {
            color: blue
        }

        #message-text {
            border: 1px solid #ddd;
            min-height: 100px;
            padding: 10px;
        }

        .button-send-message {
            background-color: #4CAF50;
            /* Green */
            border: none;
            border-radius: 5px;
            color: white;
            padding: 10px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            margin-top: 5px;
        }

        div.scroll {
            margin: 4px;
            padding: 4px;
            height: 110px;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: justify;
        }
    </style>
@endsection
@section('section')

    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 other_page_section'>

                        @include('front.partial.dashboard')
                        <div class="panel_content">

                            <div class="single-ticket">
                                <div class="single-ticket__head">
                                    <a href="{{ route('front.profile.message.index') }}"
                                       class="single-ticket__head_btn-back">
                    <span class="material-icons">
                        arrow_forward
                    </span>
                                        <span>
                        بازگشت
                    </span>
                                    </a>
                                    <div class="single-ticket__head_content">
                                        <h3 class="single-ticket__head_content__title">{{$msg->subject}}</h3>
                                        <span>شناسه:{{$msg->id}}</span>
                                    </div>
                                </div>
                                @foreach($msg->details as $detail)
                                    <div class="single-ticket__items">
                                        <div class="single-ticket__item">
                                            <div class="single-ticket__item__head">
                                                <div class="single-ticket__item_img">
                                                    <a href="#">
                                                        <img src="{{ $detail->creator->takeImage('avatar','60/60','user.png') }}"
                                                             alt="">
                                                    </a>
                                                </div>
                                                <div class="single-ticket__item_title">
                                                    <h4>
                                                        <a href="{{ route('front.user-page.personal',$detail->creator->id) }}">
                                                            {{ $detail->creator->name.' '.$detail->creator->family }}
                                                        </a>
                                                    </h4>
                                                    <span>{{ \Morilog\Jalali\jDate::forge($detail->created_at)->format('H:i Y-m-d') }}</span>
                                                </div>
                                            </div>
                                            <div class="single-ticket__item__content">
                                                <p>{!! str_replace("\n","<br>",$detail->description) !!}</p>
                                                @if($detail->file != "")

                                                    <div>
                                                        <a href="{{ route('download').'?path='.$detail->file }}" class="single-ticket__item__content_btn">دریافت فایل</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="single-ticket__send">
                                    @if($msg->is_ticket)
                                        <div class="single-ticket__send_head">
                                            <h5>
                                                ارسال پاسخ
                                            </h5>
                                            <span>برای ارسال پاسخ به این تیکت از فرم زیر استفاده کنید.</span>
                                        </div>

                                        <div class="single-ticket__send_tip">
                                            <h5>لطفا به نکات زیر توجه کنید:</h5>
                                            <ul class="single-ticket__send_tip__items">
                                                <li>حداکثر تا 12 ساعت پس از ارسال تیکت، پاسخ آن برای شما ارسال خواهد
                                                    شد
                                                </li>
                                                <li>زمان پاسخ دهی به تیکت هایی که نیاز به بررسی یا پیگیری بیشتری دارند
                                                    طولانی
                                                    تر خواهد بود.
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    <form class="single-ticket__send_form" method="POST"
                                          action="{{ route('replyMsg.show',$msg->id) }}"
                                          enctype="multipart/form-data">
                                        <textarea name="description" id="" rows="5" placeholder="پیام شما"></textarea>
                                        {!! csrf_field() !!}
                                        <div class="single-ticket__send_form__grid">

                                            <div class="single-ticket__send_upload">
                                                <input type="file" name="upload"
                                                       class="single-ticket__send_upload_input">
                                            </div>

                                            <button class="single-ticket__send_btn">ارسال پاسخ</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
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
            $('.list.have_scroll_y').mCustomScrollbar('scrollTo', 'bottom', {
                scrollInertia: 0
            });
        }); //document ready
        $(document).on('click', '.send-msg-button', function () {
            $(this).closest('form').submit();
        });
        $(document).on('click', '.attachment-file', function () {
            $('#attachment-file-message').click();
        });
        $(document).on('keypress', '#message-text', function (e) {
            var elementKey = $(this);
            var valueMessage = elementKey.html();
            if (e.keyCode == 13) {
                valueMessage = elementKey.html() + '<br>';
            }
            $('#value-message').val(valueMessage);

        });
        $(document).on('change', '#attachment-file-message', function () {
            if (parseInt(($(this)[0].files[0].size / 1024) / 1024) > 5) {
                alert('فایل انتخابی نمیتواند بیشتر از 5 مگابایت باشد');
                $(this).val('');
            }
            var filename = $('input[type=file]').val().split('\\').pop();
            if (filename != '') {
                $('#file-name').val(filename);
            }
        });
    </script>

@endsection
