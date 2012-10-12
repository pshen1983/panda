<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Feedback | ProjNote';

	$l_fd = 'feedback';
	$l_to = '<span style="font-size:.8em;font-weight:normal;">(Email)</span>';
	$l_to_acc = 'Peng Shen (admin@projnote.com)';
	$l_contact = 'Contact '.$l_to.' :';
	$l_message_body = 'Message :';
	$l_send = 'Send Message';
	$l_submit = 'Send';
	$l_go_home = 'Go to Home';
	$l_success = 'v Your feedback has been send. Thank you for your support.';
	$l_err_1 = 'x System is temporarily busy, please try again later.';
	$l_err_2 = 'x Your Contact '.$l_to.' format is invalid, please try again.';
	$l_no_subj = 'No subject';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#24847;&#35265;&#21453;&#39304; | ProjNote';

	$l_fd = '&#24847;&#35265;&#21453;&#39304;';
	$l_to = '<span style="font-size:.8em;font-weight:normal;">(Email)</span>';
	$l_to_acc = '&#30003;&#33411; (admin@projnote.com)';
	$l_contact = '&#32852;&#31995;'.$l_to.'&#65306;';
	$l_message_body = '&#21453;&#39304;&#20869;&#23481;&#65306;';
	$l_send = '&#21457;&#36865;&#31449;&#20869;&#30701;&#20449;';
	$l_submit = '&#25552;&#20132;';
	$l_go_home = '&#22238;&#21040;&#20027;&#39029;';
	$l_success = 'v &#24744;&#30340;&#24314;&#35758;&#21644;&#24847;&#35265;&#24050;&#32463;&#21457;&#36865;&#65292;&#35874;&#35874;&#24744;&#23545;&#25105;&#20204;&#30340;&#25903;&#25345;&#12290;';
	$l_err_1 = 'x &#23545;&#19981;&#36215;&#65292;&#31995;&#32479;&#26242;&#26102;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_2 = 'x &#23545;&#19981;&#36215;&#65292;&#24744;&#30340;&#32852;&#31995;'.$l_to.'&#26684;&#24335;&#26377;&#35823;&#65292;&#35831;&#37325;&#35797;&#12290;';
	$l_no_subj = '&#65288;&#31354;&#65289;';
}

//=========================================================================================================

$result = -1;

if( isset($_POST['contact']) && !empty($_POST['contact']) &&
	isset($_POST['mess_body']) && !empty($_POST['mess_body']) )
{
	if(CommonUtil::validateEmailFormat($_POST['contact']))
	{
		if( DatabaseUtil::insertFeedback($_POST['contact'], $_POST['mess_body']) )
		{
			$_POST['contact'] = '';
			$_POST['mess_body'] = '';
			$result = 0;
		}
		else {
			$result = 1;
		}
	}
	else {
		$result = 2;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='css/about_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
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
	<div style="height:1px;"></div>
	<form class="fd_send_form" method="post" enctype="multipart/form-data" action="feedback.php" name="send_message" id="send_message" accept-charset="UTF-8">
	<div style="text-align:left;margin-left:40px;margin-bottom:5px;font-weight:bold;font-size:.9em;"><label><?php echo $l_fd?></label></div>
	<div class="page_saperator"></div>
	<table>
	<tr>
	<td></td>
	<td><div class="fd_mess_result"><label style="<?php echo ($result==0 ? 'color:green' : ($result!=-1 ? 'color:red' : ''))?>">
<?php 
	switch ($result)
	{
	case 0:
		echo $l_success;
		break;
	case 1:
		echo $l_err_1;
		break;
	case 2:
		echo $l_err_2;
		break;
	}
?></label></div></td>
	</tr>
	<tr>
	<td><label class="fd_disp_label" style="<?php if($result!=0&&isset($_POST['mess_body'])&&empty($_POST['mess_body'])) echo 'color:red;' ?>position:relative;top:-75px;"><?php echo $l_message_body?></label></td>
	<td><textarea id="mess_body" name="mess_body" class="fd_send"><?php if(isset($_POST['mess_body'])) echo $_POST['mess_body']?></textarea></td>
	</tr>
	<tr>
	<td><label class="fd_disp_label" <?php if($result!=0&&isset($_POST['contact'])&&empty($_POST['contact'])) echo 'style="color:red;"' ?>><?php echo $l_contact ?></label></td>
	<td><input id="contact" name="contact" class="fd_input_send" type="text" <?php 
	if( isset($_POST['contact']) )
		echo 'value="'.$_POST['contact'].'"';
	else if(isset($_SESSION['_loginUser']))
		echo 'value="'.$_SESSION['_loginUser']->login_email.'"'
?>/></td>
	</tr>
	<tr><td></td>
	<td><input type="submit" class="submitbn" value="<?php echo $l_submit?>"/></td>
	</tr>
	</table>
	</form>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>

