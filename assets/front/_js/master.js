$(document).ready(function() {

    ////////////////////////////////////////////////////////////////////////////
    //disable # anchors
    $('body').on('click',"a[href='#']",function(e){e.preventDefault();});
    $("a[href='#']").click(function(e){e.preventDefault();});
    // $('a').attr('href','#');


    ////////////////////////////////////////////////////////////////////////////
    //back to prev page
    $('[data-backurl]').click(function(e){
        e.preventDefault();
        parent.history.back();
        return false;
    });


    ////////////////////////////////////////////////////////////////////////////
	/*remain chars*/
	$("[data-remain-chars]").each(function() {
        var no = $(this).attr("data-remain-chars");
        $(this).remaining_char(no);
    });


    ////////////////////////////////////////////////////////////////////////////
    //text direction
    $('input[type=text]').keypress(function(){
        $this = $(this);
        if($this.val().length == 1){
            var x =  new RegExp("[\x00-\x80]+"); // is ascii
            var isAscii = x.test($this.val());

            if(isAscii){$this.css("direction", "ltr");}
            else{$this.css("direction", "rtl");}
        }
    });


	//////////////////////////////////////////////////////////////////////////////
	//go_to_top
	$('.goto_top').click(function(){
		$('html,body').animate({scrollTop:0},1500);
	});
    //go to top
    $(window).scroll(function(){
        var body_sc=$(this).scrollTop();
        if( body_sc > 500){
            $('.goto_top').addClass('active');
        }
        else{
            $('.goto_top').removeClass('active');
        }
    });

    ////////////////////////////////////////////////////////////////////////////
    //number_format inputs
    $("input.number_format").keyup(function(){
        var num = this.value.replace(/[^\d]/g, '');
        if(num.length>3)
            num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        this.value = num;
    });


    //////////////////////////////////////////////////////////////////////
    // refresh captcha
    $('[data-refresh-captcha]').click(function(){
        var $this = $(this);
        var src_captcha = "_includes/captcha.php?"+Date.now();
        $this.closest('.captcha_wrapper').find('img.captcha_pic').attr('src',src_captcha);
    });


    ///////////////////////////////////////////////////////////////////
	//cropper
	$('[data-run-cropper]').change(function(){
		var x = $(this).attr('data-x');
		var y = $(this).attr('data-y');
        var element = $(this).attr('data-element');

        $(element).find('.cropper_preview').css('background-image','none');
        $(element).find('.rmv_file').show();
        $(element).find('.rmv_file').attr('data-filename','1');

		setTimeout(function(){run_cropper(element,x,y);},500);
	});

    ////////////////////////////////////////////////////////////////////////////
    //ellipsis
    ellipsis();


    ////////////////////////////////////////////////////////////////////////////1
    //textarea autosize
	if($('.autosize').length != 0){
        autosize($('.autosize'));
	}


    ////////////////////////////////////////////////////////////////////////////1
    //lazy img
	if($('[data-lazy-img]').length != 0){
    	$('[data-lazy-img]').lazy();
	}


    ////////////////////////////////////////////////////////////////////////////
    // get image info
    $('[data-image-info]').change(function(){
        var $this = $(this);
        var $form = $this.closest('form');
        var files = !!this.files ? this.files : [];
        var image = new Image();
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);

        reader.onloadend = function() {
          image.src = this.result;
          image.onload = function() {
            $this.attr('data-width',image.width);
            $this.attr('data-height',image.height);
            $form.valid();
          };
        };
    });


    ////////////////////////////////////////////////////////////////////////////
    //tooltip
    $('.tooltip').parent().hover(function(){
        $(this).find('.tooltip').stop(true,true).fadeIn(200);
    },function(){
        $(this).find('.tooltip').stop(true,true).fadeOut(200);
    });

    $(document.body).on({
        mouseenter:function () {
            $(this).find('.tooltip_style1').stop(true,false).delay(300).fadeIn(300,function(){
                $(this).removeClass('loading');
            });
        },
        mouseleave:function () {
            $(this).find('.tooltip_style1').stop(true,false).fadeOut(200,function () {
                $(this).addClass('loading');
            });
        }
    },'.has_tooltip');



    ////////////////////////////////////////////////////////////////////////////
    //Select With Select Style
    $('select[data-select-style]').each(function(){
        var label = $(this).find('option:selected').text();
        $(this).siblings('.select_label').text(label);
    });

    $('select[data-select-style]').change(function(){
        var label = $(this).find('option:selected').text();
        $(this).siblings('.select_label').text(label);
    });//change


    ////////////////////////////////////////////////////////////////////////////
    //Change State
    $("select[name=state_id]").change(function(){
        var $this = $(this);
        var state_id = $(this).val();
        $this.closest("form").find("select[name=city_id]").closest(".select_style").addClass("loading_ajax");

        $.post("_includes/ajax-process.php",{
            state_id:state_id,
            go_change_state:""
        },function(response){
            $this.closest("form").find("select[name=city_id]").html(response);
            $this.closest("form").find("select[name=city_id]").closest(".select_style").find(".select_label").text("--انتخاب شهر--");
            $this.closest("form").find("select[name=area_id]").html("<option value=''>--انتخاب منطقه--</option>");
            $this.closest("form").find("select[name=area_id]").closest(".select_style").find(".select_label").text("--انتخاب منطقه--");
            $this.closest("form").find("select[name=region_id]").html("<option value=''>--انتخاب محدوده--</option>");
            $this.closest("form").find("select[name=region_id]").closest(".select_style").find(".select_label").text("--انتخاب محدوده--");
            $this.closest("form").find("select[name=city_id]").closest(".select_style").removeClass("loading_ajax");
        });
    });//Change State & City

    //Change City
    $("select[name=city_id]").change(function(){
        var $this = $(this);
        var city_id = $(this).val();
        $this.closest("form").find("select[name=area_id]").closest(".select_style").addClass("loading_ajax");

        $.post("_includes/ajax-process.php",{
            city_id:city_id,
            go_change_city:""
        },function(response){
            var data = $.parseJSON(response);
            $this.closest("form").find("select[name=area_id]").html(data.area);
            $this.closest("form").find("select[name=area_id]").closest(".select_style").find(".select_label").text("--انتخاب منطقه--");
            $this.closest("form").find("select[name=region_id]").html("<option value=''>--انتخاب محدوده--</option>");
            $this.closest("form").find("select[name=region_id]").closest(".select_style").find(".select_label").text("--انتخاب محدوده--");
            $this.closest("form").find("select[name=area_id]").closest(".select_style").removeClass("loading_ajax");
        });
    });//Change State & City

    //Change Area
    $("select[name=area_id]").change(function(){
        var $this = $(this);
        var area_id = $(this).val();
        $this.closest("form").find("select[name=region_id]").closest(".select_style").addClass("loading_ajax");

        $.post("_includes/ajax-process.php",{
            area_id:area_id,
            go_change_area:""
        },function(response){
            var data = $.parseJSON(response);
            $this.closest("form").find("select[name=region_id]").html(data.region);
            $this.closest("form").find("select[name=region_id]").closest(".select_style").find(".select_label").text("--انتخاب محدوده--");
            $this.closest("form").find("select[name=region_id]").closest(".select_style").removeClass("loading_ajax");
        });
    });//Change State & City


    ////////////////////////////////////////////////////////////////////////////
    //Scrolls Y
    var mCustomScrollOptions={
        snapAmount:40,
        scrollButtons:{enable:true},
        keyboard:{scrollAmount:40},
        mouseWheel:{deltaFactor:40},
        scrollInertia:400,
        theme:"dark-thin",
        /*autoHideScrollbar:true*/
    };
	$(".have_scroll_y").mCustomScrollbar(mCustomScrollOptions);
	$.prototype.refreshmCustomScrollbar=function(){
	    $(this).mCustomScrollbar('destroy');
	    $(this).mCustomScrollbar(mCustomScrollOptions);
    };

	//Scrolls X
	$(".have_scroll_x").mCustomScrollbar({
		axis:"x",
		theme:"dark-thin",
		advanced:{autoExpandHorizontalScroll:true},
		//scrollbarPosition:"outside",
		snapAmount:40,
		scrollButtons:{enable:true},
		keyboard:{scrollAmount:40},
		mouseWheel:{deltaFactor:40},
		scrollInertia:400,
		autoHideScrollbar:true
	});


	//////////////////////////////////////////////////////////////////////////////
	//NewsLetter
	$('[data-go-newsletter]').click(function(e){
		e.preventDefault();
        var $form = $(this).closest("form");
		var $this = $(this);
		var email = $form.find('input[name=email]').val();

		if(email.trim() != ''){
			if($form.valid()){
				show_modal();
				$.post("_includes/ajax-process.php",{
					go_newsletter:'',
					email:email,
				},function(response){
					hide_modal();
					var data = $.parseJSON(response);
					if(data.error == ""){
						show_notif("","شما با موفقیت به خبرنامه سایت پیوستید.",'s',5000);
						$form.find('input[name=email]').val("");
					}else{
						show_notif("خطا",data.error,'e',5000);
					}
				});
			}//email ok
			else{
				show_notif("خطا","ایمیل وارد شده معتبر نمی باشد",'e',5000);
			}
		}//required ok
		else{
			show_notif("خطا","ابتدا ایمیل خود را وارد نمایید...",'e',5000);
		}
	});//NewsLetter
    //////////////////////////////////////////
    //box_info_btn notification
    $(document.body).on('click','.box_style2 .box_info .box_info_btn .btn',function () {
        $(document.body).find('.box_style2 .box_info .box_info_btn .btn').removeClass('active');
        $(this).addClass('active');

        $('.box_style2 .box_info_step').fadeOut(200);
        $(this).parent().find('.box_info_step').stop(true,false).fadeToggle(200);
    });

    $("body").click(function (e) {
        if (!$(e.target).is(".box_style2 .box_info .box_info_btn") && !$(e.target).is(".box_style2 .box_info .box_info_btn *")) {
            $('.box_style2 .box_info_step').fadeOut(200);
            $('.box_style2 .box_info .box_info_btn .btn').removeClass('active');
        }
    });//body click
    //////////////////////////////////////////
    //search Open & Result
    $('.header_part1 .search_btn').click(function () {
        $('.modal_style1.search_modal').fadeIn(300);
        $('body').css('overflow','hidden');
    });
   /* $('.modal_style1.search_modal .search_form input').keyup(function(){
        $('.modal_style1.search_modal .search_result .item').stop(true,false).slideDown(700);
        $('.modal_style1.search_modal .search_form .loading .loading_img').stop(true,false).fadeIn(200).delay(800).fadeOut(200);
        var input_c = $('.modal_style1.search_modal .search_form input').val();
        if(input_c===undefined || input_c==""){
            $('.modal_style1.search_modal .search_result .item').stop(true,false).slideUp(700);
        }
    });*/
    //close modal
    $(document.body).on('click','.modal_style1 .close_bg , .modal_style1 .close_btn',function(){
        $('.modal_style1').fadeOut(300);
        $('body').css('overflow','auto');
    });


    $("body").click(function (e) {
        if (!$(e.target).is(".modal_style1 .wrapper , .change_pic_btn , .search_btn , .header_responsive_search , .share_btn, .change_pic_profile_btn , .modal_btn , .modal_style1.search_modal .wrapper , .header_part1 .search_btn , .modal_btn ,.rate_style1,.swal-modal") &&
            !$(e.target).is(".modal_style1 .wrapper * , .change_pic_btn * , .search_btn * , .header_responsive_search * , .share_btn *, .change_pic_profile_btn * ,  .modal_btn * , .modal_style1.search_modal .wrapper * , .header_part1 .search_btn * , .modal_btn * , .rate_style1 *,.swal-modal *")) {
            $('.modal_style1').fadeOut(300);
            $('body').css('overflow','auto');
        }
    });//body click
    //////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////
    ////////////////////////////////
    //open sub menu
    $('.have_sub .link').click(function () {
        var item=$(this).parent('.have_sub');
        var sub = item.find('.sub_menu');
        $('.sub_menu').removeClass('active').stop(true,false).fadeOut(200);
        $('.have_sub').removeClass('active');

        if(item.hasClass('active')){
        }
        else{
            $(this).parent('.item').find('.sub_menu').addClass('active').stop(true,false).fadeIn(300);
            item.addClass('active');
        }
    });
    $("body").click(function (e) {
        if (!$(e.target).is(".have_sub , .cart_page .sign_in_btn , .swal-modal") && !$(e.target).is(".have_sub * , .cart_page .sign_in_btn * , .swal-modal *")) {
            $('.sub_menu').removeClass('active').fadeOut(200);
            $('.have_sub').removeClass('active');
        }
    });//body click

    ////////////////////////////////
    // fancy
    $(".fancybox").fancybox({
        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : true,
        arrows    : false,
        nextClick : false,

        helpers : {
            thumbs : {
                width  : 50,
                height : 50
            }
        }
    });
    //////////////////////////////
    //win scroll
    $(window).scroll(function(){
        var body_sc=$(this).scrollTop();

        if(body_sc > 50){
            $('.header_part1').addClass('active');
        }
        else{
            $('.header_part1').removeClass('active');
        }
    });
    /////////////////////////////
    // responsive menu btn
    $('.header_responsive_btn').click(function () {
        $(this).closest('.header_part1').find('.header_btn').toggleClass('active');
    });
    $('.header_responsive_search').click(function () {
        /*$(this).toggleClass('active');
        $(this).closest('.header_part1').find('.search_btn').toggleClass('active');*/
        $('.modal_style1.search_modal').fadeIn(300);
        $('body').css('overflow','hidden');
    });


});//document ready

