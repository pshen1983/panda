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
			$wi_id = null;
			if(isset($_GET['i']) && !empty($_GET['i']))	$wi_id = $_GET['i'];
	
			$wis = DatabaseUtil::getComponentWorkItemList($_GET['c']);
	
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