$(document).ready(function() {
	//////////////////////////////////////////////////////////////////////////////
    // global variables
	$froot = $('#froot').val();
	$broot = $('#broot').val();
	$curpage = $('#curpage').val(); 
	$lang = $('#lang').val(); 
	$lang_dir = ""; 
    $win_height = $(window).height();
    $token = $("meta[name='csrf-token']").attr('content');
});//document ready