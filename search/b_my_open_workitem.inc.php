<?php
include_once ("../utils/SearchDBUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

if(!isset($_SESSION)) session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_id = 'ID';
	$l_wi_summary = 'Workitem Summary';
	$l_owner = 'Owner';
	$l_status = 'Status';
	$l_type = 'Type';
	$l_priority = 'Priority';
	$l_wp = 'Workpackage';
	$l_comp = 'Component';
	$l_proj = 'Project';
	$l_deadline = 'Deadline';
	
	$l_header = 'List of your open workitem:';
	$l_empty = '(empty)';
}
else if($_SESSION['_language'] == 'zh') {
	$l_id = '&#39033;&#21495;';
	$l_wi_summary = '&#24037;&#20316;&#39033;&#31616;&#20171;';
	$l_owner = '&#25152;&#26377;&#32773;';
	$l_status = '&#29366;&#24577;';
	$l_type = '&#31867;&#21035;';
	$l_priority = '&#20248;&#20808;&#24230;';
	$l_wp = '&#25152;&#23646;&#24037;&#20316;&#21253;';
	$l_comp = '&#39033;&#30446;&#32452;';
	$l_proj = '&#39033;&#30446;';
	$l_deadline = '&#25130;&#27490;&#26085;&#26399;';
	
	$l_header = '我未完成的工作项：';
	$l_empty = '&#65288;&#31354;&#65289;';
}

//=========================================================================================================

if( isset($_SESSION['_project']) && !empty($_SESSION['_project']) ) 
{
	$table = array();
	$index = 0;
	$table[$index] = array($l_id, $l_wi_summary, $l_owner, $l_status, $l_type, $l_priority, /*$l_wp,*/ $l_comp, $l_proj, $l_deadline);

	$wis = SearchDBUtil::getMyOpenWorkItem($_SESSION['_userId'], $_SESSION['_project']->id);
	
	if(isset($wis)) 
	{
		while($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
		{
			$userO = DatabaseUtil::getUser($wi['owner_id']);
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
			$index = $index + 1;
			$wititle = '<a href="../project/work_item.php?wi_id='.$wi["id"].'&sid='.$wi["s_id"].'" title="'.str_replace('"', '&quot;', $wi["title"]).'">'.$wi["title"].'</a>';
			$projtitle = '<a href="../project/index.php?p_id='.$_SESSION["_project"]->id.'&sid='.$_SESSION["_project"]->s_id.'" title="'.str_replace('"', '&quot;', $_SESSION["_project"]->title).'">'.CommonUtil::truncate($_SESSION["_project"]->title, 16).'</a>';
			$table[$index] = array( str_pad($wi['pw_id'], 4, "0", STR_PAD_LEFT),
									$wititle, 
									$o_name,
									$status,
									$type,
									$priority,
									//isset($wi['workpackage_id']) ? $wp_content : "-",
									isset($wi['comp_id']) ? $comp_content : "-",
									$projtitle,
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
									col_2: \"none\",
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
	
		echo CommonUtil::getTable( $table, 
								   $sortColumn, 
								   "<label>".$l_header."</label>",
								   null, 
								   null, 
								   "work_list_table", 
								   null, 
								   'search_result_table',
								   'search_result_table',
                                   array(5, 37, 10, 7, 5, 7, 10, 9, 10)
								  );
	}
	else {
		echo CommonUtil::getTable( array(), 
								   null, 
								   "<label>".$l_header."</label>",
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