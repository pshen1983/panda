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
		$l_comp_label = 'component';
		$l_wp_label = 'workpackage';
		$l_wi_label = 'workitem';
	
		$l_comp_title = 'List documents in Component - ';
		$l_wp_title = 'List documents in Workpackage - ';
		$l_wi_title = 'List documents in Workitem - ';
	}
	else if($_SESSION['_language'] == 'zh') {	
		$l_comp_label = '&#39033;&#30446;&#32452;';
		$l_wp_label = '&#24037;&#20316;&#21253;';
		$l_wi_label = '&#24037;&#20316;&#39033;';
	
		$l_comp_title = '&#39033;&#30446;&#32452;&#25991;&#26723;&#21015;&#34920; &#8212; ';
		$l_wp_title = '&#24037;&#20316;&#21253;&#25991;&#26723;&#21015;&#34920; &#8212; ';
		$l_wi_title = '&#24037;&#20316;&#39033;&#25991;&#26723;&#21015;&#34920; &#8212; ';
	}
	
	//=========================================================================================================
	
	if(isset($_GET['p_id']) && !empty($_GET['p_id']))
	{
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_GET['p_id']))
		{
			$trunLen = 37;
			$hasItem = false;
			$output = '';
	
			$comps = DatabaseUtil::getProjCompList($_GET['p_id']);
	
			while ($comp = mysql_fetch_array($comps, MYSQL_ASSOC))
			{
				if(!$hasItem) $hasItem = true;
				$output.= '<li>
						  <div><a href="javascript:showHideDocBro(\'img_comp'.$comp['id'].'\', \'ul_comp'.$comp['id'].'\');javascript:getComps(\''.$comp['id'].'\', \'ul_comp'.$comp['id'].'\');"><img id="img_comp'.$comp['id'].'" class="collapse" src="../image/collapse.png"/></a><a id="a_comp'.$comp['id'].'" href="javascript:getDocs(\''.$_GET['p_id'].'\',\''.$comp['id'].'\',\'\',\'\',\''.$comp['s_id'].'\',\'doc_bro_value\',\'a_comp'.$comp['id'].'\')" title="'.$l_comp_title.'\''.str_replace('"', '&quot;', $comp['title']).'\'">'.CommonUtil::truncate($comp['title'], $trunLen).' (<span class="doc_bro_comp">'.$l_comp_label.'</span>)</a></div>
						  <ul id="ul_comp'.$comp['id'].'" style="visibility:hidden;display:none;"></ul>
						  </li>';
			}
	
			$wps = DatabaseUtil::getProjWorkPackageList($_GET['p_id']);
	
			while ($wp = mysql_fetch_array($wps, MYSQL_ASSOC))
			{
				if(!$hasItem) $hasItem = true;
				$output.= '<li>
						  <div><a href="javascript:showHideDocBro(\'img_wp'.$wp['id'].'\', \'ul_wp'.$wp['id'].'\');javascript:getWps(\''.$wp['id'].'\', \'ul_wp'.$wp['id'].'\');"><img id="img_wp'.$wp['id'].'" class="collapse" src="../image/collapse.png"/></a><a id="a_wp'.$wp['id'].'" href="javascript:getDocs(\''.$_GET['p_id'].'\',\''.(isset($wp['comp_id']) ? $wp['comp_id'] : '').'\',\''.$wp['id'].'\',\'\',\''.$wp['s_id'].'\',\'doc_bro_value\',\'a_wp'.$wp['id'].'\')" title="'.$l_wp_title.'\''.str_replace('"', '&quot;', $wp['objective']).'\'">'.CommonUtil::truncate($wp['objective'], $trunLen).' (<span class="doc_bro_wp">'.$l_wp_label.'</span>)</a></div>
						  <ul id="ul_wp'.$wp['id'].'" style="visibility:hidden;display:none;"></ul>
						  </li>';
			}
		
			$wis = DatabaseUtil::getProjectWorkItemList($_GET['p_id']);
	
			while ($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
			{
				if(!$hasItem) $hasItem = true;
				$output.= '<li style="padding-left:20px;">
						  <div><a id="a_wi'.$wi['id'].'" href="javascript:getDocs(\''.$_GET['p_id'].'\',\''.(isset($wi['comp_id']) ? $wi['comp_id'] : '').'\',\''.(isset($wi['workpackage_id']) ? $wi['workpackage_id'] : '').'\',\''.$wi['id'].'\',\''.$wi['s_id'].'\',\'doc_bro_value\',\'a_wi'.$wi['id'].'\')" title="'.$l_wi_title.'\''.str_replace('"', '&quot;', $wi['title']).'\'">'.CommonUtil::truncate($wi['title'], $trunLen).' (<span class="doc_bro_wi">'.$l_wi_label.'</span>)</a></div>
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