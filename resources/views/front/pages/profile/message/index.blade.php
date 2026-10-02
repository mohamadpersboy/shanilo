@extends('front.master')
@section('section')
    <section class="other_page">
        <div class="user_panel">
            <div class="container">
                <div class="inner">
                    <div class='panel_style1 panel_message other_page_section'>
                        @include('front.partial.dashboard')
                        <div class='panel_content'>
                            <!-- <div class="user_follow flex">
                                <a href="javascript:void(0)" title="ارسال پیام" data-url="http://localhost/laravel/message/user/24/create" class="btn_style5 modal_btn orange send-ticket flex" style=" margin-top: 50px;cursor: pointer; opacity: 1;">
                                    <span class="icon" style="margin-left: 10px;"><i class="i-chat"></i></span>
                                    <span class="text">ارسال تیکت پشتیبانی</span>
                                </a>
                            </div> -->
                            <div class="panel__tickets">


                                <div class="title_style8"><span>لیست پیامهای شما</span></div>
                                <a href="javascript:void(0)" class="add_style1 flex send-ticket modal_btn"
                                   title="ارسال پیام" data-url="http://localhost/laravel/message/user/24/create">
                                    <i class="i-chat"></i>
                                    <span class="title">ارسال تیکت پشتیبانی</span>
                                </a>
                                <div class="filter_style1 mb30">
                                    <ul class="step no_bullet flex">
                                        <li class="item responsive_100">
                                            <div class="select_part">
                                                <select class="get-msg filter-msg frm_input" name="name">
                                                    <option data-url="{{ route('myMsg.show') }}">پیام های شخصی</option>
                                                    <option data-url="{{ route('shopMsg.show') }}">پیام های تجاری
                                                    </option>
                                                    <option data-url="{{ route('ticketMsg.show') }}">تیکت پشتیبانی
                                                    </option>
                                                </select>
                                            </div>
                                        </li>

                                        <li class="item responsive_100">
                                            <div class="select_part">
                                                <select class="get-status frm_input" name="msg_status">
                                                    <option value>انتخاب وضعیت پیام</option>
                                                    <option value="reply">دریافت شده</option>
                                                    <option value="send">ارسال شده</option>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="item responsive_100">
                                            <input class="profile-filter" name="msg_code"
                                                   placeholder="جستجو بر اساس شناسه پیام">
                                        </li>
                                        <!-- <li class="item responsive_100">
                                            <button class="condition_show red search">جستجو</button>
                                        </li> -->
                                    </ul>
                                </div>
                                <div class="panel_table show-html-table table_style2">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('front.partial.upload-img-profile')
    @include('front.plugins.message-modal')
@endsection

@section('js')
    <script>
        $(document).on('click','.item1',function(e){
            e.preventDefault()
            loadMsgTable($(this).find('a').html());
        })
        loadMsgTable();

        function loadMsgTable(pageNumber = 1) {
            url = $('.get-msg').find(':selected').attr('data-url');
            data = {
                msg_code: $('input[name=msg_code]').val(),
                msg_status: $('.get-status').find(':selected').val(),
                page:pageNumber
            }
            $.get(url, data, function (response) {
                if (parseInt(response.status) == 200) {
                    $('.show-html-table').html(response.html);
                }
            });
        }

        $(document).on('change', '.get-msg', function () {
            loadMsgTable();
        });
        $(document).on('change','.get-status',function(){
            loadMsgTable()
        })

        $(document).on('keyup', '.profile-filter', function () {
            loadMsgTable();
        });

        $(document.body).on("click", ".send-ticket", function (e) {
            e.preventDefault();
            modal = $(".message_modal").fadeIn(300);
            $.get("{{ route('sendTicketForm') }}").done(function (response) {
                $('.show-form-ticket').html(response.data)
            });

        });

        $(document).on('click', '.send-ticket-store', function () {
            var data = $(this).closest('form').serialize();
            $.post("{{ route('sendTicket') }}", data).done(function (response) {
                if (response.status == 200) {
                    $.toast({
                        heading: 'با موفقیت ثبت شد ',
                        text: 'تیکت شما با موفقیت ثبت شد ',
                        showHideTransition: 'fade',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 1,
                    });
                    modal = $(".message_modal").fadeOut(300);
                } else {
                    $.toast({
                        heading: 'خطای سمت سرور رخ داده',
                        text: 'لطفا با واحد پشتیبانی تماس حاصل فرمایید ',
                        showHideTransition: 'fade',
                        icon: 'error',
                        hideAfter: 2000,
                        stack: 1,
                    })
                }
            });


        });

    
    </script>
@endsection
