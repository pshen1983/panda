<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");

	if( isset($_GET['w']) && !empty($_GET['w']) )
	{
		$wp = DatabaseUtil::getWorkPackage($_GET['w']);
		
		if( DatabaseUtil::isProjectMember($_SESSION['_userId'], $wp['proj_id']) )
		{
			$wi_id = null;
			if(isset($_GET['i']) && !empty($_GET['i']))	$wi_id = $_GET['i'];
	
			$wis = DatabaseUtil::getWorkPackageWorkItemList($_GET['w']);
	
			while($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
			{
				echo '<option value="'.$wi['id'].($wi_id==$wi['id'] ? '" SELECTED ' : '"').'>'.$wi['title'].'</option>';
			}
		}
	}
}
else {
	echo 1;
}
?>