<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = '';
	$l_back_prof = 'Back to My Profile';
	
	$l_more_school = 'Add more education history';

	$l_school = 'School';
	$l_department = 'Department';
	$l_type= 'Type';
	$l_start_year = 'Start Year';
	$l_end_year = 'End Year';
	$l_present = 'still attending';
	
	$l_update = 'Update';
	$l_delete = 'Delete';
	
	$l_insert_succ = '* This education history has been successfully added.';
	$l_update_succ = '* This education history has been successfully updated.';
	$l_insert_fail = 'x System temporarily not available, please try again later.';
	$l_update_fail = 'x System temporarily not available, please try again later.';
	$l_general_fail = 'x System Error.';
	
	$l_submit_botton = 'Submit';
	$l_cancel_botton = 'Cancel';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '';
	$l_back_prof = '&#36820;&#22238;&#20010;&#20154;&#36164;&#26009;';

	$l_more_school = '&#28155;&#21152;&#26032;&#30340;&#25945;&#32946;&#21382;&#21490;';

	$l_school = '&#38498;&#26657;&#21517;&#31216;';
	$l_department = '&#31995;&#37096;&#21517;&#31216;';
	$l_type= '&#23398;&#20301;&#31181;&#31867;';
	$l_start_year = '&#20837;&#23398;&#24180;&#20221;';
	$l_end_year = '&#27605;&#19994;&#24180;&#20221;';
	$l_present = '&#20173;&#22312;&#23601;&#35835;';

	$l_update = '&#20462;&#25913;';
	$l_delete = '&#21024;&#38500;';

	$l_insert_succ = '* &#28155;&#21152;&#25104;&#21151;&#12290;';
	$l_update_succ = '* &#20462;&#25913;&#25104;&#21151;&#12290;';
	$l_insert_fail = 'x &#31995;&#32479;&#32321;&#24537;&#65292;&#35831;&#31245;&#21518;&#20877;&#35797;&#12290;';
	$l_update_fail = 'x &#31995;&#32479;&#32321;&#24537;&#65292;&#35831;&#31245;&#21518;&#20877;&#35797;&#12290;';
	$l_general_fail = 'x &#31995;&#32479;&#38169;&#35823;&#12290;';

	$l_submit_botton = '&#30830;&#23450;';
	$l_cancel_botton = '&#21462;&#28040;';
}

//=========================================================================================================

$high_light = 'onfocus="javascript:setBackground(this, \'#FFFBC1\')" onblur="javascript:setBackground(this, \'#FFF\')"';
$count = 0;
$display = 0;
$results = array();
$message = array();
$isPost = isset($_POST['hide_info']) && is_numeric($_POST['hide_info']);

if( isset($_GET['n']) && is_numeric($_GET['n']) && $_GET['n']>0 )
{
	$display = ($_GET['n']<10 ? $_GET['n'] : 9);
}

if( $isPost )
{
	for( $ii=0; $ii<=$_POST['hide_info']; $ii++)
	{
		if(isset($_POST['school_'.$ii])) $display = $ii;
		if( isset($_POST['school_'.$ii]) && !empty($_POST['school_'.$ii]) && 
			isset($_POST['depart_'.$ii]) && !empty($_POST['depart_'.$ii]) && 
			isset($_POST['type_'.$ii]) && !empty($_POST['type_'.$ii]) && 
			isset($_POST['start_'.$ii]) && is_numeric($_POST['start_'.$ii]) && 
			isset($_POST['end_'.$ii]) && is_numeric($_POST['end_'.$ii]) &&
			isset($_POST['educ_'.$ii]) && is_numeric($_POST['educ_'.$ii]) )
		{
			$scho = $_POST['school_'.$ii];
			$depa = $_POST['depart_'.$ii];
			$type = $_POST['type_'.$ii];
			$star = $_POST['start_'.$ii];
			$end_ = $_POST['end_'.$ii];

			if($_POST['educ_'.$ii]==0) {
				if (DatabaseUtil::insertEducation($_SESSION['_userId'], $type, $scho, $depa, $star, $end_))
				{
					$results[$ii] = 0;
					$message[$ii] = $l_insert_succ;
				}
				else {
					$results[$ii] = 1;
					$message[$ii] = $l_insert_fail;
				}
			}
			else if (DatabaseUtil::updateEducation($_POST['educ_'.$ii], $_SESSION['_userId'], $type, $scho, $depa, $star, $end_))
			{
				$results[$ii] = 0;
				$message[$ii] = $l_update_succ;
			}
			else {
				$results[$ii] = 1;
				$message[$ii] = $l_update_fail;
			}
		}
	}
}

$educs = DatabaseUtil::getEducations($_SESSION['_userId']);
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
	<div style="margin-bottom:30px;width:560px;">
	<div class="add_more">
	<a href="javascript:addMoreEduc('hide_info')"><?php echo $l_more_school?></a>
	</div>
	<form method="post" enctype="multipart/form-data" action="education_history.php" name="educ_form" id="educ_form" accept-charset="UTF-8">
<?php while($educ = mysql_fetch_array($educs, MYSQL_ASSOC))	{
$no_disable = $isPost && isset($_POST['educ_up_'.$count]) && $_POST['educ_up_'.$count]=='true' && !isset($results[$count]);
?>
<div id="educ_div_<?php echo $count?>">
<div class="educ_resu">
<?php if(isset($results[$count])) {?>
<label class="<?php echo $results[$count]==0 ? 'success_info' : 'err_info'?>"><?php echo $message[$count]?></label>
<?php }?>
</div>
	<div style="float:right;">
	<div style="margin-top:3px;"><a style="color:blue;font-size:.8em;" href="javascript:enableEducUpdate('<?php echo $count?>')"><?php echo $l_update?></a></div>
	<div style="margin-top:3px;"><a style="color:blue;font-size:.8em;" href="javascript:deleteEduc('<?php echo $educ['id']?>')"><?php echo $l_delete?></a></div>
	</div>
	<input type="hidden" id="educ_up_<?php echo $count?>" name="educ_up_<?php echo $count?>" value="<?php echo $no_disable ? 'true' : 'false'?>" />
	<input type="hidden" name="educ_<?php echo $count?>" value="<?php echo $educ['id']?>" />
	<table class="educ">
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && isset($_POST['educ_up_'.$count]) && $_POST['educ_up_'.$count]=='true' && (!isset($_POST['school_'.$count]) || empty($_POST['school_'.$count]))) echo 'style="color:red"';?>><?php echo $l_school?>:</label></td>
	<td class="td_info_input"><input class="educ_input_t" <?php echo $no_disable ? '' : 'disabled'?> id="school_<?php echo $count?>" name="school_<?php echo $count?>" value="<?php echo isset($_POST['school_'.$count]) ? $_POST['school_'.$count] : $educ['school']?>" <?php echo $high_light?> type="text" /><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && isset($_POST['educ_up_'.$count]) && $_POST['educ_up_'.$count]=='true' && (!isset($_POST['depart_'.$count]) || empty($_POST['depart_'.$count]))) echo 'style="color:red"';?>><?php echo $l_department?>:</label></td>
	<td class="td_info_input"><input class="educ_input_t" <?php echo $no_disable ? '' : 'disabled'?> id="depart_<?php echo $count?>" name="depart_<?php echo $count?>" value="<?php echo isset($_POST['depart_'.$count]) ? $_POST['depart_'.$count] : $educ['department']?>" <?php echo $high_light?> type="text" /><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && isset($_POST['educ_up_'.$count]) && $_POST['educ_up_'.$count]=='true' && (!isset($_POST['type_'.$count]) || empty($_POST['type_'.$count]))) echo 'style="color:red"';?>><?php echo $l_type?>:</label></td>
	<td class="td_info_input"><select class="educ_select" <?php echo $no_disable ? '' : 'disabled'?> id="type_<?php echo $count?>" name="type_<?php echo $count?>"><option></option>
<?php
	$types = $_SESSION[DatabaseUtil::$EDUCATION];
	foreach($types as $row)
		echo '<option value="'. $row['code'] . ($row['code']==(isset($_POST['type_'.$count]) ? $_POST['type_'.$count] : $educ['type']) ? '" SELECTED ' : '"') .'>'. $row['description'] .'</option>';
?></select><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && isset($_POST['educ_up_'.$count]) && $_POST['educ_up_'.$count]=='true' && (!isset($_POST['start_'.$count]) || !is_numeric($_POST['start_'.$count]))) echo 'style="color:red"';?>><?php echo $l_start_year?>:</label></td>
	<td class="td_info_input"><select class="educ_select" <?php echo $no_disable ? '' : 'disabled'?> id="start_<?php echo $count?>" name="start_<?php echo $count?>"><option></option>
<?php
	$t_year = date('Y');
	for($ii=$t_year; $ii>=1949; $ii--)
		echo '<option value="'.$ii.($ii==(isset($_POST['start_'.$count]) ? $_POST['start_'.$count] : $educ['year_start']) ? '" SELECTED ' : '"') .'>'. $ii .'</option>';
?></select><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && isset($_POST['educ_up_'.$count]) && $_POST['educ_up_'.$count]=='true' && (!isset($_POST['end_'.$count]) || !is_numeric($_POST['end_'.$count]))) echo 'style="color:red"';?>><?php echo $l_end_year?>:</label></td>
	<td class="td_info_input"><select class="educ_select" <?php echo $no_disable ? '' : 'disabled'?> id="end_<?php echo $count?>" name="end_<?php echo $count?>"><option></option>
	<option value="0" <?php echo $educ['year_end']==0 ? 'SELECTED': ''?>><?php echo $l_present?></option>
<?php
	$t_year = date('Y');
	for($ii=$t_year; $ii>=1949; $ii--)
		echo '<option value="'.$ii.($ii==(isset($_POST['end_'.$count]) ? $_POST['end_'.$count] : $educ['year_end']) ? '" SELECTED ' : '"') .'>'. $ii .'</option>';
?></select><span class="mandi_field"> *</span></td>
	</tr>
	</table>
	<div class="cross_separator"></div>
	</div>
<?php $count++; }
if ($display >= $count) {?>
<div id="educ_div_<?php echo $count?>">
<div class="educ_resu">
<?php if(isset($results[$count])) {?>
<label class="<?php echo $results[$count]==0 ? 'success_info' : 'err_info'?>"><?php echo $message[$count]?></label>
<?php }?>
</div>
	<div id="educ_div_<?php echo $count?>">
	<input type="hidden" name="educ_<?php echo $count?>" value="0" />
	<table class="educ">
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && (!isset($_POST['school_'.$count]) || empty($_POST['school_'.$count]))) echo 'style="color:red"';?>><?php echo $l_school?>:</label></td>
	<td class="td_info_input"><input class="educ_input_t" name="school_<?php echo $count?>" value="<?php echo isset($_POST['school_'.$count]) ? $_POST['school_'.$count] : ''?>" <?php echo $high_light?> type="text" /><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && (!isset($_POST['depart_'.$count]) || empty($_POST['depart_'.$count]))) echo 'style="color:red"';?>><?php echo $l_department?>:</label></td>
	<td class="td_info_input"><input class="educ_input_t" name="depart_<?php echo $count?>" value="<?php echo isset($_POST['depart_'.$count]) ? $_POST['depart_'.$count] : ''?>" <?php echo $high_light?> type="text" /><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && (!isset($_POST['type_'.$count]) || empty($_POST['type_'.$count]))) echo 'style="color:red"';?>><?php echo $l_type?>:</label></td>
	<td class="td_info_input"><select class="educ_select" name="type_<?php echo $count?>"><option></option>
<?php
	$types = $_SESSION[DatabaseUtil::$EDUCATION];
	foreach($types as $row)
		echo '<option value="'.$row['code'].($row['code']==(isset($_POST['type_'.$count]) ? $_POST['type_'.$count] : '') ? '" SELECTED ' : '"').'>'.$row['description'].'</option>';
?></select><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && (!isset($_POST['start_'.$count]) || !is_numeric($_POST['start_'.$count]))) echo 'style="color:red"';?>><?php echo $l_start_year?>:</label></td>
	<td class="td_info_input"><select class="educ_select" name="start_<?php echo $count?>"><option></option>
<?php
	$t_year = date('Y');
	for($ii=$t_year; $ii>=1949; $ii--)
		echo '<option value="'.$ii.($ii==(isset($_POST['start_'.$count]) ? $_POST['start_'.$count] : '') ? '" SELECTED ' : '"').'>'. $ii .'</option>';
?></select><span class="mandi_field"> *</span></td>
	</tr>
	<tr>
	<td class="td_info_label"><label class="dis_label" <?php if($isPost && (!isset($_POST['end_'.$count]) || !is_numeric($_POST['end_'.$count]))) echo 'style="color:red"';?>><?php echo $l_end_year?>:</label></td>
	<td class="td_info_input"><select class="educ_select" name="end_<?php echo $count?>"><option></option><option value="0"><?php echo $l_present?></option>
<?php
	$t_year = date('Y');
	for($ii=$t_year; $ii>=1949; $ii--)
		echo '<option value="'.$ii.($ii==(isset($_POST['end_'.$count]) ? $_POST['end_'.$count] : '') ? '" SELECTED ' : '"').'>'. $ii .'</option>';
?></select><span class="mandi_field"> *</span></td>
	</tr>
	</table>
	<div class="cross_separator"></div>
	</div>
<?php }?>
	</div>
	<input type="hidden" id="hide_info" name="hide_info" value="<?php echo $count?>" />
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
