<?php 
include_once ("../utils/SearchDBUtil.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

unset($_SESSION['seach_input']);
unset($_SESSION['u_first']);
unset($_SESSION['u_last']);
unset($_SESSION['search_email']);

if ((isset($_POST['fname']) && !empty($_POST['fname'])) ||
	(isset($_POST['lname']) && !empty($_POST['lname'])) ||
	(isset($_POST['email']) && !empty($_POST['email'])) )
{
	$_SESSION['u_first'] = $_POST['fname'];
	$_SESSION['u_last'] = $_POST['lname'];
	$_SESSION['search_email'] = $_POST['email'];
}

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Search User | ProjNote';
	$l_first = 'First Name';
	$l_last = 'Last Name';
	$l_email = 'Email';
	$l_search = 'Search';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#29992;&#25143;&#25628;&#32034; | ProjNote';
	$l_first = '&#29992;&#25143;&#21517;&#31216;';
	$l_last = '&#29992;&#25143;&#22995;&#27663;';
	$l_email = '&#29992;&#25143;&#37038;&#31665;';
	$l_search = '搜索';
}

//=========================================================================================================

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/search_layout.css' />
<script type='text/javascript' src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div id="user_search_div">
	<form method="post" enctype="multipart/form-data" action="user.php" name="search_form" id="search_form" accept-charset="UTF-8">
	<table>
	<tr><td><label class="search_label"><?php echo $l_last?>:</label></td>
		<td><label class="search_label"><?php echo $l_first?>:</label></td>
		<td><label class="search_label"><?php echo $l_email?>:</label></td>
		<td></td></tr>
	<tr><td><input class="search_input" id="lname" name="lname" value="<?php echo isset($_SESSION['u_last'])?$_SESSION['u_last']:""; ?>"/></td>
		<td><input class="search_input" id="fname" name="fname" value="<?php echo isset($_SESSION['u_first'])?$_SESSION['u_first']:""; ?>"/></td>
		<td><input class="search_input" id="email" name="email" value="<?php echo isset($_SESSION['search_email'])?$_SESSION['search_email']:""; ?>"/></td>
		<td><input id="search_submit_button" class="search_submit_button" onmousedown="mousePress('search_submit_button')" onmouseup="mouseRelease('search_submit_button')" onmouseout="mouseRelease('search_submit_button')" type="submit" value="<?php echo $l_search;?>" /></td></tr>
	</table>
	</form>
	</div>
	<div id="search_result">
	<?php 
		$_GET['page']=0; 
		include_once 'user.inc.php'; 
		unset($_GET['page']);
	?>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
