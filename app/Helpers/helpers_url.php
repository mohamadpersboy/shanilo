<?php
function removeSpecialChar($input)
{
    $notAllowed = [' ', '!', '@', '#', '$', '%', '&', '*', '(', ')', '+',';',':',"'",'"','/'];
    $input = stripslashes($input);
    $input = trim($input);
    $input = str_replace($notAllowed, '-', $input);
    return $input;
}

function getClassForJs($class){
	$withOutApp = str_replace('App','',$class);
	$withOutSlash = str_replace('\\','',$withOutApp);
	$makeClass = "\\App\\\\".$withOutSlash; 
	return $makeClass;
}

function defaultImagesUrl($url=''){
    return url('/assets/admin/_images/default/'.$url);
}