<?php
function get_locale($lang)
{	
	if($lang){
		$lang = trim($lang);
		$lang = str_replace("/", "", $lang);
		$locale = str_replace("admin", "", $lang);
		if($locale == ""){
			$locale = App::getLocale();
		} else {
			App::setLocale($locale);
		}
	} else {
		$locale = App::getLocale();
	}
    session(['locali' => $locale]);
    return $locale;
}