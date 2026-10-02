<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/calendar/skins/aqua/theme.css')}}">
<link rel='stylesheet' type='text/css' href="{{asset('assets/admin/_plugins/calendar/skins/calendar-blue.css')}}">
<script type="text/javascript" src="{{asset('assets/admin/_plugins/calendar/jalali.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/calendar/calendar.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/calendar/calendar-setup.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/calendar/calendar-fa.js')}}"></script>
<script>
    $(document).ready(function () {
        ////////////////////////////////////////////////////////////////////////////
        // Only Date
        function date_picker($element){
            Calendar.setup({
                inputField: $element,
                ifFormat: '%Y/%m/%d',
                dateType: 'jalali',
            });
            $("input#"+$element).keypress(function(e){
                e.preventDefault();
            });
        }
        $("[data-date-picker]").each(function() {
            var id = $(this).attr("id");
            date_picker(id);
        });
    })
</script>