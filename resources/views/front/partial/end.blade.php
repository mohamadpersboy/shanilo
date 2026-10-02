
<!--all script in site-->
<script src='_js/jquery-ui-effect.min.js'></script>
<script src='_js/html5shiv.min.js'></script>

<!--form validate-->
<script src='_js/jquery.validate.min.js'></script>
<script src='_js/additional-methods.min.js'></script>
<script src='_js/all_form_validate.js'></script>


<!--toast-->
<link href='_plugins/toast/jquery.toast.css' rel='stylesheet' type='text/css'>
<script src='_plugins/toast/jquery.toast.min.js'></script>

<!--ajax form-->
<script src='_js/jQuery.form.js'></script>

<!--ellipsis-->
<script src='_plugins/ellipsis/jquery.dotdotdot.min.js'></script>

<!--autosize-->
<script src='_plugins/autosize/jquery.autosize.min.js'></script>

<!--scripts-->
<script src='_js/functions.js?ver=0.1'></script>
<script src='_js/master.js?ver=0.1'></script>


<!--all script in this page-->

<!--ms_scroll-->
<link rel='stylesheet' type='text/css' href='_plugins/ms_scroll/jquery.mCustomScrollbar.css'>
<script src='_plugins/ms_scroll/jquery.mCustomScrollbar.concat.min.js'></script>

<!-- mix it up -->
<script src="_plugins/mixitup/dist/mixitup.min.js"></script>

<!--fancy box-->
<link rel="stylesheet" type="text/css" href="_plugins/fancyapps/source/jquery.fancybox.css" media="screen">
<script src="_plugins/fancyapps/source/jquery.fancybox.pack.js"></script>

<!-- slick slider -->
<link rel="stylesheet" type="text/css" href="_plugins/slick_slider/slick/slick.css">
<script src="_plugins/slick_slider/slick/slick.js" type="text/javascript" charset="utf-8"></script>

<!-- swaper slider -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="_js/jquery.blockUI.js"></script>
<script src="_js/sweetalert.min.js"></script>
<script src="_js/toastr.min.js"></script>
<script src="_js/jquery.pjax.js"></script>
<script src="_js/Atlasweb.js"></script>
<script src="_js/atlasweb.ctrl.js"></script>
<script src="_js/newjs.js"></script>

@if(Session::get('notification'))
    <?php
    $notification = Session::get('notification');
    ?>
    <script>
        $(function () {
            toastr.options=(new Atlasweb()).setToastrOptions();
            toastr['{{$notification['type']}}']('{{$notification['message']}}','{{$notification['header']}}');
        });
    </script>
    <?php
    Session::forget('notification');
    ?>
@endif
@if($errors->any())
    <script>
        $(function () {
            toastr.options=(new Atlasweb()).setToastrOptions();
            @foreach($errors->all() as $error)
            toastr['error']('{{$error}}');
            @endforeach
        });
    </script>
@endif




