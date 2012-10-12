<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/CommonUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");

	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {	
		$l_wi_label = 'workitem';
		$l_wi_title = 'List documents in Workitem - ';
	}
	else if($_SESSION['_language'] == 'zh') {	
		$l_wi_label = '&#24037;&#20316;&#39033;';
		$l_wi_title = '&#24037;&#20316;&#39033;&#25991;&#26723;&#21015;&#34920; &#8212; ';
	}
	
	//=========================================================================================================
	
	if(isset($_GET['wp_id']) && !empty($_GET['wp_id']))
	{
		$wp = DatabaseUtil::getWorkPackage($_GET['wp_id']);
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $wp['proj_id']))
		{
			$trunLen = 31;
			$hasItem = false;
			$output = '';
	
			$wis = DatabaseUtil::getWorkPackageWorkItemList($_GET['wp_id']);
	
			while ($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
			{
				if(!$hasItem) $hasItem = true;
				$output.= '<li style="padding-left:20px;"><div><a id="a_wi'.$wi['id'].'" href="javascript:getDocs(\''.$wp['proj_id'].'\',\''.(isset($wp['comp_id'])?$wp['comp_id']:'').'\',\''.$_GET['wp_id'].'\',\''.$wi['id'].'\',\''.$wi['s_id'].'\',\'doc_bro_value\',\'a_wi'.$wi['id'].'\')" title="'.$l_wi_title.'\''.str_replace('"', '&quot;', $wi['title']).'\'">'.CommonUtil::truncate($wi['title'], $trunLen).' (<span class="doc_bro_wi">'.$l_wi_label.'</span>)</a></div></li>';
			}
	
			if($hasItem) echo $output;
		}
	}
}
else {
	echo 1;
}
?>