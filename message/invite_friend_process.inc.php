<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/CommonUtil.php");
	include_once ("../utils/MessageUtil.php");
	
	if( isset($_GET['e']) && !empty($_GET['e']) )
	{
		$result = 0; //success
	
		if( CommonUtil::validateEmailFormat($_GET['e']) )
		{
			if( !DatabaseUtil::emailExists($_GET['e']) )
			{
				try {
					$name = ($_SESSION['_language']=='zh') ? $_SESSION['_loginUser']->fullname_cn : $_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname;
					$from = '"'.$name.'" <'.$_SESSION['_loginUser']->login_email.">";
					MessageUtil::sendInvitation($from, $_GET['e']);
				}
				catch (Exception $e) {
					$result = 4; //server error
				}
			}
			else $result = 3; //already registered
		}
		else $result = 2; //wrong email format
	
		echo $result;
	}
}
else {
	echo 1;
}
?>