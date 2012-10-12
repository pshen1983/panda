<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/CommonUtil.php");

	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_0_proj = '<div class="none_found">0 Project found</div>';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_0_proj = '<div class="none_found">&#27809;&#26377;&#24050;&#23436;&#25104;&#30340;&#39033;&#30446;</div>';
	}
	
	//=========================================================================================================
	
	$hasProj = false;
	$projects = DatabaseUtil::getUserCompleteProjList($_SESSION['_userId']);
	
	$ind = 0;
	while($proj = mysql_fetch_array($projects, MYSQL_ASSOC))
	{
		if(!$hasProj) $hasProj = true;
		echo '<div class="right_nav_item'.($ind%2!=0 ? ' rightnavalter':'').'"><a class="right_hand_nav_proj_link" href=../project/index.php?p_id='. $proj["id"] .'&sid='. $proj["s_id"] .' title="'.str_replace('"', '&quot;', $proj["title"]).'">'. CommonUtil::truncate($proj["title"], 16) .'</a></div>'; 
		$ind++;
	}
	
	if(!$hasProj) echo "<div class='right_nav_item'>".$l_0_proj."</div>";
}
else {
	echo 1;
}
?>