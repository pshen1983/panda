<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/MessageUtil.php");

session_start();
CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Login | ProjNote';

	$l_email = 'Email';
	$l_retr_pass = 'Retrieve Password';
	$l_password = 'Check Code';

	$l_reg_diff_check = 'Try a different check code';

	$l_suc_0 = 'Your password has sent to your email, please check your email.';
	$l_err_1 = 'Incorrect email format.';
	$l_err_2 = 'Incorrect Check Code, please try again.';
	$l_err_3 = 'All fields are mandatory, please try again.';
	$l_err_4 = 'This account is not registered, please <a href="register.php">Register</a> first.';
	$l_err_5 = 'System is temporarily busy, please try again later.';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#30331;&#24405; ProjNote';

	$l_email = '&#24080;&#21495;';
	$l_retr_pass = '&#21462;&#22238;&#23494;&#30721;';
	$l_password = '&#39564;&#35777;&#30721;';

	$l_reg_diff_check = '&#30475;&#19981;&#28165;&#65292;&#25442;&#19968;&#20010;&#39564;&#35777;&#30721;';

	$l_suc_0 = '&#24744;&#30340;&#23494;&#30721;&#24050;&#32463;&#21457;&#36865;&#21040;&#24744;&#30340;&#24080;&#21495;&#37038;&#31665;&#65292;&#35831;&#26597;&#25910;&#12290;';
	$l_err_1 = '&#24080;&#21495;&#65288;Email&#65289;&#26684;&#24335;&#26377;&#35823;&#65292;&#35831;&#37325;&#35797;&#12290;';
	$l_err_2 = '<span style="color:red">&#39564;&#35777;&#30721;</span>&#26377;&#35823;&#65292;&#35831;&#37325;&#35797;&#12290;';
	$l_err_3 = '<span style="color:red">&#24080;&#21495;</span>&#21644;<span style="color:red">&#39564;&#35777;&#30721;</span>&#37117;&#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_err_4 = '&#24080;&#21495;&#19981;&#26159;&#27880;&#20876;&#29992;&#25143;&#65292;&#35831;&#20808;<a href="register.php">&#27880;&#20876;</a>&#12290;';
	$l_err_5 = '&#31995;&#32479;&#26242;&#26102;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
}

//=========================================================================================================

if( isset($_POST['loginemail']) && !empty($_POST['loginemail']) &&
	isset($_POST['check_code']) && !empty($_POST['check_code']) )
{
	if( isset($_SESSION['_register'][$_POST['check_against']]) && 
		$_POST['check_code'] == $_SESSION['_register'][$_POST['check_against']])
	{
		if (CommonUtil::validateEmailFormat(trim($_POST['loginemail'])))
		{
			if( DatabaseUtil::emailExists(trim($_POST['loginemail'])) )
			{
				$user = DatabaseUtil::getUserByEmail(trim($_POST['loginemail']));
				$pass = CommonUtil::genRandomString(8);

				if( DatabaseUtil::updatePassword($user['id'], $pass) )
				{
					MessageUtil::retrievePassword(trim($_POST['loginemail']), $pass);
					$result = 0;
				}
				else $result = 5;
			}
			else $result = 4;
		}
		else $result = 1;
	}
	else $result = 2;
}
else if( isset($_POST['hide']) && !empty($_POST['hide']) ) $result = 3;

$imageId = CommonUtil::genRandomString(8);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/default_layout.css" />
<link rel="stylesheet" type="text/css" href="../css/proj_layout.css" />
<script language="JavaScript" src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php
include_once '../common/header_1.inc.php';

if (isset($result) && $result!=0)
{
	echo '<div id="login_err_board" '.($_SESSION['_language']=='zh' ? 'style="height:35px;"': 'style="height:70px;"').'>';
	echo '<label style="position:relative;top:25%;font-size:.9em;font-weight:bold;">';

	switch ($result)
	{
	case 1:
		echo $l_err_1;
		break;
	case 2:
		echo $l_err_2;
		break;
	case 3:
		echo $l_err_3;
		break;
	case 4:
		echo $l_err_4;
		break;
	case 5:
		echo $l_err_5;
		break;
	}

	echo '</label>';
	echo '</div>';
	echo '<div id="login_message_sperator" >';
	echo '</div>';

	unset($result);
}
else if(isset($result) && $result == 0)
{
	echo '<div id="login_info_board">
		  <label style="position:relative;top:25%;font-size:.9em;font-weight:bold;">'.$l_suc_0
		.'</label></div>';
}
?>
<div id="login_auth">
	<form method="post" enctype="multipart/form-data" action="forget_password.php" name="login_form" id="forget_pass" accept-charset="UTF-8">
		<label><b class="title_logo">ProjNote <?php echo $l_retr_pass?></b></label>
		<div id="login_form_saperator"></div>
		<div id="login_form_info">
		<table>
		<tr>
		  <td><label for='loginemail' class="login_form_label"><?php echo $l_email?>:</label></td>
		  <td><input name='loginemail' id='loginemail' maxlength='96' tabindex='1' class="login_form_input" value="<?php if( isset($_POST['loginemail']) ) echo $_POST['loginemail'];?>" /></td>
		</tr>
		<tr>
		  <td><label for='loginpasswd' id="login_password_label" class="forget_pass"><?php echo $l_password?>:</label></td>
		  <td><input type="text" id="check_code" name="check_code" tabindex='2' class="forget_pass_check"/>
<img style="height:35px;" id="verifyPic" src="../utils/getCode.php?r=<?php echo $imageId?>" style="margin-bottom:-7px;#margin-bottom:-4px;"/>
<a style="font-size:.76em;" tabindex='3' href="javascript:changeCodeImage('verifyPic','<?php echo $imageId?>')"><?php echo $l_reg_diff_check?></a>
<input type="hidden" value="<?php echo $imageId?>" name="check_against" /></td>
		</tr>
		<tr>
		  <td><input type="hidden" value="buttonclick" name="hide" /></td>
		  <td><input type="submit" class="submitbn" value="<?php echo $l_retr_pass?>"/></td>
		</tr>
		</table>
		</div>
	</form>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>