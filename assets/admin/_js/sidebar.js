$(document).ready(function(){

    //////////////////////////////////////////////////////////////////////
    // toggle menu
    $('.tab_content1 .list_style1 .step1 .link1').click(function(){
        var $this = $(this);
        var $target_step2 = $this.closest('.item').find('.step2');
        var $all_step2 = $('.list_style1 .step2');

        if(!$target_step2.is(':visible')){
            $all_step2.not($target_step2).slideUp(250);
            $target_step2.slideDown(250,function(){
                $(".mainside_style1,.sidebar_style1").trigger("sticky_kit:recalc");
            });
        }// show
        else{
            $target_step2.slideUp(250,function(){
                $(".mainside_style1,.sidebar_style1").trigger("sticky_kit:recalc");
            });
        }// hide


    });

    //////////////////////////////////////////////////////////////////////
    // hide arrow for items that doesnt have subitem
    // hide items with href='#' (has_href=0) that doesnt have any subitem
    $('.tab_content1 .list_style1 .step1 .item1').each(function(){
        if($(this).has("ul.step2").length != 0){
            $(this).addClass('hassub');
        }else{
            if($(this).find(".link1[href='#']").length !=0 ){
                $(this).remove();
            }
        }
    });

    //////////////////////////////////////////////////////////////////////
    // remove empty tabs
    var $tab_content1_item_count = $('.sidebar_style1 .sidebar_part3 .tab_content1 .step1 .item1').length;
    if($tab_content1_item_count == 0){
        $('.sidebar_style1 .sidebar_part2 .step1 .item.tab1').remove();
        $('.sidebar_style1 .sidebar_part3 .tab_content1').remove();
    }
    var $tab_content2_item_count = $('.sidebar_style1 .sidebar_part3 .tab_content2 .step1 .item1').length;
    if($tab_content2_item_count == 0){
        $('.sidebar_style1 .sidebar_part2 .step1 .item.tab2').remove();
        $('.sidebar_style1 .sidebar_part3 .tab_content2').remove();
    }
    var $tab_content3_item_count = $('.sidebar_style1 .sidebar_part3 .tab_content3 .step1 .item1').length;
    if($tab_content3_item_count == 0){
        $('.sidebar_style1 .sidebar_part2 .step1 .item.tab3').remove();
        $('.sidebar_style1 .sidebar_part3 .tab_content3').remove();
    }

    //////////////////////////////////////////////////////////////////////
    // set active class for item1 in tab1 when item2 is active
    $('.tab_content1 .list_style1 .step1 .item.active').each(function(){
        $(this).closest('.item1').addClass('active');
    });

    //////////////////////////////////////////////////////////////////////
    // show alert on menu where no is greater than 0
    $(".list_style1 .no.alert,.list_style2 .no.alert").each(function(){
        var $this = $(this);
        var no_str = $this.text();
        var no = parseInt(no_str.substring(1,no_str.length-1));

        if(no > 0){
            $this.closest('.item1').addClass('show_notif');
            $this.closest('.item2').addClass('show_notif');
            if($this.closest('.tab_content2').length != 0){
                $('.sidebar_style1 .sidebar_part2 .step1 .item.tab2 .notif').show(0);
            }
            if($this.closest('.tab_content3').length != 0){
                $('.sidebar_style1 .sidebar_part2 .step1 .item.tab3 .notif').show(0);
            }
        }
    });

    //////////////////////////////////////////////////////////////////////
    // switch tab in sidebar
    $('.sidebar_style1 .sidebar_part2 .item[data-tabno]').click(function(){
        var $this = $(this);
        var tabno = $this.attr('data-tabno');

        //reset and set tab active
        $('.sidebar_style1 .sidebar_part2 .item[data-tabno]').removeClass('active');
        $this.addClass('active');

        //reset and set tab content active
        $('.sidebar_style1 .sidebar_part3 .tab_content').removeClass('active');
        $('.sidebar_style1 .sidebar_part3 .tab_content'+tabno).addClass('active');

        $(".mainside_style1,.sidebar_style1").trigger("sticky_kit:recalc");
    });

    //////////////////////////////////////////////////////////////////////
    // search in pages
    $('.sidebar_style1 .search_wrapper input').keyup(function(){
        var $this = $(this);
        var keyword = $this.val().trim();
        var $target = $('.sidebar_style1 .list_style1 .item,.sidebar_style1 .list_style2 .item,.sidebar_style1 .sidebar_part1 .usermenu_part2 .item').not('.sidebar_style1 .search_result .list_style2 .item');
        var $result = $('.sidebar_style1 .search_result .list_style2 .step1');
        var html_result = "";

        if(keyword != ''){
            $target.find(".link:contains('"+keyword+"')").each(function(){
                if($(this).closest('.item').find('ul').length == 0){
                    var $text = $(this).text();
                    var $href = $(this).attr('href');
                    html_result += "<li class='item item1'><a class='link link1' href='"+$href+"'>"+$text+"</a></li>";
                }
            });
        }
        $result.html(html_result);
    });

    //////////////////////////////////////////////////////////////////////
    // open admin profile menu
    $('.sidebar_style1 .sidebar_part1 .usermenu_part1').click(function(){
        var $target = $(this).closest('.usermenu_wrapper').find('.usermenu_part2');

        if(!$target.is(':visible')){
            $target.addClass('active');
        }//show
        else{
            $target.removeClass('active');
        }//hide
    });
    // close admin profile menu
    $('body').on('click',function(e){
        if(!$(e.target).is('.sidebar_style1 .sidebar_part1,.sidebar_style1 .sidebar_part1 *')){
            $('.sidebar_style1 .sidebar_part1 .usermenu_part2').removeClass('active');
        }
    });

    //////////////////////////////////////////////////////////////////////
    // set width of tabs
    var $tab_count = $('.sidebar_style1 .sidebar_part2 .step1 .item:visible').length;
    var $tab_width = 100/$tab_count;
    $('.sidebar_style1 .sidebar_part2 .step1 .item').css('width',$tab_width+'%');

    //////////////////////////////////////////////////////////////////////
    // active first tab when there isnt any active tab
    var $active_tab_count = $('.sidebar_style1 .sidebar_part2 .step1 .item.active').length;
    if($active_tab_count == 0){
        $('.sidebar_style1 .sidebar_part2 .step1 .item:first-child').addClass('active');
        $('.sidebar_style1 .sidebar_part3 .tab_content:first-child').addClass('active');
    }


    //////////////////////////////////////////////////////////////////////
    // set height of sidebar & mainside
    $('#all_page_container').css('min-height',$win_height);

});