<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/CommonUtil.php");
	include_once ("../utils/SecurityUtil.php");

	if( isset($_GET['p']) && is_numeric($_GET['p']) )
	{
		$user_id = null;
		if(isset($_GET['i']) && !empty($_GET['i']))	$user_id = $_GET['i'];
		if( DatabaseUtil::isProjectMember($_SESSION['_userId'], $_GET['p']) )
		{
			$users = CommonUtil::getProjUsers($_GET['p']);
			foreach($users as $uid => $user) echo '<option value="'.$uid.'" '.($user_id==$uid ? "SELECTED" : "").'>'.$user.'</option>';
		}
	}
}
else {
	echo 1;
}
?>