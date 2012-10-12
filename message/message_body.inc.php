<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");

	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_empty = "(empty)";
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_empty = "&#65288;&#31354;&#65289;";
	}
	
	//=========================================================================================================
	
	if( isset($_GET['mid']) && !empty($_GET['mid']) && 
		isset($_GET['oid']) && !empty($_GET['oid']) ) {
		if($_GET['oid'] == $_SESSION['_userId'])
		{
			$message = DatabaseUtil::getMessageBody($_GET['mid'], $_GET['oid']);
			DatabaseUtil::setMessageRead($_GET['mid'], $_SESSION['_userId']);
			echo '<div class="invitation_body_message">
				  <label class="invitation_body_label">'.(empty($message) ? $l_empty : $message).'</label>
				  </div>';
		}
	}
}
else {
	echo 1;
}
?>