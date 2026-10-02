<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_css/fonts/ifont/styles.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_js/jquery-ui-effect.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/html5shiv.min.js')}}"></script>

<!--form validate-->
<script type="text/javascript" src="{{asset('assets/admin/_js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/additional-methods.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/all_form_validate.js?ver=0.7')}}"></script>

<!--ms_scroll-->
<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/ms_scroll/jquery.mCustomScrollbar.css')}}">
<script type="text/javascript"
        src="{{asset('assets/admin/_plugins/ms_scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<!--toast-->
<link rel='stylesheet' type='text/css'
      href="{{asset('assets/admin/_plugins/toast/jquery.toast.'.__('content.direction').'.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_plugins/toast/jquery.toast.min.js')}}"></script>

<!--izi toast-->
<link href='{{asset('assets/admin/_plugins/izitoast/css/iziToast.css')}}' rel='stylesheet' type='text/css'>
<script src='{{asset('assets/admin/_plugins/izitoast/js/iziToast.min.js')}}'></script>

<!--ajax form-->
<script type="text/javascript" src="{{asset('assets/admin/_js/jQuery.form.js')}}"></script>

<!--ellipsis-->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/ellipsis/jquery.dotdotdot.min.js')}}"></script>

<!--lazy image-->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/lazy_img/jquery.lazy.min.js')}}"></script>

<!--autosize-->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/autosize/jquery.autosize.min.js')}}"></script>

<!--remain_chars-->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/remain_chars/remain_chars.js')}}"></script>

<!--cookie-->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/cookie/jquery.cookie.js')}}"></script>

<!--select_box-->
<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/select_box/chosen.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_plugins/select_box/chosen.jquery.min.js')}}"></script>

<!--multiselect_check-->
<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/multiselect_check/multiselect.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_plugins/multiselect_check/multiselect.js')}}"></script>

<!--jQuery Mask Plugin-->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/mask/jquery.mask.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/_js/sweetalert.min.js') }}"></script>


@yield('delete_selected')
@yield('tag_input')
@yield('tag')
@yield('sortable')
@yield('select2')
@yield('switching')
@yield('pick_list')
@yield('editor')
@yield('cropper')
@yield('fine_uploader')
@yield('jw_player')
@yield('datatable')
@yield('UploadFive')
@yield('PriceDiscount')
@yield('Color')
@yield('datePicker')
@yield('js')

<!--scripts-->
<script type="text/javascript" src="{{asset('assets/admin/_js/functions.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/master.js')}}"></script>

<!--CSS OverWrite-->
<link href="{{asset('assets/admin/_css/over-write.rtl.css')}}" rel="stylesheet" type="text/css">
@if(__('content.direction') == "ltr")
    <link href="{{asset('assets/admin/_css/over-write.ltr.css')}}" rel="stylesheet" type="text/css">
@endif

@yield('css_after')

<!-- Push Notification -->

<script type="text/javascript">
  $('[data-mv]').mask('000.000.000.000.000', {reverse: true});
  $('[data-mvwc]').mask('000,000,000,000,000', {reverse: true});

  $(document).ready(function () {

      @if(Session::has('msg'))
      show_notif('', '{{session('msg')}}', 's', 'tc', 10000);
      @endif

      @if(Session::has('err'))
      show_notif('', '{{session('err')}}', 'e', 'tc', 15000);
      @endif

      @isset($errors)
      @if (count($errors) > 0 && !$errors->has('visited'))
      @foreach ($errors->all() as $error)
      show_notif('', '{{$error}}', 'e', 'tl', 15000);
      @endforeach
      @endif
      @endisset
  });
</script>
<!-- End Push Notification -->

@include('admin.developer.g_modal')
