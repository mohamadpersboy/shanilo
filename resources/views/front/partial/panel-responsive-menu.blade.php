<script>

    $(document).ready(function() {

        //////////////////////////////////////////////////
        // panel responsive btn menu
        $('.panel_style1 .dashboard .panel_menu_btn').click(function(){
            $(this).parent('.bottom_part').find('.step2').slideToggle(200);
        });

    });//document ready
</script>