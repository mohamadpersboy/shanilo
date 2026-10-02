$(document).ready(function() {
    ////////////////////////////////////////////////////////////////////////////
    //disable # anchors
    $('body').on('click',"a[href='#']",function(e){e.preventDefault();});
    $("a[href='#']").click(function(e){e.preventDefault();});
        
    
    ////////////////////////////////////////////////////////////////////////////
    // change lang set cookie
    $('[data-change-lang]').click(function(){
        var lang = $(this).attr('data-change-lang');
        $.cookie('lang', lang, { expires: 100, path: '/' });
        var lang_dir = (lang == '')?'':lang+'/';
        location.replace($broot+lang_dir+'set-admin');
    });
    $(".lang_style .active_lang").click(function(){
        $(this).closest(".lang_style").find(".lang_list").slideToggle(100);
    });
    $("body").on("click",function(e){
        if(!$(e.target).is(".lang_style") && !$(e.target).is(".lang_style *")){
            $(".lang_style1 .lang_list").slideUp(100);
        }
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    //back to prev page
    $('[data-backurl]').click(function(e){
        e.preventDefault();
        parent.history.back();
        return false;
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    //auto submit forms
    // $('#frm_pagin_limit select,#frm_page_status select').change(function(){
    //     $(this).closest('form').submit();
    // });
        
    
    ////////////////////////////////////////////////////////////////////////////
    //remove selected items
    $('[data-remove-selected]').click(function(){
        var attr = $(this).attr('data-remove-selected');
        var table = $(this).attr('data-table');
        var key = $(this).attr('data-key');
        var dir = $(this).attr('data-dir');
        var file_field = $(this).attr('data-file-field');
        var $target = $('['+attr+']');
        
        key = (typeof key !== typeof undefined && key !== false)?key:"id";
        dir = (typeof dir !== typeof undefined && dir !== false)?dir:"";
        file_field = (typeof file_field !== typeof undefined && file_field !== false)?file_field:"";
        
        var requestData = $target.serializeArray();
        requestData.push({name:'table',value:table});
        requestData.push({name:'key',value:key});
        requestData.push({name:'dir',value:dir});
        requestData.push({name:'file_field',value:file_field});
        requestData.push({name:'go_remove_selected',value:''});
        
        if($target.filter(":checked").length != 0){
            modal_msg("warning","آیا در مورد حذف آیتم های انتخابی اطمینان دارید؟","<a href='#' class='modal_btn remove'>بله</a>");
            $('.modal .modal_btn.remove').click(function(){
                hide_modal();show_modal('.bg2');
                $.post("_includes/ajax-process.php",requestData,function(response){
                    hide_modal();
                    if(response == 1){
                        location.reload();
                    }//ok
                    else if(response == 0){
                        show_notif("خطا","متاسفانه در انجام عملیات خطایی رخ داده است، مجددا تلاش نمائید.","e",0);
                    }//nok
                });//post
            });//click
        }//check is ok
        else {
            show_notif("خطا","حداقل یک آیتم را انتخاب نمائید.","w",5000);
        }
    });
    
    
    //////////////////////////////////////////////////////////////////////////////	
	// REMOVE FILE
    $("body").on('click','[data-remove-file]:not(.loading_remove)',function(){
        var $this = $(this);

        var scope = $this.attr('data-scope');
        var table = $this.attr('data-table');
        var table_name = $this.attr('data-table-name');
        var id = $this.attr('data-id');
        var field = $this.attr('data-field');
        var dir = $this.attr('data-dir');
        var file_name = $this.attr('data-file-name');
        var vers = $this.attr('data-vers');
        var input_name = $this.attr('data-input-name');
        var pic_default = $this.attr('data-pic-default');
        var pic_old = $this.attr('data-pic-old');
        var pic_place = $this.attr('data-pic-place');
        var rmv_elm = $this.attr('data-rmv-elm');
        var rmv_closest = $this.attr('data-rmv-closest');
        var refresh = $this.attr('data-refresh');
        
        scope =  (typeof scope !== typeof undefined && scope !== false)?scope:"";
        table = (typeof table !== typeof undefined && table !== false)?table:"";
        table_name = (typeof table !== typeof undefined && table_name !== false)?table_name:"";
        id = (typeof id !== typeof undefined && id !== false)?id:"";
        field = (typeof field !== typeof undefined && field !== false)?field:"";
        dir = (typeof dir !== typeof undefined && dir !== false)?dir:"";
        file_name = (typeof file_name !== typeof undefined && file_name !== false)?file_name:"";
        vers = (typeof vers !== typeof undefined && vers !== false)?vers:"";
        input_name = (typeof input_name !== typeof undefined && input_name !== false)?input_name:"";
        pic_default =  (typeof pic_default !== typeof undefined && pic_default !== false)?pic_default:"";
        pic_old =  (typeof pic_old !== typeof undefined && pic_old !== false)?pic_old:"";
        pic_place =  (typeof pic_place !== typeof undefined && pic_place !== false)?pic_place:"";
        rmv_elm =  (typeof rmv_elm !== typeof undefined && rmv_elm !== false)?rmv_elm:"";
        rmv_closest =  (typeof rmv_closest !== typeof undefined && rmv_closest !== false)?rmv_closest:"";
        refresh = (typeof refresh !== typeof undefined && refresh !== false)?refresh:"";
        
        if(table == ""){
            if(input_name != ''){
                $('input[name='+input_name+']').val('');
                if($('input[name='+input_name+']').is("[data-image-info]")){
                    $('input[name='+input_name+']').attr('data-width','0');
                    $('input[name='+input_name+']').attr('data-height','0');
                }
            }
            
            if(pic_old != ""){
                if($(scope).find(pic_place).is("img")){
                    $(scope).find(pic_place).attr("src",pic_old);
                    $(scope).find(pic_place).attr("style","");
                }else{
                    $(scope).find(pic_place).css("background-image","url("+pic_old+")");
                    $(scope).find(pic_place+" img").remove();
                }
            }
            else if(pic_default != ""){
                if($(scope).find(pic_place).is("img")){
                    $(scope).find(pic_place).attr("src",pic_default);
                    $(scope).find(pic_place).attr("style","");
                }else{
                    $(scope).find(pic_place).css("background-image","url("+pic_default+")");
                    $(scope).find(pic_place+" img").remove();
                }
                $this.css('display','none'); 
            }
            else{
                $(scope).find(pic_place).remove();
                $this.css('display','none'); 
            }
            
            if(rmv_elm != ""){
                $(scope).find(rmv_elm).remove();
            }
            
            if(rmv_closest != ""){
                $this.closest(rmv_closest).remove();
            }
            
            $this.attr('data-table',table_name);
            
            /*if(refresh != ""){
                location.reload();
            }*/
            
        }//static remove
        else{
            modal_msg("warning","آیا از حذف این آیتم ها مطمئن هستید؟","<a href='#' class='modal_btn yes'>بله</a>");
            $('.modal .modal_btn.yes').click(function(){
                hide_modal(); show_modal();

                $this.addClass('loading_remove');        

                $.post("_includes/ajax-process.php",{
                    go_remove_file:'',
                    table:table,
                    field:field,
                    id:id,
                    dir:dir,
                    file_name:file_name,
                    vers:vers,
                },function(response){
                    $this.removeClass('loading_remove');
                    hide_modal();
                    
                    if(response == 1){
                        
                        $this.css('display','none');
                        
                        if(input_name != ''){
                            $('input[name='+input_name+']').val('');
                            $('input[name='+input_name+'_old]').val('');
                            if($('input[name='+input_name+']').is("[data-image-info]")){
                                $('input[name='+input_name+']').attr('data-width','0');
                                $('input[name='+input_name+']').attr('data-height','0');
                            }
                        }
                        
                        if(pic_old != ""){
                            $this.attr('data-pic-old','');
                        }
                        
                        if(pic_default != ""){
                            if($(scope).find(pic_place).is("img")){
                                $(scope).find(pic_place).attr("src",pic_default);
                            }else{
                                $(scope).find(pic_place).css("background-image","url("+pic_default+")");
                            }
                            $this.css('display','none'); 
                        }
                        else{
                            $(scope).find(pic_place).remove();
                            $this.css('display','none'); 
                        }
            
                        if(rmv_elm != ""){
                            $(scope).find(rmv_elm).remove();
                        }

                        if(rmv_closest != ""){
                            $this.closest(rmv_closest).remove();
                        }
                        
                        if(refresh != ""){
                            location.reload();
                        }
                    }else{
                        show_notif("Error","Some errors occured!",'e',5000);
                    }
                });//post
            });//modal
        }//dynamic remove
        
        $(scope).find(".file_style .file_label").text("--> Choose file");
    });//$("[data-remove-file]").click


    //////////////////////////////////////////////////////////////////////////////
    // REMOVE SELECTED FILE
    $("body").on("change","[data-select-file]",function(){
        var $wrapper = $(this).closest("[data-select-file-wrapper]");
        var $selected_item = $wrapper.find("[data-select-file]:checked");
        var $remove_btn = $wrapper.find("[data-remove-selected-file]");
        if($selected_item.length != 0){
            $remove_btn.show();
        }else{
            $remove_btn.hide();
        }
    });

    $("body").on('click','[data-remove-selected-file]:not(.loading_remove)',function(e){
        e.preventDefault();
        var $this = $(this);
        var $wrapper = $(this).closest("[data-select-file-wrapper]");

        var href = $this.attr('href');
        var _token = $this.attr('data-token');
        var refresh = $this.attr('data-refresh');
        var attr = $(this).attr('data-remove-selected-file');
        var $target = $wrapper.find('['+attr+']');


        refresh = (typeof refresh !== typeof undefined && refresh !== false)?refresh:"";


        var requestData = $target.serializeArray();
        requestData.push({name:'_token',value:_token});
        requestData.push({name:'go_remove_selected_file',value:''});

        if($target.filter(":checked").length != 0){
            modal_msg("warning","آیا از حذف این آیتم ها مطمئن هستید؟","<a href='#' class='modal_btn yes'>بله</a>");

            $('.modal .modal_btn.yes').click(function(){
                hide_modal(); show_modal();
                $this.addClass("ajaxload_style1 loading_remove");
                $.post(href,requestData,function(response){
                    $this.removeClass('ajaxload_style1 loading_remove');
                    hide_modal();
                    if(response == 1){
                        $target.filter(":checked").each(function(){
                            $(this).closest("[data-file-item]").fadeOut(500,function(){
                                $(this).closest("[data-file-item]").remove();
                            });
                        });

                        if(refresh != ""){location.reload();}
                    }else{
                        show_notif("خطا","خطلایی در انجام عملیات رخ داده است، لطفا مجددا تلاش نمایید",'e',5000);
                    }

                    var $selected_item = $wrapper.find("[data-select-file]:checked");
                    var $remove_btn = $wrapper.find("[data-remove-selected-file]");
                    if($selected_item.length != 0){
                        $remove_btn.show();
                    }else{
                        $remove_btn.hide();
                    }
                });//post
            });//modal
        }//check is ok
        else {
            show_notif("خطا","حداقل یک آیتم را انتخاب نمائید.","w",5000);
        }
    });//$("[data-remove-selected-file]").click
    
    
    ////////////////////////////////////////////////////////////////////////////
    // form validation
    $('form.form_validation [type=submit]').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var $form_btn = $this;
        var $form = $this.closest('form');
        
        if($form_btn.is('.ajaxload_style1')){
            return false;
        }
        
        if($form.valid()){
            $form.submit();
        }else {
            $('select.error,input[type=file].error,[data-ckeditor].error,input[type=hidden].error').each(function(){
                $(this).closest('.select_style').addClass('error error_style1');
                $(this).closest('.file_style').addClass('error error_style1');
                $(this).closest('.editor_style').addClass('error error_style1');
            });
            var error_pos = $form.find('.error:visible').first().offset().top-100;
            $('html body').animate({'scrollTop':error_pos},250);
        }
    });
    $('.select_style select,.file_style input[type=file]').change(function(){
        $(this).closest('.select_style').removeClass('error error_style1');
        $(this).closest('.file_style').removeClass('error error_style1');
    });
    
    
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
    // toggle pass icon
    $('[data-toggle-pass]').hover(function(){
        var $this = $(this);
        var $icon = $this.find('[data-toggle-pass-icon]');
        var $input = $this.find('input');
        
        $icon.addClass('show');
    },function(){
        var $this = $(this);
        var $icon = $this.find('[data-toggle-pass-icon]');
        var $input = $this.find('input');
        var $input_type = $input.attr('type');
        
        if($input_type == 'password') {  
            $icon.removeClass('show');
        }
    });
    $('[data-toggle-pass-icon]').click(function(e){
        var $this = $(this);
        var $input = $this.closest('[data-toggle-pass]').find('input');
        var $input_type = $input.attr('type');
        
        if($input_type == 'text') {
            $input.attr('type','password');
            $this.removeClass('show_pass');
        }
        else if($input_type = 'password') {
            $input.attr('type','text');
            $this.addClass('show_pass');
        }
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    // change status
    $("body").on("change","[data-change-status]",function(e){
        var table = $(this).attr('data-table');
        var id = $(this).attr('data-id');
        var field = $(this).attr('data-field');
        var val = $(this).attr('data-val');
        var checked = $(this).prop('checked');
        if($(this).attr('data-change-status') == 'toggle'){
            var val = (checked == true)?"1":"0";    
        }
        
        change_status(table,id,field,val);
    });//Change Status
    

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
    
    
    ////////////////////////////////////////////////////////////////////////////
    //number format inputs
    $("body").on('keyup','input.number_format',function(){
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


    ////////////////////////////////////////////////////////////////////////////
    // select all checkbox
    $("body").on("change","input[type='checkbox'][data-select-all]",function(){
        var checked = $(this).prop('checked');
        var target = $(this).attr('data-select-all');
        $("["+target+"]").prop('checked',checked).change();
    });
    
    $("[data-select-all-btn]").click(function(){
        var checked = ($(this).attr('data-checked') == '0')?'1':'0';
        $(this).attr('data-checked',checked);
        var prop_checked = (checked == '1')?true:false;
        var target = $(this).attr('data-select-all-btn');
        $("["+target+"]").prop('checked',prop_checked).change();
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    // active tr in table when select checkbox is checked
    $("body").on('change','table [data-select-row]',function(){
        var checked = $(this).prop('checked');
        if(checked == true){
            $(this).closest('tr').addClass('active');
        }else {
            $(this).closest('tr').removeClass('active');
        }
    });


    ////////////////////////////////////////////////////////////////////////////
	// remain chars
	$("[data-remain-chars]").each(function() {
        var no = $(this).attr("data-remain-chars");
        $(this).remaining_char(no);
    });


    ////////////////////////////////////////////////////////////////////////////
	// date picker
	$("[data-date-picker]").each(function() {
        var id = $(this).attr("id");
        date_picker(id);
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    // ellipsis
    ellipsis();
    
    
    ////////////////////////////////////////////////////////////////////////////
    // video player
    run_player();
    
 
    /////////////////////////////////////////////////////////////////////////////////
    // select box
    $("[data-select-box]").chosen({
        no_results_text: "نتیجه ای یافت نشد!",
        width: '100%',
    });
    if($('[data-select-box-check]').length != 0){
        $('[data-select-box-check]').multiselect({
            columns: 1,
            search:true,
            selectAll:true,
            texts: {
                placeholder: '-- انتخاب نمائید --',
                search: 'جستجو کنید',
                selectAll:'انتخاب همه موارد',
                selectedOptions:' مورد انتخاب شده'
            }
        });
    }
    
    ////////////////////////////////////////////////////////////////////////////1
    // textarea autosize
	if($('.autosize').length != 0){
        autosize($('.autosize'));
	}
    
    
    ////////////////////////////////////////////////////////////////////////////1
    // lazy img
	if($('[data-lazy-img]').length != 0){
    	$('[data-lazy-img]').lazy();
	}
    
    
    //////////////////////////////////////////////////////////////////////
    // ADD REMOVE SAMPLE HTML
	$("body").on("click","[data-sample-html-add]",function(e){
        var target_no = $(this).attr('data-sample-html-add');
        var sample_no = $("[data-sample-html-items="+target_no+"]").find('[data-sample-html-item]').length;
        $("[data-sample-html="+target_no+"] input.tokenfield").attr('id','tag_show_'+sample_no);
        $("[data-sample-html="+target_no+"] input.token-input").attr('id','tag_show_'+sample_no+'-tokenfield');
        var sample_html = $("[data-sample-html="+target_no+"]").html();
        var keyno = $(this).attr('data-keyno');

        keyno =  (typeof keyno !== typeof undefined && keyno !== false)?parseInt(keyno)+parseInt(sample_no):sample_no;
        $("[data-sample-html-items="+target_no+"]").append(sample_html);
        
        if($("[data-sample-html-items="+target_no+"] [name*=keyno]").length != 0){
            $("[data-sample-html-items="+target_no+"] [name*=keyno]").each(function(){
                var input_name = $(this).attr('name');
                var input_name = input_name.replace("keyno",keyno);
                $(this).attr('name',input_name);
            });
        }

        if($("[data-sample-html-items="+target_no+"] select:has(option[data-change-bgcolor])").length != 0) {
            $('.select_style select:has(option[data-change-bgcolor])').on('change', function () {
                var $this = $(this);
                var option_color = $this.find("option:selected[data-change-bgcolor]").attr("data-change-bgcolor");
                var option_text = $this.find("option:selected[data-change-bgcolor]").text();
                if (option_color != "") {
                    $this.closest(".select_style").css({
                        "background": "linear-gradient(to right, " + option_color + " 20%, #fff 20%)"
                    });
                    $this.closest(".select_style").find(".select_label").text(option_text);
                }
            });
        }

        //price discount
        $("[data-price-value]").on("change keyup", function () {
            var $price = $(this);
            var $discount = $(this).closest('[data-price-wrapper]').find("[data-discount-value]");

            var price = number_unformat($price.val());
            var discount = ($discount.val().trim() != '') ? $discount.val().trim() : 0;
            discount = parseFloat(discount).toFixed(1);
            var discount_val = (price * discount) / 100;
            var price_discount = number_format(round_num(price - discount_val));
            $(this).closest('[data-price-wrapper]').find("[data-price-discount-value]").val(price_discount);
        });

        $("[data-discount-value]").on("change keyup", function () {
            var $price = $(this).closest('[data-price-wrapper]').find("[data-price-value]");
            var $discount = $(this);

            var price = number_unformat($price.val());
            var discount = ($discount.val().trim() != '') ? $discount.val().trim() : 0;
            discount = parseFloat(discount).toFixed(1);
            var discount_val = (price * discount) / 100;
            var price_discount = number_format(round_num(price - discount_val));
            $(this).closest('[data-price-wrapper]').find("[data-price-discount-value]").val(price_discount);
        });
        //End price discount

        $("[data-mvwc]").mask('000,000,000,000,000', {reverse: true});

        //token
        if($("[data-sample-html-items="+target_no+"] input.plus_tokenfield").length != 0){
            var fields = $("[data-sample-html-items="+target_no+"] input.plus_tokenfield").attr('data-field');
            var limit_no = $("[data-sample-html-items="+target_no+"] input.plus_tokenfield").attr('data-limit');
            fields = fields.split(",");
            fields.pop();
            $("[data-sample-html-items="+target_no+"] input.plus_tokenfield").tokenfield({
                autocomplete: {
                    source: fields,
                    delay: 100
                },
                limit:limit_no,
                showAutocompleteOnFocus: true
            });
            $("[data-sample-html-items="+target_no+"] input.plus_tokenfield").on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal');
            });
            $("[data-sample-html-items="+target_no+"] input.plus_tokenfield").unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal');
                    }
                }
                // $('input#tag_show').trigger('focus');
            });
        }
        if($("[data-sample-html-items="+target_no+"] input.plus_tokenfield_2").length != 0){
            var fields = $("[data-sample-html-items="+target_no+"] input.plus_tokenfield_2").attr('data-field');
            var limit_no = $("[data-sample-html-items="+target_no+"] input.plus_tokenfield_2").attr('data-limit');
            fields = fields.split(",");
            fields.pop();
            $("[data-sample-html-items="+target_no+"] input.plus_tokenfield_2").tokenfield({
                autocomplete: {
                    source: fields,
                    delay: 100
                },
                limit:limit_no,
                showAutocompleteOnFocus: true
            });
            $("[data-sample-html-items="+target_no+"] input.plus_tokenfield_2").on('tokenfield:initialize', function (e) {
                $(this).parent().find('.token').addClass('bg-teal');
            });
            $("[data-sample-html-items="+target_no+"] input.plus_tokenfield_2").unbind().on('tokenfield:createdtoken', function (e) {
                var data = e.attrs.value;
                var string = $(this).val(),
                    arr = string.split(','),
                    i;
                for(i in arr){
                    if(arr[i].trim() == data.trim()){
                        alert('قبلا ثبت شده است.');
                        $(e.relatedTarget).remove();
                    } else{
                        $(e.relatedTarget).addClass('bg-teal');
                    }
                }
                // $('input#tag_show').trigger('focus');
            });
        }

        //select_box
        if($("[data-sample-html-items="+target_no+"] select.data_select_box").length != 0){
            $("[data-sample-html-items="+target_no+"] select.data_select_box").chosen({
                no_results_text: "نتیجه ای یافت نشد!",
                width: '100%',
            }); 
        }
        //select_box_check
        if($("[data-sample-html-items="+target_no+"] select.data_select_box_check").length != 0){
            $("[data-sample-html-items="+target_no+"] select.data_select_box_check").multiselect({
                columns: 1,
                search:true,
                selectAll:true,
                texts: {
                    placeholder: '-- انتخاب نمائید --',
                    search: 'جستجو کنید',
                    selectAll:'انتخاب همه موارد',
                }
            }); 
        }
	});
	$("body").on("click","[data-sample-html-remove]",function(e){
        $(this).closest("[data-sample-html-item]").remove();
	});
    
    
    ///////////////////////////////////////////////////////////////////
	// FILE STYLE   
    $('[data-file-style]').change(function(){
        var file_name = $(this).val();
        var file_no = $(this)[0].files.length;
        
        if($(this).is('[multiple]') && file_no != 1){
            $(this).siblings('.file_label').text("--> "+file_no+" فایل انتخاب شده");
        }else{
            var startIndex = (file_name.indexOf('\\') >= 0 ? file_name.lastIndexOf('\\') : file_name.lastIndexOf('/'));
            var filename = file_name.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $(this).siblings('.file_label').text("--> "+filename);
        }
        
        $(this).closest(".file_style_wrapper").find("[data-remove-file]").css('display','block');
        $(this).closest(".file_style_wrapper").find("[data-remove-file]").attr('data-table','');
        
    });
	

    ////////////////////////////////////////////////////////////////////////////
    //tooltip
    $('.tooltip_style1').parent().hover(function(){
        $(this).find('.tooltip_style1').stop(true,true).fadeIn(200);
    },function(){
        $(this).find('.tooltip_style1').stop(true,true).fadeOut(200);
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    //Select With Select Style
    $('select[data-select-style]').each(function(){
        var label = $(this).find('option:selected').text();
        $(this).siblings('.select_label').text(label);
    });

    $('body').on('change','select[data-select-style]',function(){
        var label = $(this).find('option:selected').text();
        $(this).siblings('.select_label').text(label);
    });//change


    ////////////////////////////////////////////////////////////////////////////    
    // Scrolls Y
	$(".have_scroll_y").mCustomScrollbar({
		snapAmount:40,
		scrollButtons:{enable:true},
		keyboard:{scrollAmount:40},
		mouseWheel:{deltaFactor:40},
		scrollInertia:400,
		theme:"dark-thin",
		/*autoHideScrollbar:true*/
	});
        
	// Scrolls X
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
      
    ////////////////////////////////////////////////////////////////////////////////
	// CKEDITOR & CKFINDER
    $('[data-ckeditor]').each(function(){
        var $this = $(this);
            
        var fontsize = $this.attr('data-fontsize');
        var color = $this.attr('data-color');
        var image = $this.attr('data-image');
        var bold = $this.attr('data-bold');
        
        fontsize = (typeof fontsize !== typeof undefined && fontsize !== false)?fontsize:"not_set";
        color = (typeof color !== typeof undefined && color !== false)?color:"not_set";
        image = (typeof image !== typeof undefined && image !== false)?image:"not_set";
        bold = (typeof bold !== typeof undefined && bold !== false)?bold:"not_set";
        
        //fontsize
        var fontsize_config1 = fontsize_config2 ='';
        if(fontsize != 'not_set'){
            fontsize_config1 = "FontSize";
            
            if(fontsize != ''){
                var fontsize_arr = fontsize.split(",");
                for (var i = 0; i < fontsize_arr.length; i++) {
                    if(i != 0){fontsize_config2 += ";";}
                    fontsize_config2 += fontsize_arr[i]+"/"+fontsize_arr[i]+"px";
                }//for
            }//fontsize != ''
            else if(fontsize == ''){
                fontsize_config2 = '11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;';
            }
        }//fontsize
        
        //color
        var color_config1 = color_config2 ='';
        if(color != 'not_set'){
            color_config1 = "TextColor";
            
            if(color != ''){
                color_config2 = false
            }//fontsize != ''
            else if(color == ''){
                color_config2 = true;
            }
        }//color
        
        //image
        var image_config1 = '';
        if(image != 'not_set'){
            image_config1 = "Image";
        }//image
        
        //bold
        var bold_config1 = '';
        if(bold != 'not_set'){
            bold_config1 = "Bold";
        }//bold
        
        var ckeditor_config = { 
            customConfig: '',
            uiColor : '#eeeeee',
            extraPlugins : 'autogrow',
            autoGrow_onStartup : true,
            font_names: 'at1;'+'Tahoma;'+'B Nazanin;',
            contentsLangDirection: ($lang == 'fa')?'rtl':'ltr',
            language:'fa',
            colorButton_enableMore:color_config2,
            fontSize_sizes : fontsize_config2,
            toolbar:[
                { name: 'group1', items: [ 'BulletedList', '-', 'JustifyRight', 'JustifyCenter', 'JustifyLeft', 'JustifyBlock', '-', 'BidiRtl', 'BidiLtr'] },
                { name: 'group2', items: [ bold_config1] },
                { name: 'group3', items: [ 'Link', 'Unlink'] },
                { name: 'group4', items: [ fontsize_config1] },
                { name: 'group5', items: [ color_config1] },
                { name: 'group6', items: [ image_config1] }
            ]
        };
        if(color != 'not_set' && color != ''){
            ckeditor_config.colorButton_colors = color;
        }
        
        $this.ckeditor(ckeditor_config);
        CKFinder.setupCKEditor(null, $broot+'_plugins/ckfinder/');    
              
        // remove error in form validation
        $this.ckeditorGet().on('change', function(e) {   
            $this.closest('.editor_style').removeClass('error error_style1');
        });
    });//each ckeditor
    
    ////////////////////////////////////////////////////////////////////////////////
	// SORTABLE DRAG
    sortable_drag();

    
    ////////////////////////////////////////////////////////////////////////////
    // RESET FORM
    $("input[type=reset]").click(function(){
        var $this = $(this);
        var $form = $this.closest('form');
        $form.find(':input').not(':disabled').clearFields();
        $form.find('.select_style .select_label').text("-- انتخاب نمائید --");
        $form.find("[data-select-box]").trigger("chosen:updated");
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    // GO TO POS
    $('[data-goto-pos]').click(function(){
        var $this = $(this);
        var $target = $($this.attr('data-target'));
        var offset_x = $this.attr('data-x');
        var pos_x = $target.offset().top;
        offset_x = (typeof offset_x !== typeof undefined && offset_x !== false)?offset_x:0;
        
        var pos_final = parseInt(pos_x) + parseInt(offset_x);
        
        $('html,body').animate({'scrollTop':pos_final},300);
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    // TAB_STYLE1
    $('.tab_style1 [data-tab-nav]').click(function(e){
        var $this = $(this);
        var target_no = $this.attr('data-tab-nav');
        
        //reset 
        $this.closest('.tab_style1').find('[data-tab-nav]').removeClass('active');
        $this.closest('.tab_style1').find('[data-tab-content]').removeClass('active');
        
        //set
        $this.closest('.tab_style1').find('[data-tab-nav='+target_no+']').addClass('active');
        $this.closest('.tab_style1').find('[data-tab-content='+target_no+']').addClass('active');
    });
    
    
    ////////////////////////////////////////////////////////////////////////////
    // VIEW_MSG_ACTION
    $("[data-msg-action]").click(function(){ 
        var $this = $(this);  
        var modal_box_id = $this.attr('data-msg-action');        

        if(modal_box != ''){
            modal_box(modal_box_id);
            autosize.update($('textarea'));
        }
    });
    
    ////////////////////////////////////////////////////////////////////////////
    // CHANGE COLOR OF SELECT BASED ON SELECTED OPTION
    $('.select_style select:has(option[data-change-bgcolor])').each(function(){
        var $this = $(this);
        var option_color = $this.find("option:selected[data-change-bgcolor]").attr("data-change-bgcolor");
        if(option_color != ""){
            $this.closest(".select_style").css("background-color",option_color);
        }
    });
    
    
    
});//document ready
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	