<?php
include_once ("../common/Objects.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( !SecurityUtil::canUpdateProjectInfo() ) {
	header( 'Location: ../home/index.php' ) ;
}

include_once ("language/l_index.inc.php");

$proj = $_SESSION['_project'];

$mems = DatabaseUtil::getUserListByProj($proj->id);
$roles = DatabaseUtil::getEnumList(DatabaseUtil::$RELATION);
$role_array = array();

while($role = mysql_fetch_array($roles, MYSQL_ASSOC)) {
	if(!CommonUtil::isManagement($role['code']))
		$role_array[$role['code']] = $role['description'];
}
$c_o_old = $proj->create_date;
$c_o_now = date('Y-m-d', mktime(0,0,0,date("m"),date("d"),date("Y")));
$n_o_old = $proj->create_date;
$n_o_now = date('Y-m-d', mktime(0,0,0,date("m"),date("d"),date("Y")));
$clos_now = date('Y-m-d', mktime(0,0,0,date("m"),date("d"),date("Y")));
$clos_dur = 7;
$crea_now = date('Y-m-d', mktime(0,0,0,date("m"),date("d"),date("Y")));
$crea_dur = 7;

function getSelect($array, $in, $u_id)
{
	$output = '<select id="sel_'.$u_id.'" class="role_list">';
	foreach($array as $code=>$desc) {
		$output.= '<option value="'.$code.($code==$in ? '" SELECTED ' : '"').'>'.$desc.'</option>';
	}
	$output.= '</select>';

	return $output;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<script type='text/javascript' src="../js/calendar_us.js"></script>
<script type='text/javascript' src="../js/jquery.js"></script>
<script type='text/javascript' src="../js/jquery.base64.min.js"></script>
<script type='text/javascript' src="../js/common.js"></script>
<script type='text/javascript' src="../js/admin.js"></script>
<script type="text/javascript">$(document).ready(function() {setInterval( longpollLeftNav, 5000 );});</script>
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/admin_layout.css' />
<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
<style type="text/css">
div.stat_img_s{width:480px;height:300px;background:url('../image/process_bar.gif') no-repeat center; }
div.stat_img_l{width:650px;height:300px;background:url('../image/process_bar.gif') no-repeat center; }
</style>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<div id="left_nav"><?php include_once '../common/left_nav.inc.php';?></div>
<div id="main_body_noright">
<div class="path_nav"><?php include_once '../common/path_nav.inc.php';?></div>
<div id="top_link_saperator"></div>
<div id="proj_func" class="ad_sec_info">
<label class="ad_sec_title"><?php echo $l_proj_func.CommonUtil::truncate($proj->title, 61)?></label>
<a id="mem_list_link" href="javascript:showHideDiv('double_arrow_incom', 'mem_list_div')"><img id='double_arrow_incom' class='double_arrow' src='../image/common/double_arrow_down.png'></img></a>
<div id="mem_list_div" class="ad_detail_info">
<table id="mem_list"><?php
while($mem = mysql_fetch_array($mems, MYSQL_ASSOC)){
	$user = DatabaseUtil::getUser($mem['u_id']);
	echo '<tr>
		  <td></td>
		  <td><label class="ad_dis_label">'.(($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['firstname'].' '.$user['lastname']).'</label></td>
		  <td><label class="ad_dis_label">( '.$user['login_email'].' )</label></td>
		  <td>'.(!CommonUtil::isManagement($mem['role']) ? getSelect($role_array, $mem['role'], $mem['u_id']) : '<label style="font-size:.8em;">'.DatabaseUtil::getEnumDescription(DatabaseUtil::$RELATION, $mem['role']).'</label>').'</td>
		  <td><input id="hid_'.$mem['u_id'].'" type="hidden" value="'.$mem['u_id'].'" /></td>
		  <td>'.(!CommonUtil::isManagement($mem['role']) ? '<a href="javascript:adminUpdateUser(\''.$mem['u_id'].'\', \'sel_'.$mem['u_id'].'\')">'.$l_update.'</a>' : '<label style="font-size:.8em;color:#666;">'.$l_update.'</label>').'</td>
		  <td>'.(!CommonUtil::isManagement($mem['role']) ? '<a href="javascript:adminDeleteUser(\''.$mem['u_id'].'\')">'.$l_delete.'</a>' : '<label style="font-size:.8em;color:#666;">'.$l_delete.'</label>').'</td>
		  <td></td>
		  </tr>
		  <tr><td colspan="8"><div style="height:2px;" class="page_saperator"></div></td></tr>';
}
?></table>
	</div>
	</div>
	<div id="top_link_saperator"></div>
	<div id="proj_func" class="ad_sec_info">
	<label class="ad_sec_title"><?php echo $l_proj_stat.$proj->title?></label>
	<div id="open_close_wi_div" class="stat_sec" style="margin-left:100px;#margin-left:-50px">
	<div style="margin-top:20px;margin-bottom:20px;"><label class="ad_dis_label"><?php echo $l_o_c_wi_pic?></label></div>
	<form method="post" action="index.php#c_o" id="c_o_dates_input_form" name="c_o_dates_input_form" onsubmit="document.getElementById('c_o_start_date').disabled=false;document.getElementById('c_o_end_date').disabled=false;" accept-charset="UTF-8">
	<label class="ad_val_label"><?php echo $l_from?>: </label>
	<input class="date_pick" disabled type="text" id="c_o_start_date" name="c_o_start_date" title="<?php echo $l_calendar?>" value="<?php echo $c_o_old?>" />
	<script language="JavaScript">new tcal ({'formname': 'c_o_dates_input_form','controlname': 'c_o_start_date'});</script>
	<label class="ad_val_label"><?php echo $l_to?>: </label>
	<input class="date_pick" disabled type="text" id="c_o_end_date" name="c_o_end_date" title="<?php echo $l_calendar?>" value="<?php echo $c_o_now?>" />
	<script language="JavaScript">new tcal ({'formname': 'c_o_dates_input_form','controlname': 'c_o_end_date'});</script>
	<input class="submit_button" onclick="javascript:updatecoPic();" onmousedown="mousePress('c_o_update_list_button');" onmouseup="mouseRelease('c_o_update_list_button');" onmouseout="mouseRelease('c_o_update_list_button');" type="button" value="<?php echo $l_update?>" id="c_o_update_list_button" />
	<input type="submit" style="display:none;"/>
	</form>
	<div style="float:right;margin-top:80px;position:relative;right:20px;">
	<table>
	<tr>
	<td><label class="ad_dis_label"><?php echo $l_create?></label></td>
	<td><img src="../image/admin/green.png" /></td>
	</tr>
	<tr>
	<td><label class="ad_dis_label"><?php echo $l_close?></label></td>
	<td><img src="../image/admin/red.png" /></td>
	</tr>
	</table>
	</div>
	<div class="stat_img_s"><img id="c_o_wi" src="g_open_close_wi.inc.php?s=<?php echo $c_o_old?>&e=<?php echo $c_o_now?>" /></div>
	</div>
	<div class="page_saperator" style="position:relative;left:8%;#left:0px;"></div>
	<div id="open_close_wi_div" class="stat_sec" style="margin-left:100px;#margin-left:-50px">
	<div style="margin-top:20px;margin-bottom:20px;"><label class="ad_dis_label"><?php echo $l_n_c_wi_pic?></label></div>
	<form method="post" action="index.php#n_o" id="n_o_dates_input_form" name="n_o_dates_input_form" accept-charset="UTF-8">
	<label class="ad_val_label"><?php echo $l_from?>: </label>
	<input class="date_pick" disabled type="text" id="n_o_start_date" name="n_o_start_date" title="<?php echo $l_calendar?>" value="<?php echo $n_o_old?>" />
	<script language="JavaScript">new tcal ({'formname': 'n_o_dates_input_form','controlname': 'n_o_start_date'});</script>
	<label class="ad_val_label"><?php echo $l_to?>: </label>
	<input class="date_pick" disabled type="text" id="n_o_end_date" name="n_o_end_date" title="<?php echo $l_calendar?>" value="<?php echo $n_o_now?>" />
	<script language="JavaScript">new tcal ({'formname': 'n_o_dates_input_form','controlname': 'n_o_end_date'});</script>
	<input class="submit_button" onclick="javascript:updateNoPic();" onmousedown="mousePress('n_o_update_list_button');" onmouseup="mouseRelease('n_o_update_list_button');" onmouseout="mouseRelease('n_o_update_list_button');" type="button" value="<?php echo $l_update?>" id="n_o_update_list_button" />
	<input type="submit" style="display:none;"/>
	</form>
	<div style="float:right;margin-top:80px;position:relative;right:20px;">
	<table>
	<tr>
	<td><label class="ad_dis_label"><?php echo $l_open?></label></td>
	<td><img src="../image/admin/blue.png" /></td>
	</tr>
	</table>
	</div>
	<div class="stat_img_s"><img id="n_o_wi" src="g_num_open_wi.inc.php?s=<?php echo $n_o_old?>&e=<?php echo $n_o_now?>" /></div>
	</div>
	<div class="page_saperator" style="position:relative;left:8%;#left:0px;"></div>
	<div id="open_close_wi_div" class="stat_sec" style="margin-left:100px;#margin-left:-50px">
	<div style="margin-top:20px;margin-bottom:20px;"><label class="ad_dis_label"><?php echo $l_crea_wi_pic?></label></div>
	<form method="post" action="index.php#n_o" id="crea_dates_input_form" name="crea_dates_input_form" accept-charset="UTF-8">
	<label class="ad_val_label"><?php echo $l_period?></label>
	<select id="crea_dur">
	<option value="7" SELECTED><?php echo $l_duration_2?></option>
	<option value="14"><?php echo $l_duration_3?></option>
	<option value="28"><?php echo $l_duration_4?></option>
	<option value="91"><?php echo $l_duration_5?></option>
	<option value="183"><?php echo $l_duration_6?></option>
	<option value="365"><?php echo $l_duration_7?></option>
	</select>
	<label class="ad_val_label"><?php echo $l_before?></label>
	<input class="date_pick" disabled type="text" id="crea_end_date" name="crea_end_date" title="<?php echo $l_calendar?>" value="<?php echo $crea_now?>" />
	<script language="JavaScript">new tcal ({'formname': 'crea_dates_input_form','controlname': 'crea_end_date'});</script>
	<input class="submit_button" onclick="javascript:updateCreatePic();" onmousedown="mousePress('crea_update_list_button');" onmouseup="mouseRelease('crea_update_list_button');" onmouseout="mouseRelease('crea_update_list_button');" type="button" value="<?php echo $l_update?>" id="crea_update_list_button" />
	<input type="submit" style="display:none;"/>
	</form>
	<div style="float:right;margin-top:80px;position:relative;right:80px;">
	</div>
	<div class="stat_img_l"><img id="crea_wi" src="g_open_wi_ot.inc.php?e=<?php echo $crea_now?>&d=<?php echo $crea_dur?>" /></div>
	</div>
	<div class="page_saperator" style="position:relative;left:8%;#left:0px;"></div>
	<div id="open_close_wi_div" class="stat_sec" style="margin-left:100px;#margin-left:-50px">
	<div style="margin-top:20px;margin-bottom:20px;"><label class="ad_dis_label"><?php echo $l_clos_wi_pic?></label></div>
	<form method="post" action="index.php#n_o" id="clos_dates_input_form" name="clos_dates_input_form" accept-charset="UTF-8">
	<label class="ad_val_label"><?php echo $l_period?></label>
	<select id="clos_dur">
	<option value="7" SELECTED><?php echo $l_duration_2?></option>
	<option value="14"><?php echo $l_duration_3?></option>
	<option value="28"><?php echo $l_duration_4?></option>
	<option value="91"><?php echo $l_duration_5?></option>
	<option value="183"><?php echo $l_duration_6?></option>
	<option value="365"><?php echo $l_duration_7?></option>
	</select>
	<label class="ad_val_label"><?php echo $l_before?></label>
	<input class="date_pick" disabled type="text" id="clos_end_date" name="clos_end_date" title="<?php echo $l_calendar?>" value="<?php echo $clos_now?>" />
	<script language="JavaScript">new tcal ({'formname': 'clos_dates_input_form','controlname': 'clos_end_date'});</script>
	<input class="submit_button" onclick="javascript:updateClosePic();" onmousedown="mousePress('clos_update_list_button');" onmouseup="mouseRelease('clos_update_list_button');" onmouseout="mouseRelease('clos_update_list_button');" type="button" value="<?php echo $l_update?>" id="clos_update_list_button" />
	<input type="submit" style="display:none;"/>
	</form>
	<div style="float:right;margin-top:80px;position:relative;right:80px;">
	</div>
	<div class="stat_img_l"><img id="clos_wi" src="g_close_wi_ot.inc.php?e=<?php echo $clos_now?>&d=<?php echo $clos_dur?>" /></div>
	</div>
	</div>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
