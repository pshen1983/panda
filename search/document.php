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
	$l_title = 'Document Search | ProjNote';
	$l_doc_name = 'Document Name';
	$l_proj = 'Project';
	$l_comp = 'Component';
	$l_wp = 'Workpackage';
	$l_wi = 'Workitem';
	$l_upload_user = 'Uploaded by';
	$l_upload_time = 'Uploaded Time';
	$l_from = 'From';
	$l_to = 'To';
	$l_seach = 'Search';

	$l_search_header = 'Document Search Result';
	$l_empty = '(empty)';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#25991;&#26723;&#25628;&#32034; | ProjNote';
	$l_doc_name = '&#25991;&#26723;&#21517;';
	$l_proj = '&#25152;&#23646;&#39033;&#30446;';
	$l_comp = '&#25152;&#23646;&#39033;&#30446;&#32452;';
	$l_wp = '&#25152;&#23646;&#24037;&#20316;&#21253;';
	$l_wi = '&#25152;&#23646;&#24037;&#20316;&#39033;';
	$l_upload_user = '&#19978;&#20256;&#29992;&#25143;';
	$l_upload_time = '&#19978;&#20256;&#26102;&#38388;';
	$l_from = '&#20174;';
	$l_to = '&#33267;';
	$l_seach = '&#25628;&#32034;';

	$l_search_header = '&#25991;&#26723;&#25628;&#32034;&#32467;&#26524;';
	$l_empty = '&#65288;&#31354;&#65289;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}

//=========================================================================================================

if (isset($_POST['project']) && is_numeric($_POST['project']) )
{
	if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_POST['project']))
	{
		$name = $_POST['doc_name'];
		$proj = $_POST['project'];
		$owne = isset($_POST['owner']) ? $_POST['owner'] : null;
		$comp = isset($_POST['component']) ? $_POST['component'] : null;
		$wpid = isset($_POST['workpackage']) ? $_POST['workpackage'] : null;
		$wiid = isset($_POST['workitem']) ? $_POST['workitem'] : null;
		$ul_s = isset($_POST['doc_upload_start']) ? $_POST['doc_upload_start'] : null;
		$ul_e = isset($_POST['doc_upload_end']) ? $_POST['doc_upload_end'] : null;
	
		$docs = SearchDBUtil::getProjDocList( isset($name) && !empty($name) ? $name : null,
											  isset($owne) && is_numeric($owne) ? $owne : null,
											  isset($proj) && is_numeric($proj) ? $proj : null,
											  isset($comp) && is_numeric($comp) ? $comp : null,
											  isset($wpid) && is_numeric($wpid) ? $wpid : null,
											  isset($wiid) && is_numeric($wiid) ? $wiid : null,
											  isset($ul_s) && !empty($ul_s) ? $ul_s : null,
											  isset($ul_e) && !empty($ul_e) ? $ul_e : null  );
		if(isset($docs)) 
		{
			$table = array();
			$index = 0;
			$table[$index] = array($l_doc_name, $l_comp, /*$l_wp,*/ $l_wi, $l_upload_user, $l_upload_time);
			
			while($doc = mysql_fetch_array($docs, MYSQL_ASSOC))
			{
				$wititle = null;
				$wp_content = null;
				$comp_content = null;
	
				$user = DatabaseUtil::getUser($doc['updater']);
				$namelink = '<a style="text-decoration:none;" title="'.$doc['description'].'" href="../utils/download.inc.php?f='. str_replace(" ", "%20", $doc['s_id']) .'&s_id='. 3*($doc['p_id']+7) .'&id='.$doc["id"].'">'.$doc['title'].'</a>';
	
				if(isset($doc['comp_id']) && is_numeric($doc['comp_id'])) {
					$comp = DatabaseUtil::getComp($doc['comp_id']);
					$comp_content = '<a href="../project/project_component.php?c_id='.$doc['comp_id'].'&sid='.$comp["s_id"].'" title="'.str_replace('"', '&quot;', $comp["title"]).'">'.CommonUtil::truncate($comp["title"], 16).'</a>';
				}
				if(isset($doc['work_pid']) && is_numeric($doc['work_pid'])) {
					$wp = DatabaseUtil::getWorkPackage($doc['work_pid']);
					$wp_content = '<a href="../project/work_package.php?wp_id='.$doc['work_pid'].'&sid='.$wp["s_id"].'" title="'.str_replace('"', '&quot;', $wp["objective"]).'">'.CommonUtil::truncate($wp["objective"], 16).'</a>';
				}
				if(isset($doc['work_iid']) && is_numeric($doc['work_iid'])) {
					$wi = DatabaseUtil::getWorkItem($doc['work_iid']);
					$wititle = '<a href="../project/work_item.php?wi_id='.$doc['work_iid'].'&sid='.$wi["s_id"].'" title="'.str_replace('"', '&quot;', $wi["title"]).'">'.CommonUtil::truncate($wi["title"], 25).'</a>';
				}

				$user_name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : $user['firstname']." ".$user['lastname'];
				$index = $index + 1;
				$table[$index] = array( $namelink,
										isset($comp_content) ? $comp_content : "-",
										//isset($wp_content) ? $wp_content : "-",
										isset($wititle) ? $wititle : "-",
										$user_name,
										$doc['last_update']
									  );
			}
	
			$sortColumn =
				"<script id='filter_bar_js' type='text/javascript'>
				$(function() {
					$('table')
						.tablesorter({widthFixed: true, widgets: ['zebra']})
				});
				var table_Props = 	{	col_0: \"none\",
										col_1: \"select\",
										col_2: \"select\",
										col_3: \"select\",
										col_4: \"none\",
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
									   array(42, 12, 18, 13, 15)
									  );
		}
		else $output='<label style="color:red;font-size:.8em;">You do NOT have enough privilege to view documents in this project!</label>';
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
<div style="width:69%;padding-top:10px;">
<form method="post" enctype="multipart/form-data" action="document.php" name="search_doc" id="search_doc" onSubmit="javascript:searchDocFormOnSubmit()" accept-charset="UTF-8">
<div class="workitem_search_div">
<table class="doc_search_table">
<tr>
<td><label class="search_label"><?php echo $l_proj?>:</label></td>
<td colspan="2">
<!-- select name="project" id="project" onchange="javascript:getProjComp('component', 'project');javascript:getProjWp('workpackage', 'project');javascript:getProjWi('workitem', 'project');javascript:getProjUser('owner', 'project');javascript:docSearchEnDi()" -->
<select name="project" id="project" onchange="javascript:getProjComp('component', 'project');javascript:getProjWi('workitem', 'project');javascript:getProjUser('owner', 'project');javascript:docSearchEnDi()">
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
</select></td>
</tr>
<tr>
<td><label class="search_label"><?php echo $l_doc_name?>:</label></td>
<td colspan="3">
<input <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="doc_name" name="doc_name" type="text" maxlength="254" value="<?php echo (isset($_POST['doc_name']) ? $_POST['doc_name'] : "")?>" />
</td>
</tr>
<tr>
<td><label  class="search_label"><?php echo $l_upload_user?>:</label></td>
<td colspan="2">
<select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>class="work_user_id" id="owner" name="owner">
<option value=""></option>
<?php if(isset($_POST['project']) || isset($_SESSION['_project'])) {
	$_GET['p']= (isset($_POST['project']) ? $_POST['project'] : $_SESSION['_project']->id); 
	$_GET['i']= (isset($_POST['owner']) ? $_POST['owner'] : null);
	include_once '../project/get_proj_user.inc.php';
	unset($_GET['i']);
	unset($_GET['p']);
}?>
</select><span id="owner_span"></span>
</td>
</tr>
<tr>
<td>
<label class="search_label"><?php echo $l_upload_time?>:</label>
</td>
<td colspan="3">
<label class="search_label_date"><?php echo $l_from?>:</label>
<input style="width:125px;<?php echo isset($_SESSION['_project'])||isset($_POST['doc_upload_start']) ? 'background-color:white;' : "";?>" disabled type="text" id="doc_upload_start" name="doc_upload_start" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['doc_upload_start']) ? $_POST['doc_upload_start'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_doc','controlname': 'doc_upload_start'});</script>
<label class="search_label_date" style="padding-left:30px;"><?php echo $l_to?>:</label>
<input style="width:125px;<?php echo isset($_SESSION['_project'])||isset($_POST['doc_upload_end']) ? 'background-color:white;' : "";?>" disabled type="text" id="doc_upload_end" name="doc_upload_end" title="<?php echo $l_calendar?>" value="<?php echo isset($_POST['doc_upload_end']) ? $_POST['doc_upload_end'] : ""?>" />
<script language="JavaScript">new tcal ({'formname': 'search_doc','controlname': 'doc_upload_end'});</script>
</td>
</tr>
<tr>
<td><label class="search_label"><?php echo $l_comp?>:</label></td>
<!-- td><label class="search_label"><?php echo $l_wp?>:</label></td -->
<td><label class="search_label"><?php echo $l_wi?>:</label></td>
</tr>
<tr>
<td><!-- select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="component" id="component" onchange="javascript:getCompWpSearch('project', 'component', 'workpackage');javascript:getCompWi('project', 'component', 'workitem');" -->
<select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="component" id="component" onchange="javascript:getCompWi('project', 'component', 'workitem');">
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
<!-- td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="workpackage" name="workpackage" onchange="javascript:getWpWi('project', 'component', 'workpackage', 'workitem')">
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
?></select><span id="workpackage_span"></span></td -->
<td><select <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>name="workitem" id="workitem">
<option value=""></option>
<?php
if(isset($_SESSION['_workpackage']) || (isset($_POST['workpackage']) && !empty($_POST['workpackage']))) {
	$_GET['w']= (isset($_POST['workpackage']) ? $_POST['workpackage'] : $_SESSION['_workpackage']->id); 
	if (isset($_POST['workitem'])) $_GET['i']=$_POST['workitem'];
	else $_GET['i']=(isset($_SESSION['_workitem']) ? $_SESSION['_workitem']->id : null);
	include_once '../project/get_wp_wi.inc.php';
	unset($_GET['i']);
	unset($_GET['c']);
}
else if(isset($_SESSION['_component']) || (isset($_POST['component']) && !empty($_POST['component']))) {
	$_GET['c']= (isset($_POST['component']) ? $_POST['component'] : $_SESSION['_component']->id); 
	if (isset($_POST['workitem'])) $_GET['i']=$_POST['workitem'];
	else $_GET['i']=(isset($_SESSION['_workitem']) ? $_SESSION['_workitem']->id : null);
	include_once '../project/get_comp_wi.inc.php';
	unset($_GET['i']);
	unset($_GET['c']);
}
else if(isset($_SESSION['_project']) || isset($_POST['project'])) {
	$_GET['p']= (isset($_POST['project']) ? $_POST['project'] : $_SESSION['_project']->id); 
	if (isset($_POST['workitem'])) $_GET['i']=$_POST['workitem'];
	else $_GET['i']=(isset($_SESSION['_workitem']) ? $_SESSION['_workitem']->id : null);
	include_once '../project/get_proj_wi.inc.php';
	unset($_GET['i']);
	unset($_GET['p']);
}
?></select><span id="workitem_span"></span></td>
<td>
<input <?php if(!isset($_SESSION['_project']) && !isset($_POST['project'])) echo "disabled "; ?>id="search_submit_button" class="search_submit_button" onmousedown="mousePress('search_submit_button')" onmouseup="mouseRelease('search_submit_button')" onmouseout="mouseRelease('search_submit_button')" type="submit" value="<?php echo $l_seach?>" />
</td>
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