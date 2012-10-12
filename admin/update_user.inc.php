<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( isset($_GET['u']) && is_numeric($_GET['u'])  && 
	isset($_GET['r']) && !empty($_GET['r']) && 
	DatabaseUtil::isEmunValue(DatabaseUtil::$RELATION, $_GET['r']) )
{
	if( !SecurityUtil::canUpdateProjectInfo() )
	{
		$_SESSION['_userUpdateResult'] = 3;
	}
	else if( !DatabaseUtil::isProjectMember($_GET['u'], $_SESSION['_project']->id) )
	{
		$_SESSION['_userUpdateResult'] = 2;
	}
	else if( DatabaseUtil::updateRole($_GET['u'], $_SESSION['_project']->id, $_GET['r']) )
	{
		$_SESSION['_userUpdateResult'] = 0;
	}
	else {
		$_SESSION['_userUpdateResult'] = 1;
	}
}

header( 'Location:../admin/index.php' );
exit;
?>
