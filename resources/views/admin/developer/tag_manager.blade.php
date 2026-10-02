<!-- Tag Manager -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/forms/tags/tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/ui/prism.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/forms/inputs/typeahead/typeahead.bundle.min.js')}}"></script>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {

            // Add class on init
            $('.tokenfield').on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal')
            });

            // Initialize plugin
            $('.tokenfield').tokenfield();

            // Add class when token is created
            $('.tokenfield').on('tokenfield:createdtoken', function (e) {
                $(e.relatedTarget).addClass('bg-teal')
            });
        });
    })(jQuery)
</script>
<!-- End Tag Manager -->
