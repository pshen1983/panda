<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/MessageUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Friends Invitation to ProjNote';
	$l_header = 'Invite your friends to ProjNote';
	$l_user_email = 'User Email';
	$l_more_btn = 'Invite More Friends';
	$l_submit = 'Submit';

	$l_info_0 = 'An invitation has sent to your friend';
	$l_info_1 = 'This account is already registered';
	$l_info_2 = 'Incorrect email format';

	$l_msn_info = 'Send invitations to your MSN contact list friends.';
	$l_msn_label = 'MSN <span style="font-size:.8em;">Email</span>:';
	$l_msn_pass = 'Password:';
	$l_msn_save = 'Your MSN password will NOT be saved. You could also change your password, import the list and change it back to be sure about the security of your password.';
	$l_msn_submit = 'Send Invitations';
	$l_msn_error_1 = 'x An error occurs during connect to MSN server, please try again later.';
	$l_msn_error_2 = 'x Invalid <span class="login_message_color_red">MSN Email</span> or <span class="login_message_color_red">password</span>. Please try again (keep <span style="font-style:italic;">Cpas Lock</span>  off).';
	$l_msn_succ = '- Invitations has been sent to your friends on your MSN contact list.';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#36992;&#35831;&#26379;&#21451;&#21152;&#20837; ProjNote';
	$l_header = '邀请朋友加入 ProjNote';
	$l_user_email = '&#26379;&#21451; Email';
	$l_more_btn = '&#36992;&#35831;&#26356;&#22810;&#26379;&#21451;';
	$l_submit = '&#30830;&#23450;';

	$l_info_0 = '&#24744;&#30340;&#36992;&#35831;&#24050;&#32463;&#21457;&#36865;';
	$l_info_1 = '&#24744;&#30340;&#26379;&#21451;&#24050;&#32463;&#27880;&#20876;';
	$l_info_2 = '&#37038;&#20214;&#26684;&#24335;&#26377;&#35823;';

	$l_msn_info = '&#21457;&#36865;&#36992;&#35831;&#32473;&#24744;MSN&#32852;&#31995;&#21015;&#34920;&#30340;&#26379;&#21451;&#20204;&#12290;';
	$l_msn_label = 'MSN&#36134;&#21495;&#65306;';
	$l_msn_pass = 'MSN&#23494;&#30721;&#65306;';
	$l_msn_save = '&#20320;&#30340;MSN&#23494;&#30721;&#19981;&#20250;&#34987;&#23384;&#20648;&#65292;&#35831;&#25918;&#24515;&#20351;&#29992;&#12290;&#20320;&#20063;&#21487;&#20197;&#20808;&#25913;&#23494;&#30721;&#65292;&#23548;&#20837;&#26379;&#21451;&#21015;&#34920;&#26377;&#20877;&#25913;&#22238;&#21407;&#22987;&#23494;&#30721;&#65292;&#30830;&#20445;&#23494;&#30721;&#23433;&#20840;&#12290;';
	$l_msn_submit = '&#21457;&#36865;&#36992;&#35831;';
	$l_msn_error_1 = 'x &#26080;&#27861;&#36830;&#25509;&#21040;MSN&#26381;&#21153;&#22120;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_msn_error_2 = 'x MSN<span class="login_message_color_red">&#24080;&#21495;&#25110;&#23494;&#30721;</span>&#38169;&#35823;. &#35831;&#37325;&#35797;(&#30830;&#35748;<span style="font-style:italic;">Cpas Lock</span>&#38190;&#20851;&#38381;).';
	$l_msn_succ = '&#8212; &#36992;&#35831;&#24050;&#21457;&#36865;&#32473;&#24744;MSN&#32852;&#31995;&#21015;&#34920;&#20013;&#30340;&#26379;&#21451;&#20204;&#12290;';
}

//=========================================================================================================

if( isset($_POST['form_hidden_input']) && $_POST['form_hidden_input']>=0 )
{
	$result = array();
	$count = $_POST['form_hidden_input'];
	$name = ($_SESSION['_language']=='zh') ? $_SESSION['_loginUser']->fullname_cn : $_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname;
	
	for($ind=0; $ind<$count; $ind++)
	{
		if (isset($_POST['user_email_'.$ind]) && !empty($_POST['user_email_'.$ind])) 
		{
			if(CommonUtil::validateEmailFormat($_POST['user_email_'.$ind]))
			{
				if(!DatabaseUtil::emailExists($_POST['user_email_'.$ind]))
				{
					$from = '"'.$name.'" <'.$_SESSION['_loginUser']->login_email.">";
					MessageUtil::sendInvitation($from, $_POST['user_email_'.$ind]);
					$result[$ind] = 0;
				}
				else $result[$ind] = 1; //already registered
			}
			else $result[$ind] = 2; //format
		}
		else $result[$ind] = 3; //empty
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
	<link rel='stylesheet' type='text/css' href='css/mess_layout.css' />
	<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
	<script language="JavaScript" src="../js/common.js"></script>
	<script language="JavaScript" src="../js/message.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div class="invite_proj">
	<div class="Invitation_header_label"><label><?php echo $l_header?>:</label></div>
	<div class="page_saperator"></div>
	<form id="team_invite" class='invite_form' method="post" enctype="multipart/form-data" action="invite_friend.php" accept-charset="UTF-8">
	<table style="width:100%;">
	<tbody id="invitation_sec">
<?php 
	if(isset($_POST['form_hidden_input']) && $_POST['form_hidden_input']>=0)
	{
		for($ind=0; $ind<$count; $ind++)
		{
			$output = '<tr id="invitation_'.$ind.'">
					   <td><label class="invite_disp_label'.($result[$ind]==3 ? ' highlight' : '').'">'.$l_user_email.':</label></td>
					   <td class="invite_table_input_td"><input type="text" class="invite_email_input textfield" id="user_email_'.$ind.'" name="user_email_'.$ind.'" value="'.$_POST['user_email_'.$ind].'" />
					   <span class="invitation_result_span">';
			switch ($result[$ind])
			{
			case 0:
				$output .= '<label class="invitation_result_info">'.$l_info_0.'</label>';
				break;
			case 1:
				$output .= '<label class="invitation_result_info">'.$l_info_1.'</label>';
				break;
			case 2:
				$output .= '<label class="invitation_result_error">'.$l_info_2.'</label>';
				break;
			}

			$output .= '</span></td></tr>';
			echo $output;
		}

		echo '</table>
			  <div id="more_user_div">
			  <input id="more_user_botton" class="textfield" type="button" onmousedown="mousePress(\'more_user_botton\')" onmouseup="mouseRelease(\'more_user_botton\')" onmouseout="mouseRelease(\'more_user_botton\')" onClick="javascript:addMoreUserInvitation(\'invitation\', '.$count.', \'form_hidden_input\', \''.$l_more_btn.'\', \''.$l_user_email.':\')" value="'.$l_more_btn.'" />
			  </div>
			  <input id="form_hidden_input" type="hidden" value="'.$count.'" name="form_hidden_input" />';
	}
	else {?>
	<tr id="invitation_0">
	<td><label class="invite_disp_label"><?php echo $l_user_email?>:</label></td>
	<td class="invite_table_input_td"><input type="text" class="invite_email_input textfield" id="user_email_0" name="user_email_0" /></td>
	</tr>
	</tbody>
	</table>
	<div id="more_user_div">
	<input id="more_user_botton" type="button" onmousedown="mousePress('more_user_botton')" onmouseup="mouseRelease('more_user_botton')" onmouseout="mouseRelease('more_user_botton')" onClick="javascript:addMoreUserInvitation('invitation', 1, 'form_hidden_input', '<?php echo $l_more_btn?>', '<?php echo $l_user_email?>:')" value="<?php echo $l_more_btn?>" />
	</div>
	<input id="form_hidden_input" type="hidden" value="1" name="form_hidden_input" />
<?php }?>
	<input type="submit" class="submitbn" value="<?php echo $l_submit?>"/>
	</form>
	<div class="page_saperator"></div>
	<form id="msn_invite" class='invite_form' method="post" enctype="multipart/form-data" action="invitation_msn_process.inc.php" accept-charset="UTF-8">
	<img align="middle" src="../image/logo/msn_logo.png" style="width:50px;height:50px;margin-right:10px;" /><label class="invite_disp_label"><?php echo $l_msn_info?></label>
	<table style="margin-top:15px;margin-left:5px;">
	<tr>
	<td></td>
	<td><div id="msn_mess_dis"><?php if( isset($_SESSION['_msnResult']) ) { ?>
<label style="font-size:.8em;color:<?php echo $_SESSION['_msnResult']==0 ? 'green' : 'red' ?>"><?php 
	if($_SESSION['_msnResult']==0)
		echo $l_msn_succ;
	else if($_SESSION['_msnResult']==1)
		echo $l_msn_error_1;
	else if($_SESSION['_msnResult']==2)
		echo $l_msn_error_2;
	unset($_SESSION['_msnResult']); ?></label>
<?php }?></div></td>
	</tr>
	<tr>
	<td><label class="msn_label"><?php echo $l_msn_label?></label></td>
	<td class="invite_table_input_td"><input type="text" class="invite_email_input textfield" id="msn_acct" name="msn_acct" style="line-height:160%;" value="<?php if(isset($_SESSION['_msnAccount'])) echo $_SESSION['_msnAccount']; unset($_SESSION['_msnAccount']);?>"/></td>
	</tr>
	<tr>
	<td><label class="msn_label"><?php echo $l_msn_pass?></label></td>
	<td class="invite_table_input_td">
	<input type="password" class="invite_email_input textfield" id="msn_pass" name="msn_pass" style="line-height:160%;"/>
	</td>
	</tr>
	<tr>
	<td><img id="busy_img" src="../image/snake.gif" style="width:30px;height:30px;margin-left:10px;display:none"/></td>
	<td><div style="border:1px solid #AAA;width:250px;background-color:#F9F9F9;"><div style="margin:5px 5px 5px 5px;font-size:.8em;"><label style="line-height:17px;"><?php echo $l_msn_save?></label></div></div></td>
	</tr>
	</table>
	<input type="submit" class="submitbn" value="<?php echo $l_msn_submit?>"/>
	</form>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
</body>
</html>