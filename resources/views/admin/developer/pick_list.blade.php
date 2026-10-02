{{-- Multiselect v2.2.10 --}}
{{-- http://crlcu.github.io/multiselect/ --}}

<!-- Pick list -->
<script type='text/javascript' src="{{asset('assets/admin/_plugins/multiselect/js/multiselect.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#picklist").multiselect({
            keepRenderingSort:true,
            search: {
                left: '<input type="text" class="picklist_search" placeholder="{{__('content.search')}} ..." />',
                right: '<input type="text" class="picklist_search" placeholder="{{__('content.search')}} ..." />'
            },
            left: '.picklist_from select',
            right: '.picklist_to select',
            rightAll: '.picklist_btn .left_all',
            rightSelected: '.picklist_btn .left_selected',
            leftSelected: '.picklist_btn .right_selected',
            leftAll: '.picklist_btn .right_all',
        });
    });
</script>
<!-- End Pick list -->