var errorClass = '.error_style1.error', errorClassSeparate = 'error_style1 error';

var Atlasweb = function () {
    var $this = this;
    this.customErrorMessages = {
        404: "صفحه مورد نظر یافت نشد.",
        405: "متد استفاده شده غیر مجاز است.",
        500: "خطایی سمت سرور رخ داد.",
        401: "درخواست غیر مجاز است.",
        403: "شما مجاز به انجام این کار نمی باشید.",
        200: "داده های دریافتی معتبر نمی باشد."
    };
    this.setAjaxOptions = function (form) {
        var url = $(form).attr('action'), method = $(form).attr('method'), data = new FormData(form),
            options = {
                type: method,
                url: url,
                data: data,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(form).clearFormErrors();
                    if ($(form).data('block')) {
                        $this.block($($(form).data('block')));
                    } else {
                        $this.block($(form));
                    }
                },
                success: function (response) {
                    $this.runOnSuccessForm($(form), response);
                    if($(form).attr('id')!=="frm_delete"){
                        $('[class^="modal"]').find('.close_btn').trigger('click');
                    }
                },
                error: function (error) {
                    $this.runOnErrorForm($(form), error);
                },
                complete: function () {
                    if ($(form).data('block')) {
                        $this.unblock($($(form).data('block')));
                    } else {
                        $this.unblock($(form));
                    }
                    $(form).clearFormSecurityInputs();
                }
            };
        if ($(form).data('type')) {
            options.dataType = $(form).data('type');
        }
        return options;
    };
    this.setToastrOptions = function () {
        return {
            "closeButton": true,
            "rtl": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "5000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    };
    this.setBlockUIOptions = function (element) {
        if (element) {
            return {
                // message displayed when blocking (use null for no message)
                message: '<h1><img src="_images/loading/loader6.gif"></h1>',

                css: {
                    width:"100%",
                    padding: 0,
                    textAlign: 'center',
                    color: '#000',
                    border: 'none',
                    backgroundColor: 'transparent',
                    cursor: 'wait',
                    opacity: 1,
                    margin: '0 auto'
                },


                // styles for the overlay
                overlayCSS: {
                    backgroundColor: '#FFFFFF',
                    opacity: 0.8,
                    cursor: 'wait'
                }
            }
        }
        return {
            // message displayed when blocking (use null for no message)
            message: '<h1><img src="_images/loading/loader6.gif" class="img_loader"></h1>',

            css: {
                padding: 0,
                margin: 0,
                width: '100%',
                top: '30%',
                left: '35%',
                textAlign: 'center',
                color: '#000',
                border: 'none',
                backgroundColor: 'transparent',
                cursor: 'wait',
                opacity: 0.3
            },


            // styles for the overlay
            overlayCSS: {
                backgroundColor: '#FFFFFF',
                opacity: 0.8,
                cursor: 'wait'
            }
        };
    };
    this.sendFormRequest = function (form) {
        $.ajax($this.setAjaxOptions(form));
    };
    this.block = function (element) {
        if (element) {
            element.block($this.setBlockUIOptions(element));
        } else {
            $.blockUI($this.setBlockUIOptions());
        }
    };
    this.unblock = function (element) {
        if (element) {
            element.unblock();
        } else {
            $.unblockUI();
        }
    };
    this.blockButton=function (button) {
      button.attr('disabled',true).css('cursor','progress').animate({
          'opacity':"0.3"
      });
    };
    this.unblockButton=function (button) {
        button.attr('disabled',false).css('cursor','pointer').animate({
            'opacity':"1"
        });
    };
    this.runOnSuccessForm = function (form, response) {
        if (form.data('clear')) {
            form.clearForm();
        }
        if (response.url) {
            form.data('on-success', 'redirect');
        }
        switch (form.data('on-success')) {
            case 'redirect':
                $(location).attr('href', response.url);
                break;
            case 'alert-message':
                toastr.options = $this.setToastrOptions();
                toastr[response.type](response.message, response.header);
                break;
            case 'popup-message':
                swal({
                    title: response.header,
                    text: response.message,
                    icon: response.type,
                    buttons: {
                        confirm: 'متوجه شدم'
                    }
                });
                break;
            case 'inline-message':
                //
                break;
            case 'add-node':
                var parent=$(form.data('parent'));
                if($(response.view).attr('id').includes('galleryImage')){
                    parent.find('.triggerer').before(response.view);
                }else{
                    parent.prepend(response.view);
                }
                break;
            case 'delete-node':
                if (typeof response.deletedItem === 'object') {
                    $.each(response.deletedItem, function (index, deletedItem) {
                        $(deletedItem).fadeOut(200);
                    })
                } else {
                    $(response.deletedItem).fadeOut(200);
                }
                break;
            case 'update-node':
                var view = $(response.view).html();
                $(response.updatedItem).html(view);
                var top_sp = $(response.updatedItem).offset().top;
                $('html,body').animate({scrollTop: top_sp}, 800);
                break;
            case 'hide-update':
                  $(form.data('field')).text(response.field);
                  form.parent().fadeOut(200);
                  break;
        }
    };
    this.runOnErrorForm = function (form, error) {
        switch (form.data('on-error')) {
            case 'inline-message':
                $this.showInlineErrorMessages(form, error);
                break;
            case 'alert-message':
                $this.showAlertErrorMessages(error);
                break;
            case 'hide-alert-message':
                $this.showAlertErrorMessages(error);
                form.parent().fadeOut(200);
                break;
        }
    };
    this.showInlineErrorMessages = function (form, error) {
        if (typeof error === "object") {
            if (!error.responseJSON || error.responseJSON == undefined || error.responseJSON.errors == undefined) {
                $this.showAlertErrorMessages(error);
                return false;
            }
            var errors = error.responseJSON.errors;

            $.each(errors, function (input, error) {
                if (input.indexOf(".") >= 0) {
                    input = input.replace(/\.+[0-10]/, "");
                    var element = form.find('*[name^="' + input + '"]');
                    element.removeClass('loading');
                    if (element.length > 0) {
                        element.addClass(errorClassSeparate).after('<label class="' + errorClassSeparate + '">' + error[0] + '</label>');
                    }
                } else {
                    form.find('*[name="' + input + '"]').removeClass('loading').addClass(errorClassSeparate).before('<label class="' + errorClassSeparate + '">' + error[0] + '</label>');
                }
            });
        } else {
            $this.showAlertErrorMessages(error);
        }
    };
    this.showAlertErrorMessages = function (error) {
        if (typeof error === "object") {
            toastr.options = $this.setToastrOptions();
            if (!error.responseJSON || error.responseJSON == undefined || error.responseJSON.errors == undefined) {
                console.log(error);
                toastr.error($this.customErrorMessages[error.status], error.status);
                return false;
            }
            var errors = error.responseJSON.errors;
            console.log(errors);
            $.each(errors, function (input, error) {
                toastr.error(error[0]);
            });
        }
    };
    this.priceFormat = function (input, event) {
        // skip for arrow keys
        if (event && (event.which >= 37 && event.which <= 40)) return;

        // format number
        input.val(function (index, value) {
            return $this.calculatePriceFormat(value)
        });
    };
    this.calculatePriceFormat = function (price) {
        return price.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };
    this.deleteDropZoneFile = function (file) {
        if (file.status === 'error') {
            $(file.previewElement).fadeOut();
            return false;
        }
        var url = file.deleteUrl ? file.deleteUrl : JSON.parse(file.xhr.response).deleteUrl;
        $.getJSON(url, function (response) {
            $(file.previewElement).fadeOut();
        }).fail(function (error) {
            $this.showAlertErrorMessages(error);
        });
    };
    this.changeCartCount = function (input) {
        var url = input.data('url'), data = {
            count: input.val(),
            _token: $("input[name='_token']").val()
        };

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function () {
                $this.block(input.closest('td'));
            },
            success: function (response) {
                input.val(response.count);
                input.siblings('.nav.plus').attr('data-status', response.status);
                input.closest('tr').find('.sum_price > span').html(response.total_price);
                $('.cart_price').html(response.cart_price);
            }, error: function (error) {
                $this.showAlertErrorMessages(error);
            }, complete: function () {
                $this.unblock(input.closest('td'));
            }
        });
    };
    this.updateCartFields = function (input) {
        var url = input.data('url'), blockItem = $(input.data('block')), value = input.val(), data = {
            value: value,
            _token: $('input[name="_token"]').val()
        };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function () {
                $this.block(blockItem);
            }, success: function (response) {
                console.log(response);
            }, error: function (error) {
                $this.showAlertErrorMessages(error);
            }, complete: function () {
                $this.unblock(blockItem);
            }
        });
    };
    this.toggleToList = function (button) {
        var url = button.data('url');
        button.toggleClass('added');
        $.getJSON(url, function (response) {
            if (response.url) {
                $(location).attr('href', response.url);
                return false;
            }
            console.log(response);
            if (typeof response.itemsCount == 'object') {
                $.each(response.itemsCount, function (id, count) {
                    $(id).text(count);
                    if (count <= 0) {
                        $(id).addClass('disnone');
                    } else {
                        $(id).removeClass('disnone');
                    }
                });
            }
            if (button.attr('data-original-title')) {
                button.attr('data-original-title', response.toolTipText);
            } else {
                button.find('span').text(response.toolTipText);
            }

            $(response.listId).html(response.view);

        }).fail(function (error) {
            $this.showAlertErrorMessages(error);
        })
    };
    this.singleFieldValidation = function (field) {
        var url = field.data('url'), data = {
            '_token': $('input[name="_token"]').val(),
            'table': field.data('table'),
            'field': field.data('field'),
            'rules': field.data('rules'),
            'data': {}
        };
        data['data'][field.data('field')] = field.val();
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: data,
            success: function (response) {
                field.removeClass('loading error_style1 error').addClass('checked');
                field.parent().find('label.error_style1.error').remove();
            },
            error: function (error) {
                if (error.status === 422) {
                    field.removeClass('loading checked ').addClass('error_style1 error');
                } else {
                    $this.showAlertErrorMessages(error);
                }
            }
        });
    };
    /*##################################################*/
    //SPECIFIC FOR THIS PROJECT
    //Don't forget to remove this part in other new project.
    /*##################################################*/

    /*##################################################*/
    //SPECIFIC FOR THIS PROJECT ENDS
    /*##################################################*/
};
$.fn.clearForm = function () {
    this.find('textarea,input[type="text"],input[type="password"],input[type="email"],input[type="file"],select').val('');
    this.clearFormErrors();
    if (this.find('select.beautyselect').length) {
        $('select.beautyselect').niceSelect('update');
    }
    this.find('.cropper_preview').html("");
    this.find('.cropper_holder').html("");
    this.find('input[name^="cropper"]').html("");
};
$.fn.clearFormErrors = function () {
    this.find('label' + errorClass).remove();
    this.find('*' + errorClass).removeClass(errorClassSeparate);
};
$.fn.clearFormSecurityInputs = function () {
    this.find('input[type="password"]').val('');
};
$.fn.exist = function () {
    return this.length > 0;
};