<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = '&#9660;';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#9660;';
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
	<table>
<?php if($_SESSION['_language'] != 'zh') {?>
	<tr>
	<td><img class="follow_logo" src="../image/logo/facebook-logo.png" /></td>
	<td></td>
	</tr>
	<tr>
	<td><img class="follow_logo" src="../image/logo/linkedin-logo.png" /></td>
	<td></td>
	</tr>
	<tr>
	<td><img class="follow_logo" src="../image/logo/twitter-logo.png" /></td>
	<td></td>
	</tr>
<?php }
else {?>
	<tr>
	<td><img class="follow_logo" src="../image/logo/weibo-logo.png" /></td>
	<td></td>
	</tr>
	<tr>
	<td><img class="follow_logo" src="../image/logo/kaixin-logo.png" /></td>
	<td></td>
	</tr>
	<tr>
	<td><img class="follow_logo" src="../image/logo/renren-logo.png" /></td>
	<td></td>
	</tr>
<?php }?>
	</table>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
