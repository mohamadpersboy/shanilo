{{-- Switchery iOS 7 style --}}
{{-- http://abpetkov.github.io/switchery/ --}}

{{-- Atlasweb AjaxSwitch v1.1.0 --}}
{{-- Milad Ghofrani --}}

<!-- Switchery -->
<link rel="stylesheet" href="{{asset('assets/admin/_plugins/switchery/switchery.min.css')}}" />
<script src="{{asset('assets/admin/_plugins/switchery/switchery.min.js')}}"></script>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $( document ).ajaxComplete(function() {
                $('input.switch_for_all').unbind().click(function() {/*.on('click', function() {*/
                    var id = $(this).data("id");
                    if($(this).is(':checked')){
                        switchy = 1;
                    } else {
                        switchy = 0;
                    }
                    var link = $(this).data('link');
                    var field = $(this).attr('name');
                    var model = $(this).data('model');
                    var database = $(this).data('database');
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData();
                    formData.append('switchy', switchy);
                    formData.append('field', field);
                    formData.append('model', model);
                    formData.append('database', database);
                    formData.append('_token', _token);
                    formData.append('_method', 'PATCH');
                    $.ajax({
                        url : link,
                        type : "post",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success : function(){
                            show_notif('','{{__('messages.edit_item')}}','s','tc',5000);
                        },
                        error: function() {
                            show_notif('','{{__('messages.unsuccessful_operation')}}','e','tc',15000);
                        }
                    });
                });
            });
        });
    })(jQuery)
</script>
<!-- End Switchery -->