<div class="modal_style1 modal_style2 change_pic_profile w800">
    <div class="modal_scroll flex">
        <div class="close_bg"></div>
        <div class="wrapper">
            <div class="wrapper_box">
                <div class="close_btn"><i class="i-cancel"></i></div>
                <div class="title_style8"><span>آپلود عکس پروفایل</span></div>
                <div class="side_container">
                    {!! Form::open([
                        'url'=>route('front.user-page.upload-profile-image',$user),
                        'data-ajax',
                        'data-type'=>'json',
                        'data-on-success'=>'redirect',
                        'data-on-error'=>'alert-message'
                    ]) !!}
                    {!! Form::hidden('id',$user->id) !!}
                    {!! Form::hidden('_sid',bcrypt($user->id)) !!}
                        <input type='file' name='avatar' data-run-cropper='' data-x='1' data-y='1' data-element='#cropper2' onChange='preview(this,$(".change_pic_profile .cropper .cropper_holder"));'>
                        <div class='file_url'><span>عکس پروفایل خود را وارد کنید.</span></div>
                        <div class='cropper ltr' id='cropper2'>
                        <span class='small_img' onClick="$('input.select_pic_user').click();">
                            <span class='pic_inner cropper_preview'></span>
                        </span>
                            <div class='cropper_holder'></div>
                            <input data-crop-x type='hidden' name='cropper[x]' value=''>
                            <input data-crop-y type='hidden' name='cropper[y]' value=''>
                            <input data-crop-w type='hidden' name='cropper[w]' value=''>
                            <input data-crop-h type='hidden' name='cropper[h]' value=''>
                            <input type='hidden' name='old_image' value=''>
                        </div>
                        <button  title="" class="btn_style2 flex">
                            <span class="icon"><i class="i-044-checked"></i></span>
                            <span class="text">ثبت تغییر عکس</span>
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!--cropper-->
<link href='_plugins/cropper/cropper.min.css' rel='stylesheet' type='text/css'>
<script src='_plugins/cropper/cropper.min.js'></script>

<script>

    $(document).ready(function () {
        /////////////////////////////
        //modal style2
        $('.change_pic_profile_btn').click(function () {
            $('.modal_style2.change_pic_profile').fadeIn(300);
            $('body').css('overflow', 'hidden');
        });

    });//document ready
</script>