<?php
include_once ("../common/Objects.php");
include_once ("../utils/DatabaseUtil.php");
if(!isset($_SESSION)) session_start();

if( isset($_SESSION['_userId']) ) {
	$mess = DatabaseUtil::countUnreadMessages($_SESSION['_userId']);
	$invi = DatabaseUtil::countUserInvitations($_SESSION['_loginUser']->login_email);

	$atReturn = array("mess"=>$mess, "invi"=>$invi);
	echo json_encode($atReturn);
}
else {
	$atReturn = array("mess"=>-1, "invi"=>-1);
	echo json_encode($atReturn);
}
?>