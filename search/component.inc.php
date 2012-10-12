<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SearchDBUtil.php");
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/CommonUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_empty = '(empty)';
		$l_header = "Project Component Search Result";
		$l_title = "Component Title";
		$l_owner = "Component Owner";
		$l_status = "Status";
		$l_proj = "Project";
		$l_deadline = "Deadline";
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_empty = '&#65288;&#31354;&#65289;';
		$l_header = "项目组搜索结果";
		$l_title = "项目组名称";
		$l_owner = "项目组所有者";
		$l_status = "状态";
		$l_proj = "所属项目";
		$l_deadline = "截止日期";
	}
	
	//=========================================================================================================
	
	if(isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']) && 
	   isset($_SESSION['_project']) && !empty($_SESSION['_project']) )
	{
		$comps = SearchDBUtil::getCompListByTitle($_SESSION['seach_input'], $_SESSION['_project']->id);
		if(isset($comps)) {
			$table = array();
			$index = 0;
			$table[$index] = array($l_title, $l_owner, $l_status, $l_proj, $l_deadline);

			while($comp = mysql_fetch_array($comps, MYSQL_ASSOC))
			{
				$index = $index + 1;

				$clink = '<a href="../project/project_component.php?c_id='.$comp["id"].'&sid='.$comp["s_id"].'" title="'.str_replace('"', '&quot;', $comp["title"]).'">'.$comp["title"].'</a>';

				$proj = DatabaseUtil::getProj($_SESSION['_project']->id);
				$plink = '<a href="../project/index.php?p_id='.$_SESSION["_project"]->id.'&sid='.$proj["s_id"].'" title="'.str_replace('"', '&quot;', $proj["title"]).'">'.CommonUtil::truncate($proj["title"], 16).'</a>';

				$userO = DatabaseUtil::getUser($comp['owner']);
				$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$PROJ_STATUS, $comp['status']);
				
				$ownerName = ($_SESSION['_language'] == 'zh') ? $userO["lastname"].$userO["firstname"] : CommonUtil::truncate($userO["firstname"].' '.$userO["lastname"], 25);
				
				$table[$index] = array($clink, $ownerName, $status, $plink, $comp['end_date']);
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
										col_4: \"none\",
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
	                                   array(49, 17, 17, 8, 9)
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