<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = '';

	$pers_info = 'Personal Information';
	$first_name = 'First Name';
	$last_name = 'Last Name';
	$login_email = 'Login Email';

	$curr_city = 'Current City';
	$birt_year = 'Birth Year';
	$birt_month = 'Birth Month';
	$birt_day = 'Birth Day';
	$interests = 'Interestes';

	$l_educ_info = 'Education History';
	
	$l_school = 'School';
	$l_degr_type = 'Degree Type';
	$l_department = 'Department';
	$l_scho_year = 'School Years';

	$l_empl_info = 'Employment History';
	
	$l_company = 'Company Name';
	$l_comp_location = 'Location';
	$l_sector = 'Title';
	$l_serv_year = 'Service Years';
	$l_send_msg = 'Send Message';
	
	$l_to = 'To <span style="font-size:.8em;font-weight:normal;">(Email)</span>';
	$l_subject = 'Subject';
	$l_message_body = 'Message';
	$l_send = 'New';
	$l_delete = 'Delete';
	$l_submit = 'Send';
	$l_cancel = 'Close';
	$l_delete_message = 'x No message selected. Please select at least one message and try again.';
	$l_send_message = '- Message has been send successfully.';
	
	$present = 'Present';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '';

	$pers_info = '&#20010;&#20154;&#20449;&#24687;';
	$first_name = '&#21517;';
	$last_name = '&#22995;';
	$login_email = '&#30005;&#23376;&#37038;&#20214;';
	
	$curr_city = '&#25152;&#22312;&#22478;&#24066;';
	$birt_year = '&#20986;&#29983;&#24180;';
	$birt_month = '&#20986;&#29983;&#26376;';
	$birt_day = '&#20986;&#29983;&#26085;';
	$interests = '&#20852;&#36259;&#29233;&#22909;';

	$l_educ_info = '&#25945;&#32946;&#21382;&#21490;';
	
	$l_school = '&#38498;&#26657;&#21517;&#31216;';
	$l_degr_type = '&#23398;&#20301;&#31181;&#31867;';
	$l_department = '&#31995;&#37096;&#21517;&#31216;';
	$l_scho_year = '&#22312;&#26657;&#26102;&#38388;';

	$l_empl_info = '&#24037;&#20316;&#21382;&#21490;';
	
	$l_company = '&#20844;&#21496;&#21517;&#31216;';
	$l_comp_location = '&#20844;&#21496;&#22320;&#22336;';
	$l_sector = '&#32844;&#20301;&#21517;&#31216;';
	$l_serv_year = '&#26381;&#21153;&#26102;&#26399;';
	$l_send_msg = '发送站内信';
	
	$l_to = '&#29992;&#25143;<span style="font-size:.8em;font-weight:normal;">(Email)</span>';
	$l_subject = '&#25552;&#35201;';
	$l_message_body = '&#30701;&#20449;&#20869;&#23481;';
	$l_send = '&#21457;&#36865;&#30701;&#20449;';
	$l_delete = '&#21024;&#38500;&#30701;&#20449;';
	$l_submit = '&#21457;&#36865;';
	$l_cancel = '&#20851;&#38381;';
	$l_delete_message = 'x &#35831;&#36873;&#25321;&#33267;&#23569;&#19968;&#26465;&#35201;&#21024;&#38500;&#30340;&#30701;&#20449;&#21518;&#37325;&#35797;&#12290;';
	$l_send_message = '&#8212; &#20449;&#24687;&#25104;&#21151;&#21457;&#36865;&#12290;';	

	$present = '&#29616;&#22312;';
}

//=========================================================================================================

if( isset($_GET['p1']) && $_GET['p1']==session_id() && 
	isset($_GET['p2']) && is_numeric($_GET['p2']) )
{
	$uid = ($_GET['p2']+1)/3;

	$user = DatabaseUtil::getUserObj($uid);

	if(isset($user->id))
	{
		if(DatabaseUtil::doesProfileExist($uid))
		{
			$prof = DatabaseUtil::getProfile($uid);
			$educ = DatabaseUtil::getEducations($uid);
			$empl = DatabaseUtil::getEmployment($uid);
		}
	}
	else unset($uid);
}
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
<body onLoad="javascript:setMessageBoxPosition()">
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<?php if( isset($uid) ) {?>
<div class="main_content">
<div id="basic_info" class="sec_info">
<label class="sec_title"><?php echo $pers_info?></label>
<div id="personal_details">
<div class="detail_info">
<table>
<tr>
<td><img style="width:60px;height:60px;margin-right:5px;border:1px solid #DDD" src="<?php echo $user->pic?>" /></td>
<td><label class="val_label"><?php echo ($_SESSION['_language']=='zh') ? $user->fullname_cn : $user->firstname." ".$user->lastname ?></label>
<a id="usr_msg" href="javascript:showMessageBox()">( <span><?php echo $l_send_msg?></span> )</a></td>
</tr>
<tr><td></td><td><?php if( isset($_SESSION['_messMessage']) ) { ?>
<div style="text-align:left;display:block">
<label style="font-size:.8em;color:<?php echo $_SESSION['_messMessage']==0  ? 'green' : 'red'?>"> <?php 
if( $_SESSION['_messMessage']==0 ) {
	echo $l_send_message;
}
else {
	echo $l_delete_message;
}
unset( $_SESSION['_messMessage'] );?></label>
</div>
<?php }?></td></tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $login_email?>:</label></td>
<td><label class="val_label"><?php echo $user->login_email?></label></td>
</tr>
</table>
</div>
<div class="page_saperator"></div>
<div class="detail_info">
<table>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $curr_city?>:</label></td>
<td><label class="val_label"><?php echo isset($prof)&&!empty($prof) ? $prof['location'] : ""?></label></td>
</tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $birt_year?>:</label></td>
<td><label class="val_label"><?php echo isset($prof)&&!empty($prof) ? $prof['b_year'] : ""?></label></td>
</tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php  echo $birt_month?>:</label></td>
<td><label class="val_label"><?php echo isset($prof)&&!empty($prof) ? $prof['b_month'] : ""?></label></td>
</tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $birt_day?>:</label></td>
<td><label class="val_label"><?php echo isset($prof)&&!empty($prof) ? $prof['b_day'] : ""?></label></td>
</tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $interests?>:</label></td>
<td><label class="val_label"><?php echo isset($prof)&&!empty($prof) ? $prof['interests'] : ""?></label></td>
</tr>
</table>
</div>
</div>
</div>
<div id="top_link_saperator"></div>
<div id="education_info" class="sec_info">
<label class="sec_title"><?php echo $l_educ_info?></label>
<div id="education_details">
<?php if(isset($educ)) { 
$educ_array = array();
$index = -1;

while($edu = mysql_fetch_array($educ, MYSQL_ASSOC))
{
	$index++;
	$type = DatabaseUtil::getEnumDescription(DatabaseUtil::$EDUCATION, $edu['type']);
	$time = $edu['year_start'].' - '.($edu['year_end']!=0 ? $edu['year_end'] : '<span style="font-weight:bold">'.$present.'</span>');
	$educ_array[$index][0] = $edu['school'];
	$educ_array[$index][1] = $type;
	$educ_array[$index][2] = $edu['department'];
	$educ_array[$index][3] = $time;
}

$output = '';
for($ii=0;$ii<=$index;$ii++)
{
	$output.='<div class="detail_info">
			  <table>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_school.':</label></td>
			  <td><label class="val_label">'.$educ_array[$ii][0].'</label></td>
			  </tr>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_degr_type.':</label></td>
			  <td><label class="val_label">'.$educ_array[$ii][1].'</label></td>
			  </tr>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_department.':</label></td>
			  <td><label class="val_label">'.$educ_array[$ii][2].'</label></td>
			  </tr>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_scho_year.':</label></td>
			  <td><label class="val_label">'.$educ_array[$ii][3].'</label></td>
			  </tr>
			  </table>
			  </div>';
	$output.=($ii!=$index) ? '<div class="page_saperator"></div>':'';
}

echo $output;
}?>
</div>
</div>
<div id="top_link_saperator"></div>
<div id="career_info" class="sec_info">
<label class="sec_title"><?php echo $l_empl_info?></label>
<div id="employment_details">
<?php if(isset($empl)) { 
$empl_array = array();
$index = -1;

while($emp = mysql_fetch_array($empl, MYSQL_ASSOC))
{
	$index++;
	$time = $emp['year_start'].' - '.($emp['year_end']!=0 ? $emp['year_end'] : '<span style="font-weight:bold">'.$present.'</span>');
	$empl_array[$index][0] = $emp['company'];
	$empl_array[$index][1] = $emp['location'];
	$empl_array[$index][2] = $emp['title'];
	$empl_array[$index][3] = $time;
}

$output = '';
for($ii=0;$ii<=$index;$ii++)
{
	$output.='<div class="detail_info">
			  <table>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_company.':</label></td>
			  <td><label class="val_label">'.$empl_array[$ii][0].'</label></td>
			  </tr>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_comp_location.':</label></td>
			  <td><label class="val_label">'.$empl_array[$ii][1].'</label></td>
			  </tr>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_sector.':</label></td>
			  <td><label class="val_label">'.$empl_array[$ii][2].'</label></td>
			  </tr>
			  <tr>
			  <td class="td_info_label"><label class="dis_label">'.$l_serv_year.':</label></td>
			  <td><label class="val_label">'.$empl_array[$ii][3].'</label></td>
			  </tr>
			  </table>
			  </div>';
	$output.=($ii!=$index) ? '<div class="page_saperator"></div>':'';
}

echo $output;
}?>
</div>
</div>
</div>
<?php }?>
<div id="send_box" style="<?php echo isset($_SESSION['_sendMessageResultCode'])&&$_SESSION['_sendMessageResultCode']!=0 ? 'display:block;visibility:visible;' : 'display:none;visibility:hidden;';?>">
<div id="screen" class="screen"></div>
<div id="send_mess_div">
<form class="mess_send_form" method="post" enctype="multipart/form-data" action="../message/send_message.inc.php" name="send_message" id="send_message" accept-charset="UTF-8">
<div class="send_mess_result"><label style="color:<?php 
echo (isset($_SESSION['_sendMessageResultCode']) && $_SESSION['_sendMessageResultCode']==0) ? 'green' : 'red';
?>"><?php 
if (isset($_SESSION['_sendMessageResultMess'])) echo $_SESSION['_sendMessageResultMess'];?></label></div>
<table>
<tr>
<td><label class="invite_disp_label" <?php echo (isset($_SESSION['_sendMessageResultCode']) && $_SESSION['_sendMessageResultCode']==4) ? 'style="color:red"' : '' ?>><?php echo $l_to ?>:</label></td>
<td><input id="subject" name="to" class="mess_input_send" type="text" value="<?php if (isset($_SESSION['_sendMessageResultEmail'])) echo $_SESSION['_sendMessageResultEmail'];?>"/></td>
</tr>
<tr>
<td><label class="invite_disp_label"><?php echo $l_subject ?>:</label></td>
<td><input id="subject" name="subject" class="mess_input_send" type="text" /></td>
</tr>
<tr>
<td><label class="invite_disp_label"><?php echo $l_message_body?>:</label></td>
<td><textarea id="mess_body" name="mess_body" class="mess_send"></textarea></td>
</tr><?php
if(isset($_SESSION['_sendMessageResultCode'])) unset($_SESSION['_sendMessageResultCode']);
if(isset($_SESSION['_sendMessageResultMess'])) unset($_SESSION['_sendMessageResultMess']);
if(isset($_SESSION['_sendMessageResultEmail'])) unset($_SESSION['_sendMessageResultEmail']);
?></table>
<input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']?>" />
<div style="">
<input style="margin-right:100px;" id="send_button" class="button_input" onmousedown="mousePress('send_button')" onmouseup="mouseRelease('send_button')" onmouseout="mouseRelease('send_button')" type="submit" value="<?php echo $l_submit?>" />
<input id="cancel_button" class="button_input" onmousedown="mousePress('cancel_button')" onmouseup="mouseRelease('cancel_button')" onmouseout="mouseRelease('cancel_button')" type="button" onClick="javascript:hideMessageBox()" value="<?php echo $l_cancel?>" />
</div>
</form>
</div>
</div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
