<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_success = '(unset default project)';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_success = '&#65288;&#21462;&#28040;&#40664;&#35748;&#39033;&#30446;&#65289;';
	}
	
	//=========================================================================================================
	
	if(isset($_SESSION['_project']) && !empty($_SESSION['_project']))
	{
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_SESSION['_project']->id))
		{
			if(DatabaseUtil::updateUserDefaultProj($_SESSION['_userId'], $_SESSION['_project']->id))
			{
				$result = $l_success;
				$_SESSION['_loginUser']->proj_id = $_SESSION['_project']->id;
				$proj = DatabaseUtil::getProj($_SESSION['_project']->id);
			}
			else $result = 0; //system error
		}
		else $result = 0; //not a member.
	}
	else $result = 0; //no project select.

	echo $result;
}
else {
	echo 1;
}
?>