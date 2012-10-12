<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_success = 'Follow Workitem';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_success = '&#20851;&#27880;&#27492;&#24037;&#20316;&#39033;';
	}
	
	//=========================================================================================================
	
	if(isset($_GET['w']) && !empty($_GET['w']))
	{
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_SESSION['_project']->id))
		{
			$work_id = ($_GET['w']-7)/3;
			if( DatabaseUtil::isUserSubscribedToWorkitem($work_id, $_SESSION['_userId']) &&
				DatabaseUtil::doesWorkitemExistInProject($work_id, $_SESSION['_project']->id) )
			{
				if (DatabaseUtil::removeSubscription($work_id, $_SESSION['_userId']))
					$result = $l_success;
				else $result = 0;
			}
			else $result = 0; //pre-condition fail.
		}
		else $result = 0; //not a member.
	}
	else $result = 0; //no workitem input.
	
	echo $result;
}
else {
	echo 1;
}
?>