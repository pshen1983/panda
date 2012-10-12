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
		$l_wp_label = 'workpackage';
		$l_wi_label = 'workitem';
		$l_wp_title = 'List documents in Workpackage - ';
		$l_wi_title = 'List documents in Workitem - ';
	}
	else if($_SESSION['_language'] == 'zh') {	
		$l_wp_label = '&#24037;&#20316;&#21253;';
		$l_wi_label = '&#24037;&#20316;&#39033;';
	
		$l_wp_title = '&#24037;&#20316;&#21253;&#25991;&#26723;&#21015;&#34920; &#8212; ';
		$l_wi_title = '&#24037;&#20316;&#39033;&#25991;&#26723;&#21015;&#34920; &#8212; ';
	}
	
	//=========================================================================================================
	
	if(isset($_GET['c_id']) && !empty($_GET['c_id']))
	{
		$comp = DatabaseUtil::getComp($_GET['c_id']);
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $comp['p_id']))
		{
			$trunLen = 31;
			$hasItem = false;
			$output = '';
	
			$wps = DatabaseUtil::getCompWorkPackageList($_GET['c_id']);
	
			while ($wp = mysql_fetch_array($wps, MYSQL_ASSOC))
			{
				if(!$hasItem) $hasItem = true;
				$output.= '<li>
						  <div><a href="javascript:showHideDocBro(\'img_wp'.$wp['id'].'\', \'ul_wp'.$wp['id'].'\');javascript:getWps(\''.$wp['id'].'\', \'ul_wp'.$wp['id'].'\');"><img id="img_wp'.$wp['id'].'" class="collapse" src="../image/collapse.png"/></a><a id="a_wp'.$wp['id'].'" href="javascript:getDocs(\''.$comp['p_id'].'\',\''.$_GET['c_id'].'\',\''.$wp['id'].'\',\'\',\''.$wp['s_id'].'\',\'doc_bro_value\',\'a_wp'.$wp['id'].'\')" title="'.$l_wp_title.'\''.str_replace('"', '&quot;', $wp['objective']).'\'">'.CommonUtil::truncate($wp['objective'], $trunLen).' (<span class="doc_bro_wp">'.$l_wp_label.'</span>)</a></div>
						  <ul id="ul_wp'.$wp['id'].'" style="visibility:hidden;display:none;"></ul>
						  </li>';
			}
		
			$wis = DatabaseUtil::getComponentWorkItemList($_GET['c_id']);
	
			while ($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
			{
				if(!$hasItem) $hasItem = true;
				$output.= '<li style="padding-left:20px;">
						  <div><a id="a_wi'.$wi['id'].'" href="javascript:getDocs(\''.$comp['p_id'].'\',\''.$_GET['c_id'].'\',\''.(isset($wi['workpackage_id']) ? $wi['workpackage_id'] : '').'\',\''.$wi['id'].'\',\''.$wi['s_id'].'\',\'doc_bro_value\',\'a_wi'.$wi['id'].'\')" title="'.$l_wi_title.'\''.str_replace('"', '&quot;', $wi['title']).'\'">'.CommonUtil::truncate($wi['title'], $trunLen).' (<span class="doc_bro_wi">'.$l_wi_label.'</span>)</a></div>
						  <ul id="ul_wi'.$wi['id'].'" style="visibility:hidden;display:none;"></ul>
						  </li>';
			}
	
			if($hasItem) echo $output;
		}
	}
}
else {
	echo 1;
}
?>