<?php
include_once ("../utils/SearchDBUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");

if(!isset($_SESSION)) session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_proj_member_list = 'List of memebers in project : ';
}
else if($_SESSION['_language'] == 'zh') {
	$l_proj_member_list = '&#39033;&#30446;&#25104;&#21592;&#21015;&#34920; : ';
}

//=========================================================================================================

if( isset($_SESSION['_project']) && !empty($_SESSION['_project']) ) 
{
	$users = SearchDBUtil::getAllProjectMemebers($_SESSION['_project']->id);
	
	$count = 0;
	$output = "<div style='width:600px;'>
			   <div style='padding-top:10px;padding-bottom:20px;font-size:.9em;'><label>".$l_proj_member_list."<span style='color:#184D94;font-weight:bold'>".CommonUtil::truncate($_SESSION['_project']->title, 34)."</span></label></div>
			   <table>";
	foreach($users as $user)
	{
		$pic = DatabaseUtil::getUserPic($user['id']);
		$name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['firstname']." ".$user['lastname'];
		$output.= "<tr><td>
				   <div class='search_result_row'".(($count%2) ? " style='background-color:#F3F3F3;'" : "").">
				   <img style='vertical-align:middle;width:80px;height:80px;' src='".$pic."'/>
				   <label style='margin-left:10px;'><a class='user_link' href='../search/user_details.php?p1=".session_id()."&p2=".($user['id']*3-1)."'>".$name."</a></label>
				   </div></td>
				   </tr>"; 
		$count++;
	}
	$output.= "</table></div>";
	
	echo $output;
}
?>