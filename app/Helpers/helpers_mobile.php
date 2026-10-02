<?php
function mobilePreOrder($preOrder)
{
	$preOrderArray = explode(',', mainSetting('mobilepreorder'));
	if(in_array($preOrder, $preOrderArray)){
		return true;
	} else {
		return false;
	}
}

