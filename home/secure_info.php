<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = '';
	$l_back_prof = 'Back to My Profile';

	$l_pass_succ = '* Password has been updated successfully.';
	$l_sys_err = 'x System is not available now, please try again later.';
	$l_pass_diff = 'x The two password are not the same';
	$l_wrong_pass = 'x Incorrect old password, please try again (make sure CapsLK off)';

	$l_pass_title = 'Change Password';
	$l_pass_old = 'Old Password';
	$l_pass_new = 'New Password';
	$l_pass_new2 = 'Re-enter New Password';

	$l_submit_botton = 'Submit';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '';
	$l_back_prof = '&#36820;&#22238;&#20010;&#20154;&#36164;&#26009;';

	$l_pass_succ = '* &#23494;&#30721;&#26356;&#26032;&#25104;&#21151;&#12290;';
	$l_sys_err = 'x &#31995;&#32479;&#32321;&#24537;&#65292;&#35831;&#31245;&#21518;&#20877;&#35797;&#12290;';
	$l_pass_diff = 'x &#20004;&#27425;&#36755;&#20837;&#30340;&#26032;&#23494;&#30721;&#19981;&#21516;&#65292;&#35831;&#37325;&#35797;&#12290;';
	$l_wrong_pass = 'x &#26087;&#23494;&#30721;&#19981;&#27491;&#30830;&#65292;&#35831;&#37325;&#35797;&#65288;&#30830;&#23450; CapsLK &#38190;&#20851;&#38381;&#65289;';
	
	$l_pass_title = '&#23494;&#30721;&#26356;&#26032;';
	$l_pass_old = '&#26087;&#23494;&#30721;';
	$l_pass_new = '&#26032;&#23494;&#30721;';
	$l_pass_new2 = '&#22312;&#27492;&#36755;&#20837;&#26032;&#23494;&#30721;';

	$l_submit_botton = '&#30830;&#23450;';
}

//=========================================================================================================

$isPass = isset($_POST['pass_hide_info']) && $_POST['pass_hide_info']==1;
$isSecu = isset($_POST['secu_hide_info']) && $_POST['secu_hide_info']==1;
$result = -1;

if( $isPass && 
	isset($_POST['old_pass']) && !empty($_POST['old_pass']) && 
	isset($_POST['new_pass']) && !empty($_POST['new_pass']) && 
	isset($_POST['new_pass2']) && !empty($_POST['new_pass2']) )
{
	$passwd = DatabaseUtil::getUserPassword($_SESSION['_userId']);
	if(strcmp(md5($_POST['old_pass']), $passwd) == 0)
	{
		if(strcmp($_POST['new_pass'], $_POST['new_pass2']) == 0)
		{
			if( DatabaseUtil::updatePassword($_SESSION['_userId'], $_POST['new_pass']) )
			{
				if( isset($_COOKIE['param1']) && isset($_COOKIE['param2']) )
					SecurityUtil::setCookie($_SESSION['_loginUser']->login_email, $_POST['new_pass']);
				$result = 0;
			}
			else $result = 1;
		}
		else $result = 2;
	}
	else $result = 3;
}

$imageId = CommonUtil::genRandomString(8);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='css/home_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<script type='text/javascript' src="../js/home.js"></script>
<script type='text/javascript' src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div class="top_back_link"><label style="color:blue">&laquo; <a class="back_profile" href="../home/profile.php"> <?php echo $l_back_prof?></a></label></div>
	<div style="width:800px;">
	<div style="width:480px;">
	<div class="secure_err_div">
<?php
if ( $isPass )
{
	switch ($result)
	{
	case 0:
		echo '<label class="success_info">'.$l_pass_succ.'</label>';
		break;
	case 1:
		echo '<label class="err_info">'.$l_sys_err.'</label>';
		break;
	case 2:
		echo '<label class="err_info">'.$l_pass_diff.'</label>';
		break;
	case 3:
		echo '<label class="err_info">'.$l_wrong_pass.'</label>';
		break;
	}
}
?></div>
	<div style="margin-bottom:20px;border:1px solid #AAA">
	<div class="secure_title"><?php echo $l_pass_title?></div>
	<div class="cross_separator"></div>
	<form style="width:400px;" method="post" enctype="multipart/form-data" action="secure_info.php" name="pass_form" id="pass_form" accept-charset="UTF-8">
	<table style="margin-top:5px;margin-bottom:8px;">
	<tr>
	<td class="td_info_label"><label class="dis_label"<?php echo ($isPass && (!isset($_POST['old_pass']) || empty($_POST['old_pass']))) ? ' style="color:red"' : ''?>><?php echo $l_pass_old?>:</label></td>
	<td class="td_info_input"><input type="password" name="old_pass" class="prof_input_p"/><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"<?php echo ($isPass && (!isset($_POST['new_pass']) || empty($_POST['new_pass']))) ? ' style="color:red"' : ''?>><?php echo $l_pass_new?>:</label></td>
	<td class="td_info_input"><input type="password" name="new_pass" class="prof_input_p"/><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"<?php echo ($isPass && (!isset($_POST['new_pass2']) || empty($_POST['new_pass2']))) ? ' style="color:red"' : ''?>><?php echo $l_pass_new2?>:</label></td>
	<td class="td_info_input"><input type="password" name="new_pass2" class="prof_input_p"/><span class="mandi_field"> *</span></td>
	</tr>
	</table>
	<input type="hidden" name="pass_hide_info" value="1" />
	<div style="margin-left:20px;margin-top:10px;margin-left:200px;margin-bottom:20px;">
	<input id="pass_update" class="button_input" onmousedown="mousePress('pass_update')" onmouseup="mouseRelease('pass_update')" onmouseout="mouseRelease('pass_update')" type="submit" value="<?php echo $l_submit_botton?>" />
	</div>
	</form>
	</div>
	</div>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
