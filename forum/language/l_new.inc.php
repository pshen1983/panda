<?php
if($_SESSION['_language'] == 'en') {
//--------------------------------------------------------------------- English
	$l_title = 'Forum | ProjNote';
	$l_top_new = 'New Topic';
	$l_fhome = 'Forum Home';
	$l_topic = 'Subject :';
	$l_top_size = ' characters remaining';
	$l_content = 'Content :';
	$l_submit = 'Submit';
	$l_cancel = 'Cancel';
}
else if($_SESSION['_language'] == 'zh') {
//--------------------------------------------------------------------- 简体中文
	$l_title = '论坛 | ProjNote';
	$l_top_new = '新建主题';
	$l_fhome = '论坛首页';
	$l_topic = '主题 ：';
	$l_top_size = '个字剩余';
	$l_content = '内容 ：';
	$l_submit = '确定';
	$l_cancel = '取消';
}
?>