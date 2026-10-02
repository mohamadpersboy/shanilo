$(document).ready(function (e) {

	/////////////////////////////////////////////////////////////////////////
	// regex
	$.validator.addMethod("regex", function (value, element, regexpr) {
		return regexpr.test(value);
	}, "Provide a valid regex");


	/////////////////////////////////////////////////////////////////////////
	// image min_width
	$.validator.addMethod("min_width", function (value, element, min_width) {

		var width = $(element).attr('data-width');
		if (width == 0) {
			return true;
		}
		else if (width >= min_width) {
			return true;
		}
		else if (width < min_width) {
			return false;
		}
	}, "error");


	/////////////////////////////////////////////////////////////////////////
	// image min_height
	$.validator.addMethod("min_height", function (value, element, min_height) {

		var height = $(element).attr('data-height');
		if (height == 0) {
			return true;
		}
		else if (height >= min_height) {
			return true;
		}
		else if (height < min_height) {
			return false;
		}
	}, "error");


	/////////////////////////////////////////////////////////////////////////
	// image max_size
	$.validator.addMethod("max_size", function (value, element, max_size) {
		var size = Math.round(element.files[0].size / 1024);
		return (size <= max_size) ? true : false;
	}, "error");


	/////////////////////////////////////////////////////////////////////////////
	//valid form
	$("[data-valid-form]").each(function () {
		$(this).validate({
			errorClass: "error_style1 error",
			ignore: '',
		});
	});


	/* required */
	$("[data-valid-form] [data-valid-required]").each(function () {
		$(this).rules('add', {
			required: true,
			messages: {
				required: "الزامی است",
			}
		});
	});


	/* email format */
	$("[data-valid-form] [data-valid-email]").each(function () {
		$(this).rules('add', {
			email: true,
			messages: {
				email: "معتبر نیست",
			}
		});
	});


	/* extension */
	$("[data-valid-form] [data-valid-ext]").each(function () {
		var ext = $(this).attr("data-valid-ext");
		$(this).rules('add', {
			extension: ext,
			messages: {
				extension: "فرمت های مجاز: " + ext,
			}
		});
	});
	/*"gif|png|jpg|jpeg|rar|zip"*/


	/* repeat / confirm */
	$("[data-valid-form] [data-valid-repeat]").each(function () {
		var id = $(this).attr("data-valid-repeat");
		$(this).rules('add', {
			equalTo: '#' + id,
			messages: {
				equalTo: "با مقدار اولیه مغایرت دارد",
			}
		});
	});


	/* regex */
	$("[data-valid-form] [data-valid-regex]").each(function () {
		var regex = $(this).attr("data-valid-regex");
		$(this).rules('add', {
			regex: new RegExp(regex, "i"),
			messages: {
				regex: "معتبر نیست",
			}
		});
	});
	/*
	 ^[0-9]*$ ===> number

	 */

	/* size_img */
	$("[data-valid-form] [data-valid-size]").each(function () {
		var maxSize = $(this).attr("data-valid-size");
		$(this).rules('add', {
			max_size: maxSize, /*kb*/
			messages: {
				max_size: "حجم تصویر بیشتر از " + maxSize + " کیلو بایت نباشد",
			}
		});
	});

});//DOM READY