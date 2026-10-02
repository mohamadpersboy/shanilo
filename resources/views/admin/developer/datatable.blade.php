{{-- laravel-datatables --}}
{{-- https://datatables.net/ --}}
{{-- https://yajrabox.com/docs/laravel-datatables/master --}}

<!-- DataTable -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('div#data_table_filter').remove();
    });
    var _token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#data_table').DataTable({
        "processing": true,
        "serverSide": true,
        "aLengthMenu": [[10,25, 50, 75,100,150,200,500, -1], [10,25, 50, 75,100,150,200,500, "All"]],
        @yield('datatable_options')
        "ajax":{
            @yield('datatable_url')
            @if (trim($__env->yieldContent('datatable_url')))
                data : {_token : _token},
            @endif
            @yield('datatable_url_data')
            type: "post",
            beforeSend: function(){
                show_modal('loadingDataTable');
                $('a.refresh_table').removeClass('show-inline');
                $('a.refresh_table').addClass('hide');
                $('a.data_table_load').removeClass('hide');
                $('a.data_table_load').addClass('show-inline');
            },
            complete: function(){
                hide_modal();
                $('a.refresh_table').removeClass('hide');
                $('a.refresh_table').addClass('show-inline');
                $('a.data_table_load').removeClass('show-inline');
                $('a.data_table_load').addClass('hide');
                $.each($('a.has-tr'),function () {
                   var $class=$(this).data('parent-class');
                   $(this).closest('tr').addClass($class);
                });
            }
        },
        @yield('datatable_source')
        "language": {
            "url": "{{asset('assets/admin/_plugins/datatable/lang/'.__('content.language').'.json')}}"
        },
        "drawCallback": function() {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                var switchery = new Switchery(html, { color: '#32c1d2', size  : 'small'});
            });
            $('span.switchery').append('<i class="icon"></i>');
            $('.sortable_table tbody').attr({
                'data-entityname': $('.sortable_table tbody tr td div.sort_container').data('model'),
                'data-database': $('.sortable_table tbody tr td div.sort_container').data('database')
            });
        }
    });
    $('.refresh_table').unbind().click(function(){
        $('a.refresh_table').removeClass('show-inline');
        $('a.refresh_table').addClass('hide');
        $('a.data_table_load').removeClass('hide');
        $('a.data_table_load').addClass('show-inline');
        table.ajax.reload(function(){
            $('a.refresh_table').removeClass('hide');
            $('a.refresh_table').addClass('show-inline');
            $('a.data_table_load').removeClass('show-inline');
            $('a.data_table_load').addClass('hide');
        });
    });

    // For search section
    $(document).ready(function(){
        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        $('.select_style select:has(option[data-change-bgcolor])').change(function(){
            var $this = $(this);
            var option_color = $this.find("option:selected[data-change-bgcolor]").attr("data-change-bgcolor");
            var option_text = $this.find("option:selected[data-change-bgcolor]").text();
            if(option_color != ""){
                $this.closest('form').trigger('submit');
                $this.closest(".select_style").css("background-color",option_color);
                $(".select_style .select_label").text(option_text);
            }
        });
        $('#frm_page_status').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

    });
    function clear_search(){
        document.getElementById("search-form").reset();
        $("span.select2-selection__rendered").each(function() {
            $(this).text($(this).closest('.select2-container').siblings('select').data('placeholder'));
        });
        $('.search_button').trigger('click');
    }
</script>
<!-- End DataTable -->
