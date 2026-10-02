{{-- Cropper v2.2.5 --}}
{{-- https://github.com/fengyuanchen/cropper --}}

<!-- Cropper -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/cropper/cropper.min.js')}}"></script>
<link type='text/css' rel='stylesheet' href="{{asset('assets/admin/_plugins/cropper/cropper.min.css')}}">
<script type="text/javascript">
    //cropper
    $(document).ready(function () {
        $('[data-run-cropper]').change(function(){
            var x = $(this).attr('data-x');
            var y = $(this).attr('data-y');
            var element = $(this).attr('data-element');

            $(element).find('.cropper_preview').css('background-image','none');
            $(element).find('.rmv_file').show();
            $(element).find('.rmv_file').attr('data-table','');

            setTimeout(function(){run_cropper(element,x,y);},500);
        });
    });
</script>
<!-- End Cropper -->
