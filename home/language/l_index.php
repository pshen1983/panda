<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_title = 'Welcome | ProjNote';
	$l_welcome = 'Welcome';
	$l_you_have = '- You have ';
	$l_invis = 'Project Invitation(s)';
	$l_period = '.';
	$l_create_proj ='<span class="home_msg">&#9679;</span>You are currently NOT involved in project. Would you like to <a style="color:blue" href="../project/new_project.php">create</a> one?';
	$l_goto = 'Got to Workitem';
	$l_done = 'Done Workitem';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_title = '&#27426;&#36814;&#20351;&#29992; ProjNote';
	$l_welcome = '&#24744;&#22909;';
	$l_you_have = '&#8212; &#24744;&#26377;';
	$l_invis = '&#20010;&#39033;&#30446;&#36992;&#35831;';
	$l_period = '&#12290;';
	$l_create_proj ='<span class="home_msg">&#9679;</span>您现在没有参与在任何项目中。要 <a style="color:blue" href="../project/new_project.php">创建</a> 一个项目吗？';
	$l_goto = '前往工作项';
	$l_done = '完成工作项';
}
?>