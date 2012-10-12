<?php
include_once ('../utils/DatabaseUtil.php');
include_once ('../utils/MessageUtil.php');
include_once ('../utils/SessionUtil.php');

session_start();
include_once 'language/l_quit_project.inc.php';

if( isset($_SESSION['_userId']) )
{
	if( isset($_POST['pid']) && is_numeric($_POST['pid']) && isset($_POST['sid']) && !empty($_POST['sid']) )
	{
		$proj = DatabaseUtil::getProjSid( $_POST['pid'], $_POST['sid'] );
		if( isset($proj) && $proj )
		{
			if( $proj['creator']!=$_SESSION['_userId'] )
			{
				if( DatabaseUtil::isProjectMember($_SESSION['_userId'], $_POST['pid']) )
				{
					$r1 = DatabaseUtil::transferUserSubscriptions( $_POST['pid'], $_SESSION['_userId'], $proj['creator'] );
					$r2 = DatabaseUtil::transferUserWorkitems( $_POST['pid'], $_SESSION['_userId'], $proj['creator'] );
					$r3 = DatabaseUtil::deleteRelation( $_SESSION['_userId'], $_POST['pid'] );
					if( $r1 && $r2 && $r3 )
					{
						MessageUtil::sendQuitProjectMessage( $_POST['pid'], $proj['creator'] );
						unset($_SESSION['_oProjList']);
						SessionUtil::clearProjectSession();
						echo 0;
					}
					else echo $l_err_6; // database problem
				}
				else echo $l_err_5; // not a project member
			}
			else echo $l_err_4; // is project owner
		}
		else echo $l_err_3; // no such a project
	}
	else echo $l_err_2; // not enough parameter
}
else echo 1; // not logged in