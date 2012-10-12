<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	
	if( isset($_POST['subject']) && !empty($_POST['subject']))
	{
		$subject = $_POST['subject'];
		$description = isset($_POST['description']) ? $_POST['description'] : null;
		DatabaseUtil::insertNotes($_SESSION['_userId'], $subject, $description);
	
		unset($_POST['subject']);
	}
	
	header( 'Location: ../message/selfnote.php' ) ;
	exit;
}
else {
	echo 1;
}
?>