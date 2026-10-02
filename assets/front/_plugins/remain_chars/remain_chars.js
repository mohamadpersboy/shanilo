// Remaining Character
(function($){
	$.fn.remaining_char = function(max_length){

		$(this).focusin(function(){
			
			$(this).after("<span class='remaining_char'></span>");
			char = $(this).val().length;
			if(char == 0){
				remain_char = max_length;
			}else{
				remain_char = max_length - char;
			}
			$(".remaining_char").text(remain_char).fadeIn(50);
			if(remain_char == 0){
				$(".remaining_char").css("color","#F00");
			}else{
				$(".remaining_char").css("color","#009700");
			}
			
		}).keyup(function(){
			
			char = $(this).val().length;
			if(char == 0){
				remain_char = max_length;
			}else{
				remain_char = max_length - char;
			}
			$(".remaining_char").text(remain_char).fadeIn(50);
			if(remain_char == 0){
				$(".remaining_char").css("color","#F00");
			}else{
				$(".remaining_char").css("color","#009700");
			}
		}).blur(function(){
			
			$(".remaining_char").remove();
			
		});
	}
	
})(jQuery);