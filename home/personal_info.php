<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

$prof = DatabaseUtil::getProfile($_SESSION['_userId']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = '';
	$l_back_prof = 'Back to My Profile';

	$l_first_name = 'First Name';
	$l_last_name = 'Last Name';
	$l_login_email = 'Login Email';

	$l_curr_city = 'Current City';
	$l_birt_year = 'Birth Year';
	$l_birt_month = 'Birth Month';
	$l_birt_day = 'Birth Day';
	$l_interests = 'Interestes';
	$l_password = 'Password';

	$l_submit_botton = 'Submit';
	$l_cancel_botton = 'Cancel';

	$l_err = 'x Wrong password, please try again.';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '';
	$l_back_prof = '&#36820;&#22238;&#20010;&#20154;&#36164;&#26009;';

	$l_first_name = '&#21517;';
	$l_last_name = '&#22995;';
	$l_login_email = '&#30005;&#23376;&#37038;&#20214;';
	
	$l_curr_city = '&#25152;&#22312;&#22478;&#24066;';
	$l_birt_year = '&#20986;&#29983;&#24180;';
	$l_birt_month = '&#20986;&#29983;&#26376;';
	$l_birt_day = '&#20986;&#29983;&#26085;';
	$l_interests = '&#20852;&#36259;&#29233;&#22909;';

	$l_password = '&#36755;&#20837;&#23494;&#30721;';

	$l_submit_botton = '&#30830;&#23450;';
	$l_cancel_botton = '&#21462;&#28040;';
	
	$l_err = 'x &#23494;&#30721;&#26377;&#35823;&#65292;&#35831;&#37325;&#35797;&#12290;';
}

//=========================================================================================================

$afterForm = ( isset($_POST['hide_info']) && $_POST['hide_info']==1 );

$result = 0;
if( isset($_POST['firstname']) && !empty($_POST['firstname']) &&
	isset($_POST['lastname']) && !empty($_POST['lastname']) &&
	isset($_POST['password']) && !empty($_POST['password']) && $afterForm )
{
	$passwd = DatabaseUtil::getUserPassword($_SESSION['_userId']);
	if(strcmp(md5($_POST['password']), $passwd) == 0)
	{
		$first_name = trim($_POST['firstname']);
		$last_name = trim($_POST['lastname']);
		$location = (isset($_POST['location']) && !empty($_POST['location'])) ? trim($_POST['location']) : null;
		$b_year = (isset($_POST['b_year']) && is_numeric($_POST['b_year']) && $_POST['b_year']<3000 && $_POST['b_year']>1800) ? $_POST['b_year'] : null;
		$b_month = (isset($_POST['b_month']) && is_numeric($_POST['b_month']) && $_POST['b_month']<13 && $_POST['b_month']>0) ? $_POST['b_month'] : null;
		$b_day = (isset($_POST['b_day']) && is_numeric($_POST['b_day']) && $_POST['b_day']<32 && $_POST['b_day']>0) ? $_POST['b_day'] : null;
		$interest = (isset($_POST['interests']) && !empty($_POST['interests'])) ? trim($_POST['interests']) : null;
	
		$result1 = DatabaseUtil::updatePersonalInfo($_SESSION['_userId'], null, $location, $b_year, $b_month, $b_day, $interest);
		$result2 = DatabaseUtil::updateUserName($_SESSION['_userId'], $first_name, $last_name, $last_name.$first_name);
	
		if($result1 && $result2) {
			$_SESSION['_loginUser']->firstname = $_POST['firstname'];
			$_SESSION['_loginUser']->lastname = $_POST['lastname'];
			header( 'Location: ../home/profile.php' ) ;
			exit;
		}
	}
	else $result = 1;
}
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
	<div style="margin-bottom:30px;width:600px;">
	<form method="post" enctype="multipart/form-data" action="personal_info.php" name="person_form" id="person_form" accept-charset="UTF-8">
	<table style="margin-bottom:8px;">
<?php if(isset($result) && $result==1) { ?>
	<tr>
	<td></td>
	<td><label style="color:red;font-size:.8em;"><?php echo $l_err?></label></td>
	</tr>
<?php }?>
	<tr>
	<td class="td_info_label"><label class="dis_label"<?php echo ($afterForm && (!isset($_POST['lastname']) || empty($_POST['lastname'])) ? ' style="color:red"' : '')?>><?php echo $l_last_name?>:</label></td>
	<td class="td_info_input"><input name="lastname" id="lastname" class="prof_input_t" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" type="text" value="<?php echo (isset($_POST['lastname']) ? $_POST['lastname'] : $_SESSION['_loginUser']->lastname)?>" /><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"<?php echo ($afterForm && (!isset($_POST['firstname']) || empty($_POST['firstname'])) ? ' style="color:red"' : '')?>><?php echo $l_first_name?>:	</label></td>
	<td class="td_info_input"><input name="firstname" id="firstname" class="prof_input_t" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" type="text" value="<?php echo (isset($_POST['firstname']) ? $_POST['firstname'] : $_SESSION['_loginUser']->firstname)?>" /><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"><?php echo $l_login_email?>:</label></td>
	<td class="td_info_input"><label class="val_label"><?php echo $_SESSION['_loginUser']->login_email?></label></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"><?php echo $l_curr_city?>:</label></td>
	<td class="td_info_input"><input name="location" id="location" class="prof_input_t" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" type="text" value="<?php echo (isset($_POST['location']) ? $_POST['location'] : (isset($prof) ? $prof['location'] : ""))?>" /></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"><?php echo $l_birt_year?>:</label></td>
	<td class="td_info_input"><input name="b_year" id="b_year" class="prof_input_n" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" type="text" value="<?php echo (isset($_POST['b_year']) ? $_POST['b_year'] : (isset($prof) ? $prof['b_year'] : ""))?>" /></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"><?php  echo $l_birt_month?>:</label></td>
	<td class="td_info_input"><input name="b_month" id="b_month" class="prof_input_n" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" type="text" value="<?php echo (isset($_POST['b_month']) ? $_POST['b_month'] : (isset($prof) ? $prof['b_month'] : ""))?>" /></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"><?php echo $l_birt_day?>:</label></td>
	<td class="td_info_input"><input name="b_day" id="b_day" class="prof_input_n" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" type="text" value="<?php echo (isset($_POST['b_day']) ? $_POST['b_day'] : (isset($prof) ? $prof['b_day'] : ""))?>" /></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"><?php echo $l_interests?>:</label></td>
	<td class="td_info_input"><textarea name="interests" onfocus="javascript:setBackground(this, '#FFFBC1')" onblur="javascript:setBackground(this, '#FFF')" style="border:1px solid #AAA;height:80px;width:450px;"><?php echo (isset($_POST['interests']) ? $_POST['interests'] : (isset($prof) ? $prof['interests'] : ""))?></textarea>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label"<?php echo ($afterForm && (!isset($_POST['password']) || empty($_POST['password'])) ? ' style="color:red"' : '')?>><?php echo $l_password?>:</label></td>
	<td class="td_info_input"><input type="password" name="password" class="prof_input_p"/><span class="mandi_field"> *</span></td>
	</tr>
	</table>
	<div class="page_saperator"></div>
	<input type="hidden" name="hide_info" value="1" />
	<div style="margin-left:20px;margin-top:10px;">
	<input id="update_submit" class="button_input" onmousedown="mousePress('update_submit')" onmouseup="mouseRelease('update_submit')" onmouseout="mouseRelease('update_submit')" type="submit" value="<?php echo $l_submit_botton?>" style="margin-right:100px;" />
	<input id="update_cancel" class="button_input" onmousedown="mousePress('update_cancel')" onmouseup="mouseRelease('update_cancel')" onmouseout="mouseRelease('update_cancel')" onclick="window.location='../home/profile.php'" type="button" value="<?php echo $l_cancel_botton?>" />
	</div>
	</form>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
