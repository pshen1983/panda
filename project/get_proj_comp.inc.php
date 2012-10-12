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
			$comp_id = null;
			if(isset($_GET['i']) && !empty($_GET['i']))	$comp_id = $_GET['i'];
	
			$comps = DatabaseUtil::getProjCompList($_GET['p']);
	
			while($comp = mysql_fetch_array($comps, MYSQL_ASSOC))
			{
				echo '<option value="'.$comp['id'].($comp_id==$comp['id'] ? '" SELECTED ' : '"').'>'.$comp['title'].'</option>';
			}
		}
	}
}
else {
	echo 1;
}
?>