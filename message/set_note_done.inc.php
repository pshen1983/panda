<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	
	if( isset($_GET['nid']) && !empty($_GET['nid']) ) {
		$stat = DatabaseUtil::getNoteDoneStatus($_GET['nid'], $_SESSION['_userId']);
	
		if ($stat == 'N') {
			DatabaseUtil::setNoteDoneStatus($_GET['nid'], $_SESSION['_userId'], 'Y');
		}
		else {
			DatabaseUtil::setNoteDoneStatus($_GET['nid'], $_SESSION['_userId'], 'N');
		}
	
		echo '0';
	}
}
else {
	echo 1;
}
?>