<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Contact Us | ProjNote';

	$l_page_title = 'Contact Us';
	$l_web = "Web: ";
	$l_email = "Email: ";
	$l_weibo = "Weibo: ";

}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '联系我们 | ProjNote';

	$l_page_title = '联系我们';
	$l_web = "网址：";
	$l_email = "邮箱：";
	$l_weibo = "微博：";
}

//=========================================================================================================

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/about_layout.css' />
<script type='text/javascript' src="../js/common.js"></script>
<style type="text/css">li{line-height:2em;}</style>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once (isset($_SESSION['_userId'])) ? '../common/header_2.inc.php' : '../common/header_1.inc.php';?>
	<div id="page_body">
	<?php if(isset($_SESSION['_userId'])) {
		include_once '../common/path_nav.inc.php';
	?>
	<div id="top_link_saperator"></div>
	<?php }?>
	<div style="height:1px;"></div>
	<div class="about_body">
	<div class="about_head" style="">
	<label class="about_header"><?php echo $l_page_title?></label>
	</div>
	<div class="page_saperator"></div>
	<div class="about_detail">
	<ul>
	<li><?php echo $l_web?><a href="http://www.projnote.com/">www.projnote.com</a></li>
	<li><?php echo $l_email?>projnote@yahoo.com</li>
	<li><?php echo $l_weibo?><a target="_blank" href="http://www.weibo.com/u/2599566490">@ ProjNote</a></li>
	</ul>
	</div>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
