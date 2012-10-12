<?php
if($_SESSION['_language'] == 'en') {
//--------------------------------------------------------------------- English
	$l_title = 'Forum | ProjNote';
	$l_forum = 'ProjNote Forum';
	$l_header = 'Sections';
	$l_topic = 'Topics';
	$l_posts = 'Posts';
	$l_lpost = 'Last post';
	$l_unit_sec = ' sec ago';
	$l_unit_min = ' min ago';
	$l_unit_hur = ' hr ago';
	$l_unit_day = ' days ago';
}
else if($_SESSION['_language'] == 'zh') {
//--------------------------------------------------------------------- 简体中文
	$l_title = '论坛 | ProjNote';
	$l_forum = 'ProjNote 论坛';
	$l_header = '讨论区';
	$l_topic = '主题';
	$l_posts = '回复';
	$l_lpost = '最后发布';
	$l_unit_sec = ' 秒钟前';
	$l_unit_min = ' 分钟前';
	$l_unit_hur = ' 小时前';
	$l_unit_day = ' 天前';
}
?>