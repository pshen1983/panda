<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SearchDBUtil.php");
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/CommonUtil.php");

	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_empty = '(empty)';
		$l_header = "Workitem Search Result";
		$l_obj = "Workitem Objective";
		$l_owner = "Owner";
		$l_status = "Status";
		$l_type = "Type";
		$l_priority = "Priority";
		$l_component = "Component";
		$l_project = "Project";
		$l_deadline = "Deadline";
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_empty = '&#65288;&#31354;&#65289;';
		$l_header = "工作项搜索结果";
		$l_obj = "工作项名称";
		$l_owner = "所有者";
		$l_status = "状态";
		$l_type = "种类";
		$l_priority = "优先度";
		$l_component = "所属项目组";
		$l_project = "所属项目";
		$l_deadline = "截止日期";
	}
	
	//=========================================================================================================
	
	if(isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']) && 
	   isset($_SESSION['_project']) && !empty($_SESSION['_project']) ) 
	{
		$hasRecord = false;
		if (is_numeric($_SESSION['seach_input']))
			$wis = SearchDBUtil::getWorkItemListById($_SESSION['seach_input'], $_SESSION['_project']->id);
		else 
			$wis = SearchDBUtil::getWorkItemListByTitle($_SESSION['seach_input'], $_SESSION['_project']->id);
	
		if(isset($wis)) {
			$table = array();
			$index = 0;
			$table[$index] = array($l_obj, $l_owner, $l_status, $l_type, $l_priority, $l_component, $l_project, $l_deadline);

			while($wi = mysql_fetch_array($wis, MYSQL_ASSOC))
			{
				$index = $index + 1;

				$userO = DatabaseUtil::getUser($wi['owner_id']);
				$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_STATUS, $wi['status']);
				$type = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_TYPE, $wi['type']);
				$priority = DatabaseUtil::getEnumDescription(DatabaseUtil::$PRIORITY, $wi['priority']);

				if(isset($wi['comp_id'])) {
					$comp = DatabaseUtil::getComp($wi['comp_id']);
					$comp_content = '<a href="../project/project_component.php?c_id='.$wi["comp_id"].'&sid='.$comp["s_id"].'" title="'.str_replace('"', '&quot;', $comp["title"]).'">'.CommonUtil::truncate($comp["title"], 16).'</a>';
				}
				else $comp_content = '-';
				if(isset($wi['workpackage_id'])) {
					$wp = DatabaseUtil::getWorkPackage($wi['workpackage_id']);
					$wp_content = '<a href="../project/work_package.php?wp_id='.$wi["workpackage_id"].'&sid='.$wp["s_id"].'" title="'.str_replace('"', '&quot;', $wp["objective"]).'">'.CommonUtil::truncate($wp["objective"], 16).'</a>';
				}	

				$wi_content = '<a href="../project/work_item.php?wi_id='.$wi["id"].'&sid='.$wi["s_id"].'" title="Work Item '.str_pad($wi['pw_id'], 4, "0", STR_PAD_LEFT).' - '.str_replace('"', '&quot;', $wi["title"]).'">'.str_pad($wi['pw_id'], 4, "0", STR_PAD_LEFT).' - '.$wi["title"].'</a>';
				$proj_content = '<a href="../project/index.php?p_id='.$_SESSION["_project"]->id.'&sid='.$_SESSION["_project"]->s_id.'" title="'.str_replace('"', '&quot;', $_SESSION["_project"]->title).'">'.CommonUtil::truncate($_SESSION["_project"]->title, 16).'</a>';

				$ownerName = ($_SESSION['_language'] == 'zh') ? $userO["lastname"].$userO["firstname"] : CommonUtil::truncate($userO["firstname"].' '.$userO["lastname"], 16);

				$table[$index] = array( $wi_content, 
										$ownerName, 
										$status, 
										'<img class="enum_img" src="../image/type/'.$wi['type'].'.gif" />'.$type,
										'<img class="enum_img" src="../image/priority/'.$wi['priority'].'.gif" />'.$priority,
										$comp_content, 
										$proj_content, 
										$wi["deadline"]
									   );
			}
			
			$sortColumn =
				"<script id='filter_bar_js' type='text/javascript'>
				$(function() {
					$('table')
						.tablesorter({widthFixed: true, widgets: ['zebra']})
				});
				var table_Props = 	{
										col_0: \"none\",
										col_1: \"select\",
										col_2: \"select\",
										col_3: \"select\",
										col_4: \"select\",
										col_5: \"select\",
										col_6: \"select\",
										col_7: \"none\",
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
	                                   array(39, 10, 8, 7, 8, 10, 10, 8)
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
}
else {
	echo 1;
}
?>