<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/MessageUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");

session_start();
CommonUtil::setSessionLanguage();

if (!empty($_POST['reg_hide']))
{
	if (!CommonUtil::validateEmailFormat(trim($_POST['email'])))
	{
		$result = 5;
	}
	else if (strcmp(trim($_POST['email']), trim($_POST['remail'])) != 0)
	{
		$result = 4;
	}
	else if (!isset($_POST['passwd']) || empty($_POST['passwd']))
	{
		$result = 7;
	}
	else if ($_POST['passwd'] != $_POST['repasswd'])
	{
		$result = 8;
	}
	else if ($_POST['check'] != $_SESSION['_register'][$_POST['check_against']])
	{
		$result = 6;
	}
	else if(DatabaseUtil::getUserByEmail($_POST['email']) != false)
	{
		$result = 2;
	}
	else if( !isset($_POST['terms']) || !$_POST['terms'] )
	{
		$result = 9;
	}
	else {
		$fp = fopen('../image/default_pro_pic.png', 'r');
		$content = fread($fp, filesize('../image/default_pro_pic.png'));
		$content = addslashes($content);
		fclose($fp);
		$result = DatabaseUtil::insertUser($_POST['firstname'], $content, $_POST['lastname'], $_POST['lastname'].$_POST['firstname'], $_POST['email'], $_POST['passwd']);
		$result = ($result ? 0 : 1);
	}
}

if( isset($result) && $result == 0 )
{
	MessageUtil::sendPassword($_POST['email'], $_POST['passwd']);
	$loginResult = SecurityUtil::doLogin($_POST['email'], $_POST['passwd']);
	header( 'Location: ../home/index.php' );
	exit;
}

$imageId = CommonUtil::genRandomString(8);

include_once ("language/l_register.inc.php");
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

if (isset($result))
{
	echo '<div id="reg_message_board" class="round_border_6">';
	echo '<label id="reg_message_body">';

	switch ($result)
	{
	case 1:
		echo $l_sys_err;
		break;
	case 2:
		echo $l_acc_exist[0].(trim($_POST['email'])).$l_acc_exist[1];
		break;
	case 3:
		echo $l_err_occ.trim($_POST['email']).'</span>>';
		break;
	case 4:
		echo $l_acc_diff;
		break;
	case 5:
		echo $l_email_format;
		break;
	case 6:
		echo $l_check_err;
		break;
	case 7:
		echo $l_pass_empty;
		break;
	case 8:
		echo $l_pass_diff;
		break;
		break;
	case 9:
		echo $l_read_terms;
		break;
	}

	echo '</label>';
	echo '</div>';
	echo '<div id="reg_message_saperator"></div>';
}
?>
  <div id="reg_auth" >
	<form method="post" enctype="multipart/form-data" action="register.php" name="register_form" id="reg_form" accept-charset="UTF-8">
	<label><b class="title_logo">ProjNote <?php echo $l_sign_up_reg?></b></label>
	<div id="reg_form_saperator"></div>
	<div id="reg_form_body">
	<table>
		<tr>
		  <td class="label_td"><label for='email_label' class="reg_form_label"><?php echo $l_reg_email?> :</label></td>
		  <td id="reg_form_email_input_td"><input name='email' id='email' maxlength='96' tabindex='1' onblur="javascript:checkUserExistance()" value="<?php echo ((!isset($_POST['email'])) ? "" : $_POST['email'])?>" class="reg_form_input"/>
		  <label id="emailerror">
		 	<span id="emailerrormessage"></span>
		  </label>
		  <img id="indicator" src="../image/snake.gif" style="border:0 none;position:relative;top:2px;#top:-2px;width:16px;height:16px;visibility:hidden;" />
		  </td>
		</tr>
		<tr>
		  <td class="label_td"><label for='reemail_label' class="reg_form_label"><?php echo $l_reg_reemail?> :</label> </td>
		  <td><input name='remail' id='remail' maxlength='96' tabindex='2' value="<?php echo ((!isset($_POST['remail'])) ? "" : $_POST['remail'])?>" class="reg_form_input"/></td>
		</tr>
		<tr>
		  <td class="label_td"><label for='lname_label' class="reg_form_label"><?php echo $l_reg_l_name?> :</label></td>
		  <td><input name='lastname' id='lastname' maxlength='96' tabindex='3' value="<?php echo ((!isset($_POST['lastname'])) ? "" : $_POST['lastname'])?>" class="reg_form_input"/> <br></td>
		</tr>
		<tr>
		  <td class="label_td"><label for='fname_label' class="reg_form_label"><?php echo $l_reg_f_name?> :</label></td>
		  <td><input name='firstname' id='firstname' maxlength='96' tabindex='4' value="<?php echo ((!isset($_POST['firstname'])) ? "" : $_POST['firstname'])?>" class="reg_form_input"/> <br></td>
		</tr>
		<tr>
		  <td class="label_td"><label for='password' class="reg_form_label"><?php echo $l_reg_pass?> :</label></td>
		  <td><input name='passwd' id='passwd' type='password' maxlength='64' tabindex='5' class="reg_form_input" value="<?php if(isset($_POST['ind']) && $_POST['ind']=='ind' && isset($_POST['passwd'])) echo $_POST['passwd']?>"/></td>
		</tr>
		<tr>
		  <td class="label_td"><label for='repassword' class="reg_form_label"><?php echo $l_reg_repass?> :</label></td>
		  <td><input name='repasswd' id='repasswd' type='password' maxlength='64' tabindex='6' class="reg_form_input" value="<?php if(isset($_POST['ind']) && $_POST['ind']=='ind' && isset($_POST['repasswd'])) echo $_POST['repasswd']?>"/></td>
		</tr>
		<tr>
		  <td class="label_td"><label for='check_code' class="reg_form_label"><?php echo $l_reg_check?> :</label></td>
		  <td>
		  <input name='check' id='check' maxlength='96' tabindex='7'/>
		  <input type="hidden" value="<?php echo $imageId?>" name="check_against" />
		  <img id="verifyPic" src="../utils/getCode.php?r=<?php echo $imageId?>" />
		  <a id="reg_form_diffrent_code" href="javascript:changeCodeImage('verifyPic','<?php echo $imageId?>')" tabindex='8'><?php echo $l_reg_diff_check?></a>
		  <input type="hidden" value="buttonclick" name="reg_hide" />
		  </td>
		</tr>
		<tr>
		<td></td>
		<td><input type="checkbox" name="terms" id="terms" checked="checked"/><label for="terms" id="terms_l"><?php echo $l_reg_terms?></label></td>
		</tr>
		<tr>
		  <td></td>
		  <td><input type="submit" class="submitbng" value="<?php echo $l_reg_sign_up?>"/></td>
		</tr>
	</table>
		 
	</div>		
	</form>
	</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
  </body>
</html>