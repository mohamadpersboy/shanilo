$(document).ready(function(e) {

/////////////////////////////////////////////////////////////////////////
// regex
$.validator.addMethod("regex", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Provide a valid regex");



/////////////////////////////////////////////////////////////////////////
// image min_width
$.validator.addMethod("min_width", function(value, element, min_width) {
    
    var width = $(element).attr('data-width');
    if(width == 0){
        return true;
    }
    else if(width >= min_width){
        return true;
    }
    else if(width < min_width){
        return false;
    }
}, "error");


/////////////////////////////////////////////////////////////////////////
// image min_height
$.validator.addMethod("min_height", function(value, element, min_height) {
    
    var height = $(element).attr('data-height');
    if(height == 0){
        return true;
    }
    else if(height >= min_height){
        return true;
    }
    else if(height < min_height){
        return false;
    }
}, "error");


/////////////////////////////////////////////////////////////////////////
// image max_size
$.validator.addMethod("max_size", function(value, element, max_size) {
    if(typeof element.files[0] == 'undefined'){
        return true;
    }
    else{
        var size = Math.round(element.files[0].size / 1024);
        return (size <= max_size)?true:false;
    }
}, "error");


//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// GUIDE /////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
/*
# regex & notrequired  : regex:/^[0-9\s-]+$|^$/
# nohttp        : regex:/^((?!http:\/\/|https:\/\/).)*$/
# picture       : pic:{
                     extension: "jpg|jpeg|png|gif",
                     min_width:700,
                     min_height:370,
                     max_size:700
                 },
*/

/*
# dynamic input numbers :
$("#frm").validate({
    errorClass: "error_style1 error",
    ignore: '',
});
$("#frm input[name*='x']").each(function() {
    $(this).rules('add', {
        regex:/^((?!http:\/\/|https:\/\/).)*$/,
        messages: {
            regex:""
        }
    });
});


# require from group
$("#frm").validate({
	errorClass: "error_style1 error",
    ignore: '',
    
	rules: {
		pic: {
			require_from_group:[1,".valid_group1"],
            extension: "jpg|jpeg|png|gif",
			min_width:500,
			min_height:500,
            max_size:700
		},
		pic_old: {
			require_from_group:[1,".valid_group1"],
		},
	},
	
	messages: {
        pic: {
			require_from_group:"",
            extension: "فرمت تصویر معتبر نیست",
			min_width:"عرض عکس کمتر از اندازه مجاز است",
            min_height:"ارتفاع عکس کمتر از اندازه مجاز است",
            max_size:"حجم عکس بیشتر از اندازه مجاز است"
		},
		pic_old: {
			require_from_group:"",
		},
	},
    groups: {
        pic: "pic pic_old"
    }	
});
 */


/////////////////////////////////////////////////////////////////////////////
////////////////////////////// DEFAULTS /////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////
//frm_user_msg
$("#frm_user_msg").validate({
	errorClass: "error_style1 error",
    ignore:'',
    
	rules: {
		name: {
			required:true,
		},
		text: {
			required:true,
		},
        'msg_type[]': { 
            required: true, 
            minlength: 1 
        }
	},
	
	messages: {
		name: {
			required:"",
		},
		text: {
			required:"",
		},
        'msg_type[]': { 
            required: "حداقل یک آیتم را از میان روش های ارسال پیام انتخاب نمائید.", 
            minlength: "حداقل 1 آیتم را از میان روش های ارسال پیام انتخاب نمائید." 
        }
	},
});//frm_user_msg

/////////////////////////////////////////////////////////////////////////////
//frm_color
$("#frm_color").validate({
    errorClass: "error_style1 error",
    ignore: '',

    rules: {
        name:{
            required:true,
        },
        code:{
            required:true,
        },
    },

    messages: {
        name:{
            required:"",
        },
        code:{
            required:"",
        },
    }
});//frm_color

/////////////////////////////////////////////////////////////////////////////
//frm_login
$("#frm_login").validate({
	errorClass: "error_style1 error",
	rules: {
		username: {
			required:true,
		},
		pass: {
			required:true,
		},
		captcha: {
			required:true,
		}
	},
	
	messages: {
		username: {
			required:"",
		},	
		pass: {
			required:"",
		},
		captcha: {
			required:"",
		}
	}	
});//frm_login

//////////////////////////////
});//DOM READY

