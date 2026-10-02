{{-- Select2 4.0.3 --}}
{{-- https://select2.github.io --}}

{{-- Released under the MIT license --}}
{{-- https://github.com/select2/select2/blob/master/LICENSE.md --}}

<!-- Select2 -->
<link type="text/css" rel="stylesheet" href="{{asset('assets/admin/_plugins/select2/select2.min.css')}}"/>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/select2/select2.full.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/select2/i18n/en.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/select2/i18n/fa.js')}}"></script>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $(".js-example-basic-single,select2").select2({
                'locale': '{{__('content.language')}}'
            });
            $(document.body).on('change','.select-auto-fill',function () {
                var parameter=$(this).val(),url=$(this).data('url')+'/'+parameter;
            });
        });
    })(jQuery)
</script>
<!-- End Select2 -->
