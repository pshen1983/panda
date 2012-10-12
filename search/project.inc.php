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
		$l_header = "My Project Search Result";
		$l_title = "Project Title";
		$l_director = "Director";
		$l_manager = "Manager";
		$l_status = "Status";
		$l_deadline = "Deadline";
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_empty = '&#65288;&#31354;&#65289;';
		$l_header = "我的项目搜索结果";
		$l_title = "项目名称";
		$l_director = "总监";
		$l_manager = "经理";
		$l_status = "状态";
		$l_deadline = "截止日期";
	}

	//=========================================================================================================

	if(isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']))
	{
		$projs = SearchDBUtil::getProjListByTitle($_SESSION['seach_input'], $_SESSION['_userId']);
		if(isset($projs)) {
			$table = array();
			$index = 0;
			$table[$index] = array($l_title, $l_director, $l_manager, $l_status, $l_deadline);

			while($proj = mysql_fetch_array($projs, MYSQL_ASSOC))
			{
				$index = $index + 1;

				$creator = DatabaseUtil::getUser($proj['creator']);
				$manager = DatabaseUtil::getUser($proj['owner']);
				$stat = DatabaseUtil::getEnumDescription(DatabaseUtil::$PROJ_STATUS, $proj['status']);
				$title = '<a href="../project/index.php?p_id='.$proj["id"].'&sid='.$proj["s_id"].'" title="'.str_replace('"', '&quot;', $proj["title"]).'">'.$proj["title"].'</a>';

				$dir_name = ($_SESSION['_language'] == 'zh') ? $creator['lastname'].$creator['firstname'] : CommonUtil::truncate($creator['firstname']." ".$creator['lastname'], 65);
				$man_name = ($_SESSION['_language'] == 'zh') ? $manager['lastname'].$manager['firstname'] : CommonUtil::truncate($manager['firstname']." ".$manager['lastname'], 65);

				$table[$index] = array($title, $dir_name, $man_name, $stat, $proj['end_date']);
			}

			$sortColumn =
				"<script id='filter_bar_js' type='text/javascript'>
				$(function() {
					$('table')
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