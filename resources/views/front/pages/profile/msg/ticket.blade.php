<div class="comment_style1">
    <div class="form_style1">
        <form action="{{ route('sendTicket') }}" method="post">
            <ul class="frm_step no_bullet">
                <li class="frm_item w100 flex">
                    <input class="frm_input" name="subject" placeholder="موضوع پیام">
                </li>
                <li class="frm_item w100 flex">
                    <textarea class="frm_input msg-description frm_textarea" name="description" data-valid-required=""
                              aria-required="true"
                              placeholder="متن پیام شما"></textarea>
                    <div class="frm_title">پیام شما خود را ثبت کنید</div>
                </li>
                <li class="frm_item w100 flex">
                    <div class="single-ticket__send_form__grid">

                        <div class="single-ticket__send_upload"
                             onclick="document.getElementById('attachment-file-message').click();">
                            <button class="single-ticket__send_upload_btn" type="button">انتخاب فایل</button>
                            <input type="text" id="file-name" class="single-ticket__send_upload_input"
                                   value="فایلی انتخاب نشده" readonly="">
                        </div>
                        <input type="file" onchange="ticketFileName()" id="attachment-file-message" name="upload"
                               style="display: none; ">

                    </div>
                </li>
                <li class="frm_item w100 flex rate_item">
                    <button type="button" class="frm_submit send-ticket-store" style="background-color:#B521CF">ثبت پیام</button>
                </li>
            </ul>
        </form>
    </div>
</div>
