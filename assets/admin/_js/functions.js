//////////////////////////////////////////////////////////////////////////////////////
//show modal
function show_modal(overlay){
    var overlay = (typeof overlay !== 'undefined' && overlay !== false)?overlay:".bg1";
    var opacity = (overlay == ".bg2")?"1":"0.3";
    $('.modal').fadeIn(200);
    $('.modal ' + overlay).css("opacity",opacity);
    $("[data-loading='"+overlay+"']").fadeIn(200);
    // $('body').css({'overflow':'hidden'});
}//show_modal

//////////////////////////////////////////////////////////////////////////////////////
//hide modal
function hide_modal(id){
    $('.modal').fadeOut(500);
    $('.modal .bg').css('opacity','0');
    $("[data-loading]").fadeOut(100);
    // $('body').css({'overflow':'auto'});


    setTimeout(function(){
        $('.modal_dynamic .window').remove();
        $('.modal_static '+id).css({'display':'none','opacity':'0'});
        //$('.modal video').get(0).pause();
    },500);
}//hide_modal

//////////////////////////////////////////////////////////////////////////////////////
//modal msg
function modal_msg(type,msg,btns){
    show_modal('.bg1');
    $('.modal_scroll .modal_dynamic').html("<div class='window'><i class='modal_close'>X</i><div class='modal_header "+type+" '><i class='modal_icon'></i></div><div class='modal_msg'><p>"+msg+"</p></div><div class='modal_action'><a href='#' class='modal_close_btn modal_btn'>خیر</a>"+btns+"</div></div>");
    $('.modal_scroll .modal_dynamic .window').css({'display':'inline-block'}).stop(true,true).fadeTo(500,1);

    $('.modal_close, .modal_close_btn').click(function(){
        hide_modal();
    });
}//modal_msg


//////////////////////////////////////////////////////////////////////////////////////
//modal box
function modal_box(id){
    show_modal(".bg1");
    $('.modal_static '+id).css({'display':'inline-block'}).stop(true,true).fadeTo(500,1,function(){
        $('.modal .bg.loading').css("opacity",0);
    });

    $('.modal_close, .modal_close_btn').click(function(){
        hide_modal(id);
    });
}//modal_box

//////////////////////////////////////////////////////////////////////////////////////
//show notif
function show_notif($title,$text,$type,$position,$time){
  switch($type){
    case 's':
      $color='green';
      $icon='ico-success';
      break;

    case 'w':
      $color='yellow';
      $icon='ico-warning';
      break;

    case 'e':
      $color='red';
      $icon='ico-error';
      break;

    case 'i':
      $color='blue';
      $icon='ico-info';
      break;

    case 'q':
      $color='blue';
      $icon='ico-question';
      break;

    default:
      $color=''
      $icon=''
  }

  switch($position){
    case 'br':
      $position='bottomRight';
      break;

    case 'bl':
      $position='bottomLeft';
      break;

    case 'bc':
      $position='bottomCenter';
      break;

    case 'tr':
      $position='topRight';
      break;

    case 'tl':
      $position='topLeft';
      break;

    case 'tc':
      $position='topCenter';
      break;

    case 'c':
      $position='center';
      break;

    default:
      $position='topCenter'
  }

  $time = ($time==0)?false:$time;

  iziToast.show({
    title:$title,
    message: $text,
    color: $color,
    position: $position,
    icon: $icon,
    timeout: $time,
    transitionIn:'bounceInDown',
  });
}//show_notif


//////////////////////////////////////////////////////////////////////////////////////
//show_result
function show_result($target,$msg,$type){
	$target.find('.result').removeClass('s e w i').addClass($type).fadeIn(300).find('.text').text($msg);
}//show_result


//////////////////////////////////////////////////////////////////////////////////////
//clean_reload
function clean_reload(){
	$('.clean_reload select option').removeAttr("selected");
	$('.clean_reload select option').first().prop("selected",true);
	$('.clean_reload input[type=text],textarea').val("");		
}


////////////////////////////////////////////////////////////////////////////
// ellipsis
function ellipsis(){
	$(".ellipsis").dotdotdot({
		ellipsis	: '... ',
		wrap		: 'word',
		fallbackToLetter: true,
		after		: null,
		watch		: window,	
		height		: null,
		tolerance	: 0,
		callback	: function( isTruncated, orgContent ) {},
		lastCharacter	: {
			remove		: [ ' ', ',', ';', '.', '!', '?' ],
			noEllipsis	: []
		}
	});// ellipsis
}


////////////////////////////////////////////////////////////////////////////////
// NUMBER FORMAT
function number_format(no){
    var num = no.toString().replace(/[^\d]/g,'');
    if(num.length>3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    return num;
}

////////////////////////////////////////////////////////////////////////////////
// NUMBER UNFORMAT
function number_unformat(no){
    var num = no.replace(/,/g,'');
    return num;
}

////////////////////////////////////////////////////////////////////////////////
// round_num
function round_num(no){
    return Math.round(no/100)*100;
}

////////////////////////////////////////////////////////////////////////////
// Preview Image Function
function preview($file,$target){
	//show image befor upload
	$($file).on("change", function(){
		var files = !!this.files ? this.files : [];
		if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
	
		if (/^image/.test( files[0].type)){ // only image file
			var reader = new FileReader(); // instance of the FileReader
			reader.readAsDataURL(files[0]); // read the local file
			reader.onloadend = function(){ // set image data as background of div
				$($target).html("<img src='"+this.result+"'>").show();
			}
		}
	});
}


////////////////////////////////////////////////////////////////////////////
// run_cropper
function run_cropper(element,x,y){
	$(element+' .cropper_holder img').cropper({
		aspectRatio: x / y,
		autoCropArea: .9,
		viewMode: 1,
		dragMode:'move',
		preview:$(element+' .cropper_preview'),
		toggleDragModeOnDblclick:false,
		crop: function(e) {
			// Output the result data for cropping image.
			var x = e.x;
			var y = e.y;
			var w = e.width;
			var h = e.height;
			$(element+' [data-crop-x]').val(x);
			$(element+' [data-crop-y]').val(y);
			$(element+' [data-crop-w]').val(w);
			$(element+' [data-crop-h]').val(h);
		},
	});
}//run_cropper


////////////////////////////////////////////////////////////////////////////
// change_status
function change_status($table,$id,$field,$val){
	$.post("_includes/ajax-process.php",{
		go_change_status:"",
		table:$table,
		id:$id,
		field:$field,
		val:$val
	},function(response){
		if(response == 1){
			show_notif('','عملیات با موفقیت انجام گردید','s',5000);
		}else{
			show_notif('خطا','خطایی در انجام عملیات رخ داده است لطفا مجددا تلاش نمایید...','e',5000);
		}
	});
}


////////////////////////////////////////////////////////////////////////////
//script loader
function run_player(){
    $("[data-video-player][data-file]").each(function(){
        var id = $(this).attr('id');
        var image = $(this).attr('data-image');
        var file = $(this).attr('data-file');
        var water_mark = $(this).data('watermark');
        var width = ($(this)[0].hasAttribute('data-width'))?$(this).attr('data-width'):"720px";
        var height = ($(this)[0].hasAttribute('data-height'))?$(this).attr('data-height'):"480px";
        
        var playerInstance = jwplayer(id);
        playerInstance.setup({
            "key":"6kq/lcc/RRKQyGAYuw0kE4OtH/L16qeOBSa0kg==",
            "file":file,
            "image":image,
            "logo": {
                "file": water_mark,
                "hide": false,
                "link": false,
                "margin": "15",
                "position": "top-right"
            },
            "skin": {
                "active": "#4bb5e6",
                "name": "vapor"
            },
            "preload": "auto",
            "width": width,
            "height": height,
                
            /*"sources": [
                {
                  "duration": 10,
                  "file": "http://content.jwplatform.com/videos/zAIVl7Hp-ZayWiOLi.mp4",
                  "height": 1080,
                  "label": "1080p",
                  "type": "video/mp4",
                  "width": 1920
                },
                {
                  "duration": 10,
                  "file": "http://content.jwplatform.com/videos/zAIVl7Hp-yuijXohQ.mp4",
                  "height": 270,
                  "label": "270p",
                  "type": "video/mp4",
                  "width": 480
                },
                {
                  "duration": 10,
                  "file": "http://content.jwplatform.com/videos/zAIVl7Hp-haoWY2lW.mp4",
                  "height": 406,
                  "label": "406p",
                  "type": "video/mp4",
                  "width": 720
                },
                {
                  "duration": 10,
                  "file": "http://content.jwplatform.com/videos/zAIVl7Hp-jbOpP6uO.mp4",
                  "height": 720,
                  "label": "720p",
                  "type": "video/mp4",
                  "width": 1280
                },
            ],*/
        });
    });//each
}// run_player


////////////////////////////////////////////////////////////////////////////
//script loader
var Loader = function () { }
Loader.prototype = {
    require: function (scripts, callback) {
        this.loadCount      = 0;
        this.totalRequired  = scripts.length;
        this.callback       = callback;

        for (var i = 0; i < scripts.length; i++) {
            this.writeScript(scripts[i]);
        }
    },
    loaded: function (evt) {
        this.loadCount++;

        if (this.loadCount == this.totalRequired && typeof this.callback == 'function') this.callback.call();
    },
    writeScript: function (src) {
        var self = this;
        var s = document.createElement('script');
        s.type = "text/javascript";
        s.async = true;
        s.src = src;
        s.addEventListener('load', function (e) { self.loaded(e); }, false);
        var head = document.getElementsByTagName('head')[0];
        head.appendChild(s);
    }
}//script loader


////////////////////////////////////////////////////////////////////////////
//date_picker
function date_picker($element){
    Calendar.setup({
        inputField: $element,
        button: 'date_btn',
        ifFormat: '%Y/%m/%d',
        dateType: 'jalali'
    });
    $("input#"+$element).keypress(function(e){
        e.preventDefault();
    });	
}//date_picker

////////////////////////////////////////////////////////////////////////////////
// SORTABLE DRAG
function sortable_drag(){
    $("[data-sortable-drag]").each(function(){
        $(this).sortable({
            handle:'[data-sort-handle]',
            axis: 'y',
            helper: function(e, tr){
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index){
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function (event, ui) {
                var table = $(this).attr('data-table');
                var data = $(this).sortable('serialize');
                data += "&go_sortable_drag=&table="+table;
                
                ui.item.find("[data-sort-handle]").addClass('ajaxload_style2');
                
                $.ajax({
                    url: '_includes/ajax-process.php',
                    type: 'POST',
                    data: data
                }).always(function(){
                    ui.item.find("[data-sort-handle]").removeClass('ajaxload_style2');
                }).fail(function(){
                    show_notif("خطا","مشکلی در ارتباط اینترنتی رخ داده است، پس از اطمینان از صحت ارتباط اینترنت، مجددا تلاش نمائید...","e",0);
                });
            }
        });
    });
}

////////////////////////////////////////////////////////////////////////////////
// equal height 
function equal_height(n){
    for(var i=1;i<=n;i++){
        var min_height = 0;
        $("[data-equalheight="+i+"]").each(function(){
            var this_height = parseInt($(this).css('height'));
            //var this_height = parseInt($(this).height());
            //var this_height = $(this).height();
            if(this_height > min_height){
                min_height = this_height;
            }
        });
        $("[data-equalheight="+i+"]").css('height',min_height);
    }//for
}