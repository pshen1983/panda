<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'About Us | ProjNote';

	$l_page_title = 'About Us';
	$l_about_1 = 'ProjNote is a open platform to assist you to manage your work and project. Whether you are still in university or already join the work, ProjNote will help you to plan, design, schedule and manage your study and work. Whether you are working on your school project, working on a client project or doing a science research, ProjNote will always be your personal assistant to help you to communicate, share and cooperate better with your team.';

	$l_believe_t = 'We Believe';
	$l_believe_1 = 'Internet should make our work and lives easier.';
	$l_believe_2 = 'Deliver a simple and good user experience to make you success is our value.';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#20851;&#20110;&#25105;&#20204; | ProjNote';

	$l_page_title = '&#20851;&#20110;&#25105;&#20204;';
	$l_about_1 = 'ProjNote &#26159;&#19968;&#20010;&#24320;&#25918;&#30340;&#32593;&#32476;&#24179;&#21488;&#24110;&#21161;&#24744;&#31649;&#29702;&#24744;&#30340;&#24037;&#20316;&#21644;&#39033;&#30446;&#12290;&#26080;&#35770;&#24744;&#26159;&#22312;&#26657;&#23398;&#20064;&#25110;&#24050;&#27493;&#20837;&#32844;&#22330;&#65292;ProjNote &#37117;&#23558;&#24110;&#21161;&#24744;&#35745;&#21010;&#65292;&#35774;&#35745;&#65292;&#23433;&#25490;&#21644;&#31649;&#29702;&#24744;&#30340;&#23398;&#20064;&#21644;&#24037;&#20316;&#12290;&#26080;&#35770;&#24744;&#26159;&#22312;&#20570;&#27605;&#19994;&#35774;&#35745;&#65292;&#22312;&#20570;&#23458;&#25143;&#39033;&#30446;&#25110;&#26159;&#31185;&#23398;&#30740;&#31350;&#65292;ProjNote &#37117;&#23558;&#25104;&#20026;&#24744;&#26368;&#22909;&#30340;&#31169;&#20154;&#21161;&#29702;&#65292;&#24110;&#21161;&#24744;&#26356;&#22909;&#30340;&#19982;&#22242;&#38431;&#20132;&#27969;&#65292;&#20998;&#20139;&#19982;&#21512;&#20316;&#12290;';

	$l_believe_t = '&#25105;&#20204;&#30456;&#20449;';
	$l_believe_1 = '&#20114;&#32852;&#32593;&#24212;&#35813;&#26356;&#22909;&#30340;&#20415;&#25463;&#25105;&#20204;&#30340;&#29983;&#27963;&#21644;&#24037;&#20316;&#65307;';
	$l_believe_2 = '为您提供简单便捷的用户体验是我们的理念。';
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
	<div class="about_body">
	<div class="about_head" style="">
	<label class="about_header"><?php echo $l_page_title?></label>
	</div>
	<div class="page_saperator"></div>
	<div class="about_detail">
	<p><?php echo $l_about_1?></p>
	</div>
	<div class="weak_sap"></div>
	<div class="about_detail">
	<div style="padding-bottom:10px;"><label class="about_header" style="font-size:.8em;"><?php echo $l_believe_t?></label></div>
	<p><?php echo $l_believe_1?></p>
	<p><?php echo $l_believe_2?></p>
	</div>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
