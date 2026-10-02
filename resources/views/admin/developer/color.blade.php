{{-- Color --}}
{{-- https://github.com/PitPik/tinyColorPicker --}}

<!-- Color -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/color_picker/jqColorPicker.min.js')}}"></script>
<script>
    $(document).ready(function(){
        if($("[data-color-picker]").length !=0){
            $("[data-color-picker]").colorPicker();
        }
    });
</script>
<!-- End Color -->
