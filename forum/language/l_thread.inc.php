<?php
if($_SESSION['_language'] == 'en') {
//--------------------------------------------------------------------- English
	$l_title = 'Forum | ProjNote';
	$l_thread = 'ProjNote Forum Thread';
	$l_fhome = 'Forum Home';
	$l_reply = 'Reply: ';
	$l_view = 'View: ';
	$l_post = 'Post: ';
	$l_rep_link = 'Reply';
	$l_quo_link = 'Quot';
	$l_unit_sec = ' sec ago';
	$l_unit_min = ' min ago';
	$l_unit_hur = ' hr ago';
	$l_unit_day = ' days ago';
	$l_rmsg = 'Reply to ';
	$l_submit = 'Submit';
	$l_log_rep = 'Login to Reply';
}
else if($_SESSION['_language'] == 'zh') {
//--------------------------------------------------------------------- 简体中文
	$l_title = '论坛 | ProjNote';
	$l_thread = 'ProjNote 论坛主题';
	$l_fhome = '论坛首页';
	$l_reply = '回复：';
	$l_view = '查看：';
	$l_post = '发表于：';
	$l_rep_link = '回复';
	$l_quo_link = '引用';
	$l_unit_sec = ' 秒钟前';
	$l_unit_min = ' 分钟前';
	$l_unit_hur = ' 小时前';
	$l_unit_day = ' 天前';
	$l_rmsg = '回复';
	$l_submit = '发表回复';
	$l_log_rep = '登录回复';
}
?>