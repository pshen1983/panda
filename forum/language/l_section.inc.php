<?php
if($_SESSION['_language'] == 'en') {
//--------------------------------------------------------------------- English
	$l_title = 'Forum Section | ProjNote';
	$l_section = 'ProjNote Forum Section';
	$l_forum_new = 'New Topic';
	$l_fhome = 'Forum Home';
	$l_header = 'Topics';
	$l_topic = 'Reply/View';
	$l_posts = 'Created';
	$l_unit_sec = ' sec ago';
	$l_unit_min = ' min ago';
	$l_unit_hur = ' hr ago';
	$l_unit_day = ' days ago';
	$l_lpost = 'Last reply';
}
else if($_SESSION['_language'] == 'zh') {
//--------------------------------------------------------------------- 简体中文
	$l_title = '论坛讨论区 | ProjNote';
	$l_section = 'ProjNote 讨论区';
	$l_forum_new = '新主题';
	$l_fhome = '论坛首页';
	$l_header = '主题';
	$l_topic = '回复/查看';
	$l_posts = '作者';
	$l_unit_sec = ' 秒钟前';
	$l_unit_min = ' 分钟前';
	$l_unit_hur = ' 小时前';
	$l_unit_day = ' 天前';
	$l_lpost = '最后回复';
}
?>