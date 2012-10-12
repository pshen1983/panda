<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");

	if( isset($_GET['p']) && !empty($_GET['p']) )
	{
		if( DatabaseUtil::isProjectMember($_SESSION['_userId'], $_GET['p']) )
		{
			$wp_id = null;
			$wp_id = (isset($_GET['i']) && !empty($_GET['i'])) ? $_GET['i'] : "";
	
			$wps = DatabaseUtil::getProjWorkPackageList($_GET['p']);
	
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