<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");
	
	if( isset($_GET['c']) && !empty($_GET['c']) )
	{
		$comp = DatabaseUtil::getComp($_GET['c']);
		if( DatabaseUtil::isProjectMember($_SESSION['_userId'], $comp['p_id']) )
		{
			$wp_id = null;
			if(isset($_GET['i']) && !empty($_GET['i']))	$wp_id = $_GET['i'];
	
			$wps = DatabaseUtil::getCompWorkPackageList($_GET['c']);
	
			while($wp = mysql_fetch_array($wps, MYSQL_ASSOC))
			{
				echo '<option value="'.$wp['id'].($wp_id==$wp['id'] ? '" SELECTED ' : '"').'>'.$wp['objective'].'</option>';
			}
		}
	}
}
else {
	echo 1;
}
?>