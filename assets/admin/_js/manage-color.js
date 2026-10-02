$(document).ready(function(){
    //////////////////////////////////////////////
    // RUN COLOR PICKER
    if($("[data-color-picker]").length !=0){
        $("[data-color-picker]").colorPicker();
    }

    //////////////////////////////////////////////
    // SELECT COLOR
    $("[data-select-color-option]").change(function(){
        var $this = $(this);
        var $target = $this.closest("[data-select-color-wrapper]");
        var val = $this.val();

        $target.find("[data-select-color-item]").empty();//reset colors

        if(val){
            var val = val.toString();
            var val_array = val.split(",");
            for(var i=0;i<val_array.length;i++){
                var color_code = $this.find("option[value='"+val_array[i]+"']").attr("data-code");
                var color_name = $this.find("option[value='"+val_array[i]+"']").text();
                var color_id = $this.find("option[value='"+val_array[i]+"']").attr("value");
                $target.find("[data-select-color-item]").append("<li class='color_item' data-id='"+color_id+"'><span class='square' style='background-color:"+color_code+";'></span><span class='name ellipsis'>"+color_name+"</span></li>");
            }//for
        }//if
    });

    //////////////////////////////////////////////
    // VIEW COLORS
    $("[data-view-colors]").click(function(){
        modal_box('#view_colors');
    });
    //$('.modal .modal_scroll,.modal .modal_close').click(function(){hide_modal("#view_colors");});
    //$(".modal .window").click(function(e){e.stopPropagation();});

    //////////////////////////////////////////////
    // change cat1_id => load data
    $('#view_colors [data-main-select]').change(function(){
        var $this = $(this);
        var $form = $this.closest('form');

        // get values
        var id = $this.val().trim();
        var name = $this.find('option:selected').text().trim();
        var code = $this.find('option:selected').attr('data-code').trim();

        // add
        if(id == ''){
            reset_color('static');// reset data
        }//add

        // edit
        else{
            $form.removeClass('add').addClass('edit');//form class
            $form.find("[data-submit-remove]").attr('data-id',id);//id for remove
            $form.find('input[name=name]').val(name);//name
            $form.find('input[name=code]').val(code);
            $form.find('input[name=code]').css('background-color',code);
            //autosize.update($('.autosize'));//update autosize
        }//edit
    });

    ////////////////////////////////////////////////////////////////////////////
    // RESET BTN
    $("#view_colors [data-reset-color]").click(function(){
        reset_color('static_dynamic');
    });

    //////////////////////////////////////////////////////////////////////////////////////
    // ADD / EDIT
    $('#view_colors #frm_color').submit(function(e){
        e.preventDefault();
        var $form = $(this);

        // get values
        var id = $form.find('[data-main-select]').val();
        var name = $form.find('input[name=name]').val().trim();
        var code = $form.find('input[name=code]').val().trim();
        $form.find("[data-submit]").addClass('ajaxload_style1');

        var options = {
            url: "_includes/color-process.php",
            success: function(response) {
                var data = $.parseJSON(response);
                $form.find("[data-submit]").removeClass('ajaxload_style1');//hide loading

                if(data.error != ''){
                    $form.find('.result_report').removeClass('success').addClass('error').find('.text').text(data.error);
                }//nok
                else{
                    // add
                    if($form.is('.add')){
                        //result
                        $form.find('.result_report').removeClass('error').addClass('success').find('.text').text('عملیات افزودن با موفقیت انجام گردید');
                        //reset data
                        $form.find("[data-main-select]").append("<option value="+data.insert_id+" data-code="+code+">"+name+"</option>");//add to options
                        $form.find("[data-main-select] option").removeAttr('selected');
                        $form.find("[data-main-select] option:first").attr('selected','selected');
                        $form.find("[data-select-box]").trigger("chosen:updated");
                        reset_color('static');

                        $("[data-select-color-wrapper] [data-select-color-option]").append("<option value="+data.insert_id+" data-code="+code+">"+name+"</option>");//add to options
                        $("[data-select-color-wrapper] [data-select-box-check]").multiselect('reload');
                    }//add
                    // edit
                    else if($form.is('.edit')){
                        //result
                        $form.find('.result_report').removeClass('error').addClass('success').find('.text').text('عملیات ویرایش با موفقیت انجام گردید');
                        //reset data
                        $form.find("[data-main-select] option[value="+id+"]").text(name);//edit option
                        $form.find("[data-main-select] option[value="+id+"]").attr('data-code',code);//edit option
                        $form.find("[data-select-box]").trigger("chosen:updated");//update select*/

                        $("[data-select-color-wrapper] [data-select-color-option] option[value="+id+"]").text(name);
                        $("[data-select-color-wrapper] [data-select-color-option] option[value="+id+"]").attr('data-code',code);//edit option
                        $("[data-select-color-wrapper] [data-select-color-item] .color_item[data-id="+id+"] .name").text(name);
                        $("[data-select-color-wrapper] [data-select-color-item] .color_item[data-id="+id+"] .square").css('background-color',code);
                        $("[data-select-color-wrapper] [data-select-box-check]").multiselect('reload');
                    }//edit
                }//ok
            },//function success
            error: function(){
                $form.find("[data-submit]").removeClass('ajaxload_style1');
                $form.find('.result_report').removeClass('success').addClass('error').find('.text').text('مشکلی در ارتباط اینترنتی رخ داده است، مجددا تلاش نمائید');
            }
        }//options of ajax submit
        $form.ajaxSubmit(options);
    });

    //////////////////////////////////////////////////////////////////////////////////////
    // REMOVE
    $("#view_colors [data-submit-remove]").click(function(){
        var $this = $(this);
        var $form = $this.closest('form');
        var id = $this.attr('data-id');

        if(id != ''){
            $this.addClass('ajaxload_style1');
            $.ajax({
                url: "_includes/color-process.php",
                type: 'POST',
                data: {
                    id:id,
                    go_remove_color:''
                }
            })
                .always(function(){
                    $this.removeClass('ajaxload_style1');
                })
                .done(function(response){
                    if(response == 1){
                        //result
                        $form.find('.result_report').removeClass('error').addClass('success').find('.text').text('عملیات حذف با موفقیت انجام گردید');
                        //reset data
                        $form.find('[data-main-select]').find("option[value="+id+"]").remove();//remove option
                        $form.find("[data-main-select] option").removeAttr('selected');
                        $form.find("[data-main-select] option:first").attr('selected','selected');
                        $form.find("[data-main-select]").siblings(".select_label").text("-- ثبت رنگ جدید --");
                        $form.find("[data-main-select]").trigger("chosen:updated");//update select
                        reset_color('static');

                        $("[data-select-color-wrapper] [data-select-color-option] option[value='"+id+"']").remove();
                        $("[data-select-color-wrapper] [data-select-color-item] .color_item[data-id="+id+"]").remove();

                        $("[data-select-color-wrapper] [data-select-box-check]").multiselect('reload');
                    }//ok
                    else if(response == 0){
                        $form.find('.result_report').removeClass('success').addClass('error').find('.text').text('متاسفانه در انجام عملیات خطایی رخ داده است، مجددا تلاش نمائید.');
                    }//nok
                })
                .fail(function(){
                    $form.find('.result_report').removeClass('success').addClass('error').find('.text').text('مشکلی در ارتباط اینترنتی رخ داده است، مجددا تلاش نمائید');
                });
        }//if(id != '')
    });

});//document ready

////////////////////////////////////////////////////////////////////////////
// RESET color
function reset_color(type){
    var $form = $("#frm_color");
    var $reset_form_btn = $form.find("[data-reset-color]");

    // reset static
    if(type == 'static' || type == 'static_dynamic'){
        $form.removeClass('edit').addClass('add');//form class
        $form.find("[data-main-select] option").removeAttr('selected');
        $form.find("[data-main-select] option:first").attr('selected','selected');
        $form.find("[data-select-box]").trigger("chosen:updated");
        $form.find("[data-color-picker]").css("background-color","#fff");
        $form.find("[data-color-picker]").val("#fff");
        $form.find('.clear_field').clearFields();//clear fields
        //$form.find('[data-ckeditor]').val("");//clear fields for ck_editor
    }

    // reset dynamic
    if(type == 'dynamic' || type == 'static_dynamic'){
        $form.find('.result_report .text').empty();//reset result
        $reset_form_btn.addClass('ajaxload_style2');
        $.ajax({
            data: {
                default_text:'-- ثبت رنگ جدید --',
                go_reset_color:''
            },
            url: "_includes/color-process.php",
            type: "POST"
        })
            .done(function(response){
                $form.find("[data-main-select]").html(response);
                $form.find("[data-main-select] option").removeAttr('selected');
                $form.find("[data-main-select] option:first").attr('selected','selected');
                $form.find("[data-main-select]").siblings(".select_label").text("-- ثبت رنگ جدید --");
                //$form.find("[data-select-box]").trigger("chosen:updated");
            })
            .fail(function(){
                $form.find('.result_report').removeClass('success').addClass('error').find('.text').text('مشکلی در ارتباط اینترنتی رخ داده است، مجددا تلاش نمائید');
            })
            .always(function(){
                $reset_form_btn.removeClass('ajaxload_style2');
            });
    }//reset dynamic
}//reset_form1
