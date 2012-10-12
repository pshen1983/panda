<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");

if(!isset($_SESSION)) session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

include_once ('language/l_workTable.inc.php');

if(!isset($_GET['s']) || !isset($_GET['e']) || !isset($_GET['p']))
{
	header( 'Location: ../home/index.php' ) ;
}

//if ( !CommonUtil::validateDateFormat($_GET['s']) || !CommonUtil::validateDateFormat($_GET['e']) )
//{
//	echo "x Invalid date formate.";
//}
//else {
$yesterday = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$today = date("Y-m-d");
$tomorrow = date('Y-m-d', mktime(0,0,0,date("m"),date("d")+1,date("Y")));

$table = array();
$index = 0;
if(!isset($_SESSION['_component'])) 
	$table[$index] = array(/*$l_type,*/ (isset($_SESSION['_component']) ? $l_wp : $l_comp), $l_obje, $l_stat, $l_prio, $l_dead);
else $table[$index] = array($l_obje, $l_stat, $l_prio, $l_dead);

$result = DatabaseUtil::selectTableWork($_SESSION['_userId'], $_GET['s'], $_GET['e'], (isset($_SESSION['_project'])?$_SESSION['_project']->id : null), (isset($_SESSION['_component'])?$_SESSION['_component']->id : null));

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$index = $index + 1;
	if ($row['itype'] == DatabaseUtil::$WORKITEM)
	{
		$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_STATUS, $row['status']);
		$priority = DatabaseUtil::getEnumDescription(DatabaseUtil::$PRIORITY, $row['priority']);
		$comp = isset($row['comp_id']) ? DatabaseUtil::getComp($row['comp_id']) : null;
		$wp = isset($row['workpackage_id']) ? DatabaseUtil::getWorkPackage($row['workpackage_id']) : null;

		$deadline = $row['deadline'];
		if($deadline == $yesterday) $deadline = '<span style="">'.$l_yesterday.'</span>';
		else if($deadline == $today) $deadline = '<span style="color:green;">'.$l_today.'</span>';
		else if($deadline == $tomorrow) $deadline = '<span style="">'.$l_tomorrow.'</span>';
		
		if(!isset($_SESSION['_component']))
			$table[$index] = array( //'<img class="work_symbol" src="../image/work_icon/Item.png" /> ',//.$l_item,
									(isset($_SESSION['_component']) ?
									 (isset($wp) ? '<a href="../project/work_package.php?wp_id='.$wp['id'].'&sid='.$wp['s_id'].'" title="'.$l_wp_title.str_replace('"', '&quot;', $wp['objective']).'">'.$wp['objective'].'</a>' : '-') :
									 (isset($comp) ? '<a href="../project/project_component.php?c_id='.$row['comp_id'].'&sid='.$comp['s_id'].'" title="'.$l_comp_title.str_replace('"', '&quot;', $comp['title']).'">'.CommonUtil::truncate($comp['title'], 13).'</a>' : "-")),
									'<img class="enum_img" src="../image/type/'.$row['type'].'.gif" /><a id="wi_'.$row['id'].'_'.$row['s_id'].'" class="cmlink" href="../project/work_item.php?wi_id='.$row['id'].'&sid='.$row['s_id'].'" title="'.$l_rclick_hint.'">'.str_pad($row['pw_id'], 4, "0", STR_PAD_LEFT).' - '.$row['title'].'</a>', 
									'<label id="wi'.$row['id'].'_lab">'.$status.'</label>', 
									'<img class="enum_img" src="../image/priority/'.$row['priority'].'.gif" /> '.$priority, 
									( strtotime($row['deadline'])<strtotime($today) ) ? '<span style="color:#FF3D3D;">'.$deadline.'</span>' : $deadline
								  );
		else
			$table[$index] = array( '<img class="enum_img" src="../image/type/'.$row['type'].'.gif" /><a id="wi_'.$row['id'].'_'.$row['s_id'].'" class="cmlink" href="../project/work_item.php?wi_id='.$row['id'].'&sid='.$row['s_id'].'" title="'.$l_rclick_hint.'">'.str_pad($row['pw_id'], 4, "0", STR_PAD_LEFT).' - '.$row['title'].'</a>', 
									'<label id="wi'.$row['id'].'_lab">'.$status.'</label>', 
									'<img class="enum_img" src="../image/priority/'.$row['priority'].'.gif" /> '.$priority, 
									( strtotime($row['deadline'])<strtotime($today) ) ? '<span style="color:#FF3D3D;">'.$deadline.'</span>' : $deadline
								  );
	}
	else {
		$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WP_STATUS, $row['status']);
		$comp = isset($row['comp_id']) ? DatabaseUtil::getComp($row['comp_id']) : null;

		$table[$index] = array( '<img class="work_symbol" src="../image/work_icon/Package.png" /> '.$l_package,
								'<a id="wp'. $row['id'] .'" href="../project/work_package.php?wp_id='.$row['id'].'&sid='.$row['s_id'].'" title="'.str_replace('"', '&quot;', $row['title']).'">'.$row['title'].'</a>', 
								'<label id="wp'.$row['id'].'_lab">'.$status.'</label>', 
								'-', 
								( strtotime($row['deadline'])<$today )? '<span style="color:red;">'.$row['deadline'].'</span>':$row['deadline']
							  );
	}
}

if(!isset($_SESSION['_component']))
	$sortColumn =
		"<script id='filter_bar_js' type='text/javascript'>
		$(function() {
			$('table#table2')
				.tablesorter({widthFixed: true, widgets: ['zebra']})
		});
		var table_Props = 	{
								col_0: \"select\",
								col_1: \"none\",
								col_2: \"select\",
								col_3: \"select\",
								col_4: \"none\",
								display_all_text: \"\",
								sort_select: false 
							};
		setFilterGrid( \"table2\",table_Props );
		</script>";
else 
	$sortColumn =
		"<script id='filter_bar_js' type='text/javascript'>
		$(function() {
			$('table#table2')
				.tablesorter({widthFixed: true, widgets: ['zebra']})
		});
		var table_Props = 	{
								col_0: \"none\",
								col_1: \"select\",
								col_2: \"select\",
								col_3: \"none\",
								display_all_text: \"\",
								sort_select: false 
							};
		setFilterGrid( \"table2\",table_Props );
		</script>";

$datePickForm = 
	"<form method=\"post\" action=\"".$_GET['p']."\" id=\"work_due_dates_input_form\" name=\"work_due_dates_input_form\" onsubmit=\"document.getElementById('work_due_start_date').disabled=false;document.getElementById('work_due_end_date').disabled=false;\" accept-charset=\"UTF-8\">
	<label class=\"start_date_label\">".$l_from.": </label>
	<input style='background-color:white;border:0 none;' disabled type=\"text\" id=\"work_due_start_date\" name=\"work_due_start_date\" title=\"".$l_calendar."\" value=\"".$_GET['s']."\" />
	<script language=\"JavaScript\">new tcal ({'formname': 'work_due_dates_input_form','controlname': 'work_due_start_date'});</script>
	<label class=\"end_date_label\">".$l_to.": </label>
	<input style='background-color:white;border:0 none' disabled type=\"text\" id=\"work_due_end_date\" name=\"work_due_end_date\" title=\"".$l_calendar."\" value=\"".$_GET['e']."\" />
	<script language=\"JavaScript\">new tcal ({'formname': 'work_due_dates_input_form','controlname': 'work_due_end_date'});</script>
	<input class=\"start_end_submit_button\" onmousedown=\"mousePress('update_list_button');\" onmouseup=\"mouseRelease('update_list_button');\" onmouseout=\"mouseRelease('update_list_button');\" type=\"submit\" value=\"".$l_update."\" id=\"update_list_button\" />
	</form>";

$level = "";
if(isset($_SESSION['_component'])) $level .= $l_component."<span class='table_work_level_name'>".$_SESSION['_component']->title."</span>";
else if(isset($_SESSION['_project'])) $level .= $l_project."<span class='table_work_level_name'>".$_SESSION['_project']->title."</span>";

//$period = (($_GET['s'] != $_GET['e']) ? $l_from.' "'.$_GET['s'].'" '.$l_to.' "'.$_GET['e'].'"' : $l_on.' "'.$_GET['s'].'"');
//$period = (($_GET['s'] != $_GET['e']) ? $l_from.' '.$_GET['s'].' '.$l_to.' '.$_GET['e'] : $l_on.' '.$_GET['s']);
//$empty_display = ($_SESSION['_language']=='zh') ? $period.$l_0_due : $l_0_due.$period;

echo CommonUtil::getTable( $table, 
						   $sortColumn, 
						   $l_list.$level, 
						   null,//$datePickForm, 
						   "work_list_table_show_hide_link", 
						   "work_list_table", 
						   null, //$empty_display, 
						   'table2',
						   'sort_table',
						   !isset($_SESSION['_component']) ? array(15, 49, 12, 11, 13) : array(66, 10, 11, 13) 
						  );
//}
?>