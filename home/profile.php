<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$pers_info = 'Personal Information';

	$l_title = 'Edit My Profile | ProjNote';
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
	
	$present = 'Present';
}
else if($_SESSION['_language'] == 'zh') {
	$pers_info = '&#20010;&#20154;&#20449;&#24687;';

	$l_title = '&#20462;&#25913;&#20010;&#20154;&#36164;&#26009; | ProjNote';
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

	$present = '&#29616;&#22312;';
}

//=========================================================================================================

$hasPro = DatabaseUtil::doesProfileExist($_SESSION['_userId']);

if($hasPro) {
	$prof = DatabaseUtil::getProfile($_SESSION['_userId']);
	$educ = DatabaseUtil::getEducations($_SESSION['_userId']);
	$empl = DatabaseUtil::getEmployment($_SESSION['_userId']);
}
else {
	DatabaseUtil::insertProfile($_SESSION['_userId']);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/home_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
<script type='text/javascript' src="../js/jquery.js"></script>
<script type='text/javascript' src="../js/jquery-ext.js"></script>
<script type='text/javascript' src="../js/common.js"></script>
<script type="text/javascript">$(document).ready( function(){addProjectActionMenu();adjustHeight();});</script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<div id="left_nav"><?php include_once '../home/profile_left.inc.php';?></div>
<div id="right_nav"><?php $_GET['right_nav_creat']=1; include_once '../common/right_nav.inc.php'; unset($_GET['right_nav_creat']);?></div>
<div id="main_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div id="basic_info" class="sec_info">
<label class="sec_title"><?php echo $pers_info?></label>
<div id="personal_details">
<div class="detail_info">
<table>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $last_name?>:</label></td>
<td><label class="val_label"><?php echo $_SESSION['_loginUser']->lastname?></label></td>
</tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $first_name?>:</label></td>
<td><label class="val_label"><?php echo $_SESSION['_loginUser']->firstname?></label></td>
</tr>
<tr>
<td class="td_info_label"><label class="dis_label"><?php echo $login_email?>:</label></td>
<td><label class="val_label"><?php echo $_SESSION['_loginUser']->login_email?></label></td>
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
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
