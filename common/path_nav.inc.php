<?php
include_once ("../utils/CommonUtil.php");
if(!isset($_SESSION)) session_start();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$home = 'Home';
	$project = 'project';
	$component = 'component';
	$workpackage = 'workpackage';
	$workitem = 'workitem';
}
else if($_SESSION['_language'] == 'zh') {
	$home = '&#20027;&#39029;';
	$project = '&#39033;&#30446;';
	$component = '&#39033;&#30446;&#32452;';
	$workpackage = '&#24037;&#20316;&#21253;';
	$workitem = '&#24037;&#20316;&#39033;';
}

if(isset($_SESSION['_userId']))
{
	$conj_char = '>';
	$home_link = '<a class="top_link_class" href="../home/index.php">'.$home.'</a>';
	$proj_link = '';
	$proj_comp = '';
	$proj_wp = '';
	$proj_wi = '';
	
	if(isset($_SESSION['_project']))
	{
		$proj = $_SESSION['_project'];
		$proj_link = ' <label id="top_link_conj">'. $conj_char .'</label> <a class="top_link_class" href="../project/index.php?p_id='.$proj->id.'&sid='.$proj->s_id.'" title="'. str_replace('"', '&quot;', $proj->title) .'">'. CommonUtil::truncate($proj->title, 16) .'</a><span class="path_ind">('.$project.')</span>';
	}

	if(isset($_SESSION['_component']))
	{
		$comp = $_SESSION['_component'];
		$proj_comp = ' <label id="top_link_conj">'. $conj_char .'</label> <a class="top_link_class" href="../project/project_component.php?c_id='.$comp->id.'&sid='.$comp->s_id.'" title="'. str_replace('"', '&quot;', $comp->title) .'">'. CommonUtil::truncate($comp->title, 16) .'</a><span class="path_ind">('.$component.')</span>';
	}

	if(isset($_SESSION['_workpackage']))
	{
		$wp = $_SESSION['_workpackage'];
		$proj_wp = ' <label id="top_link_conj">'. $conj_char .'</label> <a class="top_link_class" href="../project/work_package.php?wp_id='.$wp->id.'&sid='.$wp->s_id.'" title="'. str_replace('"', '&quot;', $wp->objective) .'">'. CommonUtil::truncate($wp->objective, 16) .'</a><span class="path_ind">('.$workpackage.')</span>';
	}

	if(isset($_SESSION['_workitem']))
	{
		$wi = $_SESSION['_workitem'];
		$proj_wi = ' <label id="top_link_conj">'. $conj_char .'</label> <a class="top_link_class" href="../project/work_item.php?wi_id='.$wi->id.'&sid='.$wi->s_id.'" title="'. str_replace('"', '&quot;', $wi->title) .'">'.$wi->title.'</a><span class="path_ind">('.$workitem.')</span>';
	}

	echo '<div id="top_link">'. $home_link . $proj_link . $proj_comp . $proj_wp . $proj_wi .'</div>'; 
}
?>