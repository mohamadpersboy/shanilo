{{-- laravel-sortable --}}
{{-- https://jqueryui.com/ --}}
{{-- https://github.com/boxfrommars/rutorika-sortable --}}

<!-- Sortable -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/sortable/jquery-ui.js')}}"></script>
<script type="text/javascript">
    var changePosition = function(requestData){
        $.ajax({
            'url': "{{route('admin.sort.update')}}",
            'type': 'POST',
            'data': requestData,
            'success': function(data) {
                show_notif('','{{__('messages.edit_item')}}','s','tc',5000);
            },
            'error': function(){
                show_notif('','{{__('messages.unsuccessful_operation')}}','e','tc',15000);
            }
        });
    };

    var _token = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
        var $sortableTable = $('.sortable_table tbody');
        if ($sortableTable.length > 0) {
            $sortableTable.sortable({
                handle: '.ui-sortable-handle',
                axis: 'y',
//                tolerance: "pointer",
//                revert: true,
//                cursorAt: { cursor: "move", top: 10, left: 275 },
//                sort: function(){
//                    var offset = $(this).offset();
//                    var xPos = offset.left;
//                    var yPos = offset.top;
//                    $('p.title2').text('top' + yPos);
//
//                    $('#posY').text('y: ' + yPos);
//                },
                helper: function(e, tr){
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index){
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                },
                update: function(a, b){

                    var entityName = $(this).data('entityname');
                    var database = $(this).data('database');
                    var $sorted = b.item;
                    var $previous = $sorted.prev();
                    var $next = $sorted.next();

                    if ($previous.length > 0) {
                        changePosition({
                            _token: _token,
                            _method: 'PATCH',
                            parentId: $sorted.data('parentid'),
                            type: 'moveAfter',
                            entityName: entityName,
                            database: database,
                            id: $sorted.data('itemid'),
                            positionEntityId: $previous.data('itemid')
                        });
                    } else if ($next.length > 0) {
                        changePosition({
                            _token: _token,
                            _method: 'PATCH',
                            parentId: $sorted.data('parentid'),
                            type: 'moveBefore',
                            entityName: entityName,
                            database: database,
                            id: $sorted.data('itemid'),
                            positionEntityId: $next.data('itemid')
                        });
                    } else {
                        show_notif('','{{__('messages.unsuccessful_operation')}}','e','tc',15000);
                    }
                },
                cursor: "move"
            });
        }
    });
</script>
<!-- End Sortable -->