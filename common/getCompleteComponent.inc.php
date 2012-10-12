<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	if( isset($_GET['pid']) && is_numeric($_GET['pid']) )
	{
		include_once ("../utils/DatabaseUtil.php");
		include_once ("../utils/SecurityUtil.php");
		include_once ("../utils/CommonUtil.php");

		//============================================= Language ==================================================

		if($_SESSION['_language'] == 'en') {
			$l_0_proj = '<div class="none_found">0 Component found</div>';
		}
		else if($_SESSION['_language'] == 'zh') {
			$l_0_proj = '<div class="none_found">没有已完成的项目组</div>';
		}

		//=========================================================================================================

		$hasProj = false;
		$components = DatabaseUtil::getCompleteComponent($_GET['pid']);

		$ind = 0;
		while($comp = mysql_fetch_array($components, MYSQL_ASSOC))
		{
			if(!$hasProj) $hasProj = true;
			echo '<div class="right_nav_item'.($ind%2!=0 ? ' rightnavalter':'').'"><a class="right_hand_nav_proj_link" href=../project/project_component.php?c_id='. $comp["id"] .'&sid='. $comp["s_id"] .' title="'.str_replace('"', '&quot;', $comp["title"]).'">'. CommonUtil::truncate($comp["title"], 16) .'</a></div>'; 
			$ind++;
		}

		if(!$hasProj) echo "<div class='right_nav_item'>".$l_0_proj."</div>";
	}
	else echo 2;
}
else echo 1;
?>