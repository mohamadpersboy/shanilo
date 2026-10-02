{{-- Atlasweb AjaxDelete v1.1.0 --}}
{{-- Milad Ghofrani --}}

<!-- Ajax Delete -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.delete_from_list').on('click', function(e) {
            e.preventDefault();
            var array = [];
            $('.data_table tbody').find('.checkradio_style1 input[type="checkbox"]:checked').each(function () {
                var row = $(this);
                array.push(row.val());
            });
            if(array.length != 0){
                $('.delete_all_modal').modal('show');
                var colspan = $(this).data("colspan");
                var link = $(this).attr("href");
                $('.delete_all_modal').data({'link':link,'colspan':colspan,'array':array}).modal('show');
            } else {
                show_notif('','{{__('messages.choose_at_least_one_item')}}','w','tc',5000);
            }
        });

        $('#btn_yes').click(function (e) {
            e.preventDefault();
            var colspan = $('.delete_all_modal').data('colspan');
            var link = $('.delete_all_modal').data('link');
            var array = $('.delete_all_modal').data('array');
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url : link,
                type : "post",
                data : {_token:_token,_method: 'DELETE',ids:array},
                success : function(data){
                    $('.data_table tbody').find('.checkradio_style1 input[type="checkbox"]:checked').each(function () {
                        var row = $(this);
                        row.parents('tr').fadeOut(500, function () {
                            $(this).remove();
                        });
                        $('.delete_all_modal').modal('hide');
                        show_notif('','{{__('messages.delete_item')}}','s','tc',5000);
                    });
                    setTimeout(function () {
                        if ($('.data_table tbody').children().length <= 0) {
                            if($('a#data_table_next').hasClass('disabled')){
                                $('a#data_table_previous').trigger('click');
                                $('a#data_table_next').trigger('click');
                            } else {
                                $('a#data_table_next').trigger('click');
                                $('a#data_table_previous').trigger('click');
                            }
                        } else {
                            $('th.td_padding_zero').trigger('click');
                            $('th.td_padding_zero').trigger('click');
                        }
                    }, 500);
                },
                error: function() {
                    $('.delete_all_modal').modal('hide');
                    show_notif('','{{__('messages.unsuccessful_operation')}}','e','tc',15000);
                }
            });
        });
    });
</script>

<div class="modal fade delete_all_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">{{__('messages.delete_modal')}}</h4>
            </div>
            <div class="modal-body">{{__('messages.delete_modal_content')}}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.delete_modal_cancel')}}</button>
                <button type="button" id="btn_yes" class="btn btn-danger">{{__('messages.delete_modal_accept')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Ajax Delete -->