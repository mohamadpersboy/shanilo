<script type="text/javascript">
    (function () {
        $(document).ready(function () {
            var loader = "<div class='myLoader'><img src='{{asset('assets/front/_images/loading/loader3.gif')}}' alt='loading'></div>";

            var country = $(".country_selector");
            var state = $(".state_selector");
            var city = $(".city_selector");
//
//            var country = $("[name='country_id']");
//            var state = $("[name='state_id']");
//            var city = $("[name='city_id']");


            // Load States
            $(country).change(function () {
                var thisElement = $(this);
                state.html(loader);
                var data_send = {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'country_id': country.val()
                };
                $.post("{{route('front.ajax.state')}}", data_send, function (response) {
                    // Success
                    if (response == 'is_null') {
                        state.html('');
                        state.append("<option >ابتدا کشور را انتخاب کنید.</option>");
                        $(state).niceSelect('update');
                        city.html('');
                        city.append("<option >ابتدا استان را انتخاب کنید.</option>");
                        $(city).niceSelect('update');
                    } else {
                        state.html('');
                        var all_states = JSON.parse(response);

                        if (typeof (all_states) != null) {
                            $.each(all_states, function (ind, val) {
                                state.append("<option value='" + val.id + "'>" + val.name + "</option>");
                                $(state).niceSelect('update');
                            });
                        }
                    }
                });
            });


            // Load Cities
            $(state).change(function () {
                var thisElement = $(this);
                city.html(loader);
                var data_send = {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'state_id': state.val()
                };
                $.post("{{route('front.ajax.city')}}", data_send, function (response) {
                    // Success
                    if (response == 'is_null') {
                        city.html('');
                        city.append("<option >ابتدان استان را انتخاب کنید</option>");
                        $(city).niceSelect('update');
                    } else {
                        city.html('');
                        var all_cities = JSON.parse(response);
                        if (typeof (all_cities) != null) {
                            $.each(all_cities, function (ind, val) {
                                city.append("<option value='" + val.id + "'>" + val.name + "</option>");
                                $(city).niceSelect('update');
                            });
                        }
                    }
                });
            });
        })
        ;
    })(jQuery);
</script>
