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
		$l_proj_label = 'Project - ';	
		$l_comp_label = 'Project Component - ';
		$l_wp_label = 'Workpackage - ';
		$l_wi_label = 'Workitem - ';
	}
	else if($_SESSION['_language'] == 'zh') {	
		$l_proj_label = '&#39033;&#30446; &#8212; ';
		$l_comp_label = '&#39033;&#30446;&#32452; &#8212; ';
		$l_wp_label = '&#24037;&#20316;&#21253; &#8212; ';
		$l_wi_label = '&#24037;&#20316;&#39033; &#8212; ';
	}
	
	//=========================================================================================================
	
	if( isset($_GET['p_id']) && !empty($_GET['p_id']) && isset($_GET['s_id']) && !empty($_GET['s_id']) && 
		isset($_GET['c_id']) && isset($_GET['wp_id']) && isset($_GET['wi_id']) )
	{
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_GET['p_id']))
		{
			$trunLen = 43;
			$hasFile = false;
	
			$title = '';
			if(!empty($_GET['wi_id']))
			{
				$wi = DatabaseUtil::getWorkItem($_GET['wi_id']);
				$title = '<span class="work_level_span">'.$l_wi_label.'</span><a class="doc_bro_doc_link" href="../project/work_item.php?wi_id='.$_GET['wi_id'].'&sid='.$_GET['s_id'].'" title="'.str_replace('"', '&quot;', $wi['title']).'">'.CommonUtil::truncate($wi['title'], $trunLen).'</a>';
			}
			else if(!empty($_GET['wp_id']))
			{
				$wp = DatabaseUtil::getWorkPackage($_GET['wp_id']);
				$title = '<span class="work_level_span">'.$l_wp_label.'</span><a class="doc_bro_doc_link" href="../project/work_package.php?wp_id='.$_GET['wp_id'].'&sid='.$_GET['s_id'].'" title="'.str_replace('"', '&quot;', $wp['objective']).'">'.CommonUtil::truncate($wp['objective'], $trunLen).'</a>';
			}
			else if(!empty($_GET['c_id']))
			{
				$comp = DatabaseUtil::getComp($_GET['c_id']);
				$title = '<span class="work_level_span">'.$l_comp_label.'</span><a class="doc_bro_doc_link" href="../project/project_component.php?c_id='.$_GET['c_id'].'&sid='.$_GET['s_id'].'" title="'.str_replace('"', '&quot;', $comp['title']).'">'.CommonUtil::truncate($comp['title'], $trunLen).'</a>';
			}
			else
			{
				$proj = DatabaseUtil::getProj($_GET['p_id']);
				$title = '<span class="work_level_span">'.$l_proj_label.'</span><a class="doc_bro_doc_link" href="../project/index.php?p_id='.$_GET['p_id'].'&sid='.$_GET['s_id'].'" title="'.str_replace('"', '&quot;', $proj['title']).'">'.CommonUtil::truncate($proj['title'], $trunLen).'</a>';
			}
	
			$output = '<div><ul style="padding-left:20px;"><li>'.$title.'</li><ul style="padding-left:30px;">';
			$docs = DatabaseUtil::getProjDocList( $_GET['p_id'], 
												  empty($_GET['c_id']) ? null : $_GET['c_id'],
												  empty($_GET['wp_id']) ? null : $_GET['wp_id'],
												  empty($_GET['wi_id']) ? null : $_GET['wi_id'] );
	
			while ($doc = mysql_fetch_array($docs, MYSQL_ASSOC))
			{
				if(!$hasFile) $hasFile = true;
				$output.= "<li>- <a href='../utils/download.inc.php?f=".$doc['s_id']."&s_id=".(($_GET['p_id']+7)*3) ."&id=".$doc['id']."'>".CommonUtil::truncate($doc['title'], $trunLen)."</a></li>";
			}
	
			$output.= '</ul></ul></div>';
			echo $output;
		}
	}
}
else {
	echo 1;
}
?>