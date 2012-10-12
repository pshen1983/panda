<?php 
include_once ("../common/Objects.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/SearchDBUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);
$output = '';

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Search Workitem | ProjNote';
	$l_proj = 'Select Project';
	$l_wi_id = 'Workitem ID';
	$l_wi_summary = 'Workitem Summary';
	$l_wi_owner = 'Owner';
	$l_wi_creator = 'Creator';
	$l_create_date = 'Create Date';
	$l_last_update = 'Last Update Date';
	$l_deadline = 'Deadline';
	$l_comp = 'Component';
	$l_wp = 'Workpackage';
	$l_type = 'Type';
	$l_status = 'Status';
	$l_priority = 'Priority';
	$l_from = 'From';
	$l_to = 'To';
	$l_search = 'Search';

	$l_proj_dis = 'Project';
	$l_wi_id_dis = 'ID';

	$l_search_header = 'Workitem Search Result';
	$l_empty = '(empty)';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#24037;&#20316;&#39033;&#25628;&#32034; | ProjNote';
	$l_proj = '&#36873;&#25321;&#39033;&#30446;';
	$l_wi_id = '&#24037;&#20316;&#39033;&#21495;';
	$l_wi_summary = '&#31616;&#20171;';
	$l_wi_owner = '&#25152;&#26377;&#20154;';
	$l_wi_creator = '创建者';
	$l_create_date = '&#21019;&#24314;&#26102;&#38388;';
	$l_last_update = '&#26368;&#36817;&#19968;&#27425;&#20462;&#25913;&#26102;&#38388;';
	$l_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_comp = '&#39033;&#30446;&#32452;';
	$l_wp = '工作包';
	$l_type = '&#31867;&#21035;';
	$l_status = '&#29366;&#24577;';
	$l_priority = '&#20248;&#20808;&#24230;';
	$l_from = '&#20174;';
	$l_to = '&#33267;';
	$l_search = '&#25628;&#32034;';

	$l_proj_dis = '&#39033;&#30446;';
	$l_wi_id_dis = '&#39033;&#21495;';

	$l_search_header = '&#24037;&#20316;&#39033;&#25628;&#32034;&#32467;&#26524;';
	$l_empty = '&#65288;&#31354;&#65289;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}

//=========================================================================================================

if (isset($_POST['project']) && is_numeric($_POST['project']))
{
	if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_POST['project']))
	{
		$proj = $_POST['project'];
		$comp = $_POST['component'];
//		$wp = $_POST['workpackage'];
		$ownr = $_POST['owner'];
		$crea = $_POST['creator'];
		$type = $_POST['type'];
		$stat = $_POST['status'];
		$prio = $_POST['priority'];
		$wiid = $_POST['id_input'];
		$wiob = $_POST['objective_input'];
		$cr_s = $_POST['work_create_date_start'];
		$cr_e = $_POST['work_create_date_end'];
		$lu_s = $_POST['work_last_update_start'];
		$lu_e = $_POST['work_last_update_end'];
		$dl_s = $_POST['work_deadline_start'];
		$dl_e = $_POST['work_deadline_end'];
		
		$wis = SearchDBUtil::getWorkItems( isset($wiid) && is_numeric($wiid) ? $wiid : null,
										   $proj,
										   isset($comp) && is_numeric($comp) ? $comp : null,
										   isset($wp) && is_numeric($wp) ? $wp : null,
										   isset($ownr) && is_numeric($ownr) ? $ownr : null,
										   isset($crea) && is_numeric($crea) ? $crea : null,
										   isset($wiob) && !empty($wiob) ? $wiob : null,
										   isset($stat) && !empty($stat) ? $stat : null,
										   isset($type) && !empty($type) ? $type : null,
										   isset($prio) && !empty($prio) ? $prio : null,
										   isset($cr_s) && !empty($cr_s) ? $cr_s : null,
										   isset($cr_e) && !empty($cr_e) ? $cr_e : null,
										   isset($lu_s) && !empty($lu_s) ? $lu_s : null,
										   isset($lu_e) && !empty($lu_e) ? $lu_e : null,
										   isset($dl_s) && !empty($dl_s) ? $dl_s : null,
										   isset($dl_e) && !empty($dl_e) ? $dl_e : null );
		if(isset($wis)) 
		{
			$table = array();
			$index = 0;
			$table[$index] = array($l_wi_id_dis, $l_wi_summary, $l_wi_owner, $l_wi_creator, $l_status, $l_type, $l_priority, /*$l_wp,*/ $l_comp, $l_deadline);
	
//			$project = DatabaseUtil::getProj($proj);
			while($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
			{
				$userO = DatabaseUtil::getUser($wi['owner_id']);
				$userC = DatabaseUtil::getUser($wi['creator_id']);
				$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_STATUS, $wi['status']);
				$type = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_TYPE, $wi['type']);
				$priority = DatabaseUtil::getEnumDescription(DatabaseUtil::$PRIORITY, $wi['priority']);

				if(isset($wi['comp_id'])) {
					$comp = DatabaseUtil::getComp($wi['comp_id']);
					$comp_content = '<a href="../project/project_component.php?c_id='.$wi["comp_id"].'&sid='.$comp["s_id"].'" title="'.str_replace('"', '&quot;', $comp["title"]).'">'.CommonUtil::truncate($comp["title"], 16).'</a>';
				}
				if(isset($wi['workpackage_id'])) {
					$wp = DatabaseUtil::getWorkPackage($wi['workpackage_id']);
					$wp_content = '<a href="../project/work_package.php?wp_id='.$wi["workpackage_id"].'&sid='.$wp["s_id"].'" title="'.str_replace('"', '&quot;', $wp["objective"]).'">'.CommonUtil::truncate($wp["objective"], 16).'</a>';
				}		
		
				$o_name = ($_SESSION['_language'] == 'zh') ? $userO['lastname'].$userO['firstname'] : CommonUtil::truncate($userO['firstname']." ".$userO['lastname'], 16);
				$c_name = ($_SESSION['_language'] == 'zh') ? $userC['lastname'].$userC['firstname'] : CommonUtil::truncate($userC['firstname']." ".$userC['lastname'], 16);
				$index = $index + 1;
				$wititle = '<a href="../project/work_item.php?wi_id='.$wi["id"].'&sid='.$wi["s_id"].'" title="'.str_replace('"', '&quot;', $wi["title"]).'">'.$wi["title"].'</a>';
				$table[$index] = array( str_pad($wi['pw_id'], 4, "0", STR_PAD_LEFT),
										$wititle, 
										$o_name,
										$c_name,
										$status,
										'<img class="enum_img" src="../image/type/'.$wi['type'].'.gif" />'.$type,
										'<img class="enum_img" src="../image/priority/'.$wi['priority'].'.gif" />'.$priority,
										//isset($wi['workpackage_id']) ? $wp_content : "-",
										isset($wi['comp_id']) ? $comp_content : "-",
										$wi['deadline']
									  );
			}
			
			$sortColumn =
				"<script id='filter_bar_js' type='text/javascript'>
				$(function() {
					$('table')
						.tablesorter({widthFixed: true, widgets: ['zebra']})
				});
				var table_Props = 	{	col_0: \"none\",
										col_1: \"none\",
										col_2: \"select\",
										col_3: \"select\",
										col_4: \"select\",
										col_5: \"select\",
										col_6: \"select\",
										col_7: \"select\",
										col_8: \"none\",
										display_all_text: \"\",
										sort_select: false 
									};
				setFilterGrid( \"search_result_table\",table_Props );
				</script>";
		
			$output = CommonUtil::getTable( $table, 
									   $sortColumn, 
									   "<label style='color:black;font-size:1em;font-weight:bold'>".$l_search_header.":</label>", 
									   null, 
									   null, 
									   "work_list_table", 
									   null, 
									   'search_result_table',
									   'search_result_table',
									   array(5, 35, 10, 10, 8, 6, 7, 10, 9)
									  );
		}
		else $output='<label style="color:red;font-size:.8em;">You do NOT have enough privilege to search workitems in this project!</label>';
	}
	else {
		$output = CommonUtil::getTable( array(), 
								   null, 
								   "<label style='color:black;font-size:1em;font-weight:bold'>".$l_search_header.":</label>", 
								   null, 
								   null, 
								   "work_list_table", 
								   $l_empty, 
								   'search_result_table',
								   'search_result_table'
								  );
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/search_layout.css' />
	<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
<script type='text/javascript' src="../js/common.js"></script>
<script type='text/javascript' src="../js/search.js"></script>
	<script type='text/javascript' src="../js/calendar_us.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div style="width:75%;">
<form method="post" enctype="multipart/form-data" action="workitem.php" name="search_workitem" id="search_workitem" onSubmit="javascript:searchWIFormOnSubmit()" accept-charset="UTF-8">
<div style="padding-top:10px;padding-bottom:5px;">
<label class="search_label"><?php echo $l_proj?>:</label>
<!-- select style="width:200px;" name="project" id="project" onchange="javascript:getProjComp('component', 'project');javascript:getProjWp('workpackage', 'project');javascript:getProjUser('owner', 'project');javascript:getProjUser('creator', 'project');javascript:wiSearchEnDi()" -->
<select style="width:200px;" name="project" id="project" onchange="javascript:getProjComp('component', 'project');javascript:getProjUser('owner', 'project');javascript:getProjUser('creator', 'project');javascript:wiSearchEnDi()">
<option value=""></option>
<?php 
$projs = DatabaseUtil::getUserProjList($_SESSION['_userId']);
while($proj = mysql_fetch_array($projs, MYSQL_ASSOC)){
	echo '<option value="'.$proj['id'].'" ';
	if (isset($_POST['project']))
		echo ($proj['id']==$_POST['project'] ? 'SELECTED':'');
	else if(isset($_SESSION['_project']))
		echo ($proj['id']==$_SESSION['_project']->id ? 'SELECTED':'');
	echo '>'.$proj['title'].'</option>';
}
?>
</select>
</div>
<div class="workitem_search_div">
<table class="workitem_search_table">
<tr>
<td><label  class="search_label"><?php echo $l_wi_id?>:</label></td>
<td colspan="7"><input <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="id_input" name="id_input" type="text" maxlength="254" value="<?php echo (isset($_POST['id_input']) ? $_POST['id_input'] : "")?>" /><span id="id_input_span"></span></td>
</tr>
<tr>
<td><label class="search_label"><?php echo $l_wi_summary?>:</label></td>
<td colspan="7"><input <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="objective_input" name="objective_input" type="text" maxlength="254" value="<?php echo (isset($_POST['objective_input']) ? $_POST['objective_input'] : "")?>" /><span id="objective_input_span"></span></td>
</tr>
<tr>
<td><label class="search_label"><?php echo $l_wi_owner?>:</label></td>
<td colspan="7"><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>class="work_user_id" id="owner" name="owner">
<option value=""></option>
<?php if(isset($_SESSION['_project']) || isset($_POST['project'])) {
	$_GET['p']= (isset($_POST['project']) ? $_POST['project'] : $_SESSION['_project']->id); 
	$_GET['i']= (isset($_POST['owner']) ? $_POST['owner'] : null);
	include '../project/get_proj_user.inc.php';
	unset($_GET['i']);
	unset($_GET['p']);
}?>
</select><span id="owner_span"></span></td>
</tr>
<tr>
<td><label class="search_label"><?php echo $l_wi_creator?>:</label></td>
<td colspan="7"><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>class="work_user_id" id="creator" name="creator">
<option value=""></option>
<?php if(isset($_SESSION['_project']) || isset($_POST['project'])) {
	$_GET['p']= (isset($_POST['project']) ? $_POST['project'] : $_SESSION['_project']->id); 
	$_GET['i']= (isset($_POST['creator']) ? $_POST['creator'] : null);
	include '../project/get_proj_user.inc.php';
	unset($_GET['i']);
	unset($_GET['p']);
}?>
</select><span id="creator_span"></span></td>
</tr>
<tr>
<td>
<label class="search_label"><?php echo $l_create_date?>:</label>
</td>
<td colspan="7">
<label class="search_label_date"><?php echo $l_from?>: </label>
<input <?php echo isset($_SESSION['_project'])||isset($_POST['work_create_date_start']) ? 'style="background-color:white;" ' : "";?>disabled type="text" id="work_create_date_start" name="work_create_date_start" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['work_create_date_start']) ? $_POST['work_create_date_start'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_workitem','controlname': 'work_create_date_start'});</script>
<label class="search_label_date" style="padding-left:30px;"><?php echo $l_to?>: </label>
<input <?php echo isset($_SESSION['_project'])||isset($_POST['work_create_date_end']) ? 'style="background-color:white;" ' : "";?>disabled type="text" id="work_create_date_end" name="work_create_date_end" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['work_create_date_end']) ? $_POST['work_create_date_end'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_workitem','controlname': 'work_create_date_end'});</script>
</td>
</tr>
<tr>
<td>
<label class="search_label"><?php echo $l_last_update?>:</label>
</td>
<td colspan="7">
<label class="search_label_date" style="font-weight:normal;"><?php echo $l_from?>: </label>
<input <?php echo isset($_SESSION['_project'])||isset($_POST['work_last_update_start']) ? 'style="background-color:white;" ' : "";?>disabled type="text" id="work_last_update_start" name="work_last_update_start" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['work_last_update_start']) ? $_POST['work_last_update_start'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_workitem','controlname': 'work_last_update_start'});</script>
<label class="search_label_date" style="padding-left:30px;"><?php echo $l_to?>: </label>
<input <?php echo isset($_SESSION['_project'])||isset($_POST['work_last_update_end']) ? 'style="background-color:white;" ' : "";?>disabled type="text" id="work_last_update_end" name="work_last_update_end" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['work_last_update_end']) ? $_POST['work_last_update_end'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_workitem','controlname': 'work_last_update_end'});</script>
</td>
</tr>
<tr style="margin-bottom:20px;">
<td>
<label class="search_label"><?php echo $l_deadline?>:</label>
</td>
<td colspan="7">
<label class="search_label_date" style="font-weight:normal;"><?php echo $l_from?>: </label>
<input <?php echo isset($_SESSION['_project'])||isset($_POST['work_deadline_start']) ? 'style="background-color:white;" ' : "";?>disabled type="text" id="work_deadline_start" name="work_deadline_start" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['work_deadline_start']) ? $_POST['work_deadline_start'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_workitem','controlname': 'work_deadline_start'});</script>
<label class="search_label_date" style="padding-left:30px;"><?php echo $l_to?>: </label>
<input <?php echo isset($_SESSION['_project'])||isset($_POST['work_deadline_end']) ? 'style="background-color:white;" ' : "";?>disabled type="text" id="work_deadline_end" name="work_deadline_end" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['work_deadline_end']) ? $_POST['work_deadline_end'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_workitem','controlname': 'work_deadline_end'});</script>
</td>
</tr>
<tr>
<td><label class="search_label"><?php echo $l_comp?>:</label></td>
<!-- td><label class="search_label"><?php echo $l_wp?>:</label></td -->
<td><label class="search_label"><?php echo $l_type?>:</label></td>
<td><label class="search_label"><?php echo $l_status?>:</label></td>
<td><label class="search_label"><?php echo $l_priority?>:</label></td>
</tr>
<tr>
<td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="component" id="component" onchange="javascript:getCompWpSearch('project', 'component', 'workpackage')">
<option value=""></option>
<?php if(isset($_SESSION['_project']) || isset($_POST['project'])) {
	$_GET['p']= (isset($_POST['project']) ? $_POST['project'] : $_SESSION['_project']->id); 
	if (isset($_POST['component'])) $_GET['i']=$_POST['component'];
	else $_GET['i']=(isset($_SESSION['_component']) ? $_SESSION['_component']->id : null);
	include_once '../project/get_proj_comp.inc.php';
	unset($_GET['i']);
	unset($_GET['p']);
}?>
</select><span id="component_span"></span></td>
<!-- td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="workpackage" name="workpackage">
<option value=""></option>
<?php
if(isset($_SESSION['_component']) || (isset($_POST['component']) && !empty($_POST['component']))) {
	$_GET['c']= (isset($_POST['component']) ? $_POST['component'] : $_SESSION['_component']->id); 
	if (isset($_POST['workpackage'])) $_GET['i']=$_POST['workpackage'];
	else $_GET['i']=(isset($_SESSION['_workpackage']) ? $_SESSION['_workpackage']->id : null);
	include_once '../project/get_comp_wp.inc.php';
	unset($_GET['i']);
	unset($_GET['c']);
}
else if(isset($_SESSION['_project']) || isset($_POST['project'])) {
	$_GET['p']= (isset($_POST['project']) ? $_POST['project'] : $_SESSION['_project']->id); 
	if (isset($_POST['workpackage'])) $_GET['i']=$_POST['workpackage'];
	else $_GET['i']=(isset($_SESSION['_workpackage']) ? $_SESSION['_workpackage']->id : null);
	include_once '../project/get_proj_wp.inc.php';
	unset($_GET['i']);
	unset($_GET['p']);
}
?>
</select><span id="workpackage_span"></span></td -->
<td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="type" id="type">
<option value=""></option>
<?php 
	$wi_type = $_SESSION[DatabaseUtil::$WI_TYPE];
	foreach($wi_type as $row_type)
		echo '<option value="'. $row_type['code'] .'"'.(isset($_POST['type']) && $_POST['type']==$row_type['code'] ? " SELECTED" : "").'>'. $row_type['description'] .'</option><br />';
?></select><div id="type_span"></div></td>
<td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="status" id="status">
<option value=""></option>
<?php
	$wi_status = $_SESSION[DatabaseUtil::$WI_STATUS];
	foreach($wi_status as $row_status)
		echo '<option value="'. $row_status['code'] . ($row_status['code']==$_POST['status'] ? '" SELECTED ' : '"') .'>'. $row_status['description'] .'</option><br />';
?>
</select><div id="status_span"></div></td>
<td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="priority" id="priority">
<option value=""></option>
<?php 
	$wi_priority = $_SESSION[DatabaseUtil::$PRIORITY];
	foreach($wi_priority as $row_priority)
		echo '<option value="'. $row_priority['code'] .'"'.(isset($_POST['priority']) && $_POST['priority']==$row_priority['code'] ? " SELECTED" : "").'>'. $row_priority['description'] .'</option><br />';
?></select><div id="priority_span"></div></td>
<td><input <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="search_submit_button" class="search_submit_button" onmousedown="mousePress('search_submit_button')" onmouseup="mouseRelease('search_submit_button')" onmouseout="mouseRelease('search_submit_button')" type="submit" value="<?php echo $l_search?>" /></td>
</tr>
</table>
</div>
</form></div>
<div id="search_result"><?php echo $output;?></div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
