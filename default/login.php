<?php
include_once ("../utils/configuration.inc.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
CommonUtil::setSessionLanguage();

if( isset($_SESSION['_userId']) || SecurityUtil::cookieLogin() )
{
	if (isset($_GET['page']))
		header( 'Location: '.$HTTP_BASE.str_replace("%%", "&", $_GET['page']) );
	else if($_SESSION['_loginUser']->proj_id != 0) {
		$proj = DatabaseUtil::getProj($_SESSION['_loginUser']->proj_id);
    	header( 'Location: '.$HTTP_BASE.'/project/index.php?p_id='.$_SESSION['_loginUser']->proj_id.'&sid='.$proj['s_id'] ) ;
	}
	else header( 'Location:'.$HTTP_BASE.'/home/index.php' );

	exit;
}

if (isset($_POST['hide']))
{
	if(!isset($_POST['loginemail']) || empty($_POST['loginemail']))
	{
		$loginResult=4;
	}
	else if(!CommonUtil::validateEmailFormat($_POST['loginemail']))
	{
		$loginResult=5;
	}
	else if(!isset($_POST['loginpasswd']) || empty($_POST['loginpasswd']))
	{
		$loginResult=6;
	}
	else {
		$loginResult = SecurityUtil::doLogin($_POST['loginemail'], $_POST['loginpasswd']);
	
		if ($loginResult==0)
		{
			unset($loginResult);

			if (isset($_POST['keep_login']) && $_POST['keep_login']) 
				SecurityUtil::setCookie($_POST['loginemail'], $_POST['loginpasswd']);
			else
				SecurityUtil::unsetCookie();
	
			if (isset($_POST['url']))
				header( 'Location: '.$HTTP_BASE.$_POST['url'] );
			else if($_SESSION['_loginUser']->proj_id != 0) {
				$proj = DatabaseUtil::getProj($_SESSION['_loginUser']->proj_id);
    			header( 'Location: '.$HTTP_BASE.'/project/index.php?p_id='.$_SESSION['_loginUser']->proj_id.'&sid='.$proj['s_id'] ) ;
			}
			else header( 'Location: '.$HTTP_BASE.'/home/index.php' );

			exit;
		}
	}
}

include_once ('language/l_login.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/proj_layout.css" />
<link rel="stylesheet" type="text/css" href="css/default_layout.css" />
<script language="JavaScript" src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php
include_once '../common/header_1.inc.php';

if (isset($loginResult))
{
	echo '<div class="round_border_6" id="login_err_board" '.($_SESSION['_language']=='zh' ? 'style="height:35px;"': 'style="height:70px;"').'>';
	echo '<label style="position:relative;top:25%;font-weight:bold;">';

	switch ($loginResult)
	{
	case 1:
		echo $l_sys_err;
		break;
	case 2:
		echo $l_cannot_find[0]. $_POST['loginemail']. $l_cannot_find[1];
		break;
	case 3:
		echo $l_worng_pass;
		break;
	case 4:
		echo $l_email_empty;
		break;
	case 5:
		echo $l_email_format;
		break;
	case 6:
		echo $l_pass_empty;
		break;
	}

	echo '</label>';
	echo '</div>';
	echo '<div id="login_message_sperator" >';
	echo '</div>';

	unset($loginResult);
}
else if (isset($_SESSION['_justReg']) )
{
	echo '<div id="login_info_board">';
	echo '<label style="position:relative;top:25%;font-size:.9em;font-weight:bold;">';
	echo $l_from_reg;
	echo '</label></div>';
}
?>
<div id="login_auth">
	<form method="post" enctype="multipart/form-data" action="<?php echo $HTTPS_BASE?>/default/login.php" name="login_form" id="login_form" accept-charset="UTF-8">
		<label><b class="title_logo">Projnote <?php echo $l_login?></b></label>
		<div id="login_form_saperator"></div>
		<div id="login_form_info">
		<table>
		<tr>
		  <td><label for='loginemail' class="login_form_label"><?php echo $l_email?>:</label></td>
		  <td><input name='loginemail' id='loginemail' maxlength='96' tabindex='1' class="login_form_input" value="<?php if( isset($_POST['loginemail']) ) {
		echo $_POST['loginemail'];
	}
	else if( isset($_SESSION['_justReg']) ) {
		echo $_SESSION['_justReg'];
		unset($_SESSION['_justReg']);
	}
?>" /></td>
</tr>
<tr>
<td></td>
<td><span style="font-size:11px;color:#454545;">(e.g. example@projnote.com)</span> </td>
</tr>
<tr>
<td><label for='loginpasswd' id="login_password_label" class="login_form_label"><?php echo $l_password?>:</label></td>
<td><input name='loginpasswd' id='loginpasswd' type='password' maxlength='64' tabindex='2' class="login_form_input" /></td>
</tr>
<tr>
<td></td>
<td><input type='checkbox' name='keep_login' id='keep_login' title="<?php echo $l_log_keep_title?>" tabindex='3' value="true" <?php if (isset($_POST['keep_login']) && $_POST['keep_login']) echo "checked";?>>
<label for="keep_login" id="keep_login_label" title="<?php echo $l_log_keep_title?>"><?php echo $l_logged_in?></label></td>
</tr>
<tr>
<td><input type="hidden" value="buttonclick" name="hide" />
<?php if (isset($_GET['page'])) echo "<input type=\"hidden\" value=\"". str_replace("%%", "&", $_GET['page']) ."\" name=\"url\" />"?></td>
<td><input type="submit" class="submitbn" tabindex='4' value="<?php echo $l_login?>"/>
<span style="font-size:12px;"><?php echo $l_or?></span><span style="font-size:26px;"> </span><a href="register.php" tabindex='5' style="font-size:12px;"><b><?php echo $l_sign_up_login?></b></a></td>
</tr>
<tr>
<td></td>
<td><a href="forget_password.php" style="font-size:12px;position:relative;top:2px;" tabindex='6' class="ital"><?php echo $l_forget_pass?></a></td>
</tr>
</table>
</div>
</form>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>