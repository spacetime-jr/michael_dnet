<?php

function checkPermission($str)
{
	$user = \Sentinel::getUser();
	if($user->hasAccess($str)){
		return true;
	} else {
		return false;
	}
}

?>