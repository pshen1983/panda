<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/MessageUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( isset($_GET['u']) && is_numeric($_GET['u']) )
{
	if( !SecurityUtil::canUpdateProjectInfo() )
	{
		$_SESSION['_userDeleteResult'] = 3;
	}
	else if( !DatabaseUtil::isProjectMember($_GET['u'], $_SESSION['_project']->id) )
	{
		$_SESSION['_userDeleteResult'] = 2;
	}
	else
	{
		$r1 = DatabaseUtil::transferUserSubscriptions( $_SESSION['_project']->id, $_GET['u'], $_SESSION['_project']->creator );
		$r2 = DatabaseUtil::transferUserWorkitems( $_SESSION['_project']->id, $_GET['u'], $_SESSION['_project']->creator );
		$r3 = DatabaseUtil::deleteRelation($_GET['u'], $_SESSION['_project']->id);
		if( $r1 && $r2 && $r3 )
		{
			MessageUtil::sendRemoveProjectMessage( $_SESSION['_project']->id, $_GET['u'] );
			$_SESSION['_userDeleteResult'] = 0;
		}
		else $_SESSION['_userDeleteResult'] = 1;
	}
}

header( 'Location:../admin/index.php' );
exit;
?>
