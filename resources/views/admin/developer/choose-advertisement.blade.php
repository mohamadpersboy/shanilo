<script type="text/javascript">
    $(document).ready(function () {
        $('[data-change-plan]').change(function(){
            var plan_id = $(this).val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('id', plan_id);
            formData.append('_token', _token);
            $.ajax({
                url : "{{route('admin.advertisement.choosePlan')}}",
                type : "post",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('[data-change-time]').find('option').remove().end().append($('<option>', {
                        value: "",
                        text: " لطفا منتظر بمانید ... "
                    }));
                    // $('[data-change-time]').trigger("chosen:updated");
                    // $('[data-change-time]').niceSelect('update');
                },
                success : function(data) {
                    $('[data-change-time]').find('option').remove().end().append($('<option>', {
                        value: "",
                        text: "انتخاب زمان"
                    }));
                    if (data.addetails != null){
                        data.addetails.forEach(function (addetail) {
                            $('[data-change-time]').append($('<option>', {
                                value: addetail['adtime']['id'],
                                text: addetail['adtime']['title']
                            }));
                        });
                    }
                    // $('[data-change-time]').trigger("chosen:updated");
                    // $('[data-change-time]').niceSelect('update');

                    $('[data-show-price]').val("");
                    $('[data-show-discount]').val("");
                    $('[data-show-price-discount]').val("");
                },
                error: function() {
                    //
                }
            });

            $('[data-change-time]').change(function(){
                var time_id = $(this).val();
                var _token = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData();
                formData.append('plan_id', plan_id);
                formData.append('time_id', time_id);
                formData.append('_token', _token);
                $.ajax({
                    url : "{{route('admin.advertisement.chooseTime')}}",
                    type : "post",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        
                    },
                    success : function(data) {
                        $('[data-show-price]').val(number_format(data.addetail['price']));
                        $('[data-show-discount]').val(data.addetail['discount']);
                        $('[data-show-price-discount]').val(number_format(data.addetail['price_discount']));
                    },
                    error: function() {
                        //
                    }
                });
            });

        });
    })
</script>