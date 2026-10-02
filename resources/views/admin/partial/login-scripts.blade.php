<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_css/fonts/ifont/styles.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_js/jquery-ui-effect.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/html5shiv.min.js')}}"></script>


<!--form validate-->
<script type="text/javascript" src="{{asset('assets/admin/_js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/additional-methods.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/all_form_validate.js?ver=0.7')}}"></script>

<!--ms_scroll-->
<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/ms_scroll/jquery.mCustomScrollbar.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_plugins/ms_scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<!--toast-->
<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/toast/jquery.toast.'.__('content.direction').'.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_plugins/toast/jquery.toast.min.js')}}"></script>

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


@yield('editor')
@yield('validate')

@yield('datatable')
@yield('sortable')
@yield('delete_selected')
@yield('tag_input')
@yield('select2')
@yield('switching')
@yield('pick_list')
@yield('js')

<!--scripts-->
<script type="text/javascript" src="{{asset('assets/admin/_js/functions.js?ver=0.2')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_js/master.js?ver=0.2')}}"></script>

<!--CSS OverWrite-->
<link href="{{asset('assets/admin/_css/over-write.rtl.css')}}" rel="stylesheet" type="text/css">
@if(__('content.direction') == "ltr")
    <link href="{{asset('assets/admin/_css/over-write.ltr.css')}}" rel="stylesheet" type="text/css">
@endif

@include('admin.developer.g_modal')