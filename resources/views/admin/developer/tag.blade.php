<!-- Tag Manager -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/forms/tags/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/_plugins/forms/tags/bootstrap-tokenfield.js')}}"></script>
<link type='text/css' rel='stylesheet' href="{{asset('assets/admin/_plugins/forms/tags/token.css')}}">

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {

            // Add class on init
            $('.tokenfield').on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal')
            });

            // Initialize plugin
            $('.tokenfield').tokenfield({
                autocomplete: {
                    @yield('tag_source')
                    delay: 100
                },
                @yield('tag_option')
                showAutocompleteOnFocus: true
            });

            // Add class when token is created
            $('.tokenfield').unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal')
                    }
                }
                $('input#tag_show-tokenfield').trigger('focus');
            });


            //More Token Field

            //#########################
            // Field 1
            //#########################

            // Add class on init
            $('.tokenfield2').on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal')
            });

            // Initialize plugin
            $('.tokenfield2').tokenfield({
                autocomplete: {
                    @yield('tag_source2')
                    delay: 100
                },
                @yield('tag_option2')
                showAutocompleteOnFocus: true
            });

            // Add class when token is created
            $('.tokenfield2').unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal')
                    }
                }
                $('input#tag_show2-tokenfield').trigger('focus');
            });

            //#########################
            // Field 2
            //#########################

            // Add class on init
            $('.tokenfield3').on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal')
            });

            // Initialize plugin
            $('.tokenfield3').tokenfield({
                autocomplete: {
                    @yield('tag_source3')
                    delay: 100
                },
                @yield('tag_option3')
                showAutocompleteOnFocus: true
            });

            // Add class when token is created
            $('.tokenfield3').unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal')
                    }
                }
                $('input#tag_show3-tokenfield').trigger('focus');
            });

            //#########################
            // Field 3
            //#########################

            // Add class on init
            $('.tokenfield4').on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal')
            });

            // Initialize plugin
            $('.tokenfield4').tokenfield({
                autocomplete: {
                    @yield('tag_source4')
                    delay: 100
                },
                @yield('tag_option4')
                showAutocompleteOnFocus: true
            });

            // Add class when token is created
            $('.tokenfield4').unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal')
                    }
                }
                $('input#tag_show4-tokenfield').trigger('focus');
            });


            // Add class on init
            $('.tokenfieldNoSource').on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal')
            });

            // Initialize plugin
            $('.tokenfieldNoSource').tokenfield({
                autocomplete: {
                    delay: 100,
                    source:[]
                },
                showAutocompleteOnFocus: true
            });

            // Add class when token is created
            $('.tokenfieldNoSource').unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal')
                    }
                }
                // $('input#tag_show').trigger('focus');
            });
        });
    })(jQuery)
</script>
<!-- End Tag Manager -->
