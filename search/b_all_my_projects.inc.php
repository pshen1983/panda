<?php
include_once ("../utils/SearchDBUtil.php");
include_once ("../utils/SecurityUtil.php");

if(!isset($_SESSION)) session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

$hasRecord = false;

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_proj_title = 'Project Name';
	$l_director = 'Director';
	$l_manager = 'Manager';
	$l_status = 'Status';
	$l_deadline = 'Deadline';
	$l_empty = '(empty)';
	$l_header = 'List of my Projects: ';
}
else if($_SESSION['_language'] == 'zh') {
	$l_proj_title = '&#39033;&#30446;&#21517;&#31216;';
	$l_director = '&#39033;&#30446;&#24635;&#30417;';
	$l_manager = '&#39033;&#30446;&#32463;&#29702;';
	$l_status = '&#39033;&#30446;&#29366;&#24577;';
	$l_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_empty = '&#65288;&#31354;&#65289;';
	$l_header = '我的项目：';
}

//=========================================================================================================

$projs = SearchDBUtil::getAllUserProjects($_SESSION['_userId']);

if(isset($projs)) {
	$hasRecord = false;
	$table = array();
	$index = 0;
	$table[$index] = array($l_proj_title, $l_director, $l_manager, $l_status, $l_deadline);

	while($proj = mysql_fetch_array($projs, MYSQL_ASSOC))
	{
		$index++;
		if(!$hasRecord) $hasRecord = true;

		$user = DatabaseUtil::getUser($proj['creator']);
		$manager = DatabaseUtil::getUser($proj['owner']);
		$stat = DatabaseUtil::getEnumDescription(DatabaseUtil::$PROJ_STATUS, $proj['status']);
		$title = '<a href="../project/index.php?p_id='.$proj['id'].'&sid='.$proj['s_id'].'" title="'.str_replace('"', '&quot;', $proj['title']).'">'.CommonUtil::truncate($proj['title'], 52)."</a>";

		$dir_name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : CommonUtil::truncate($user['firstname']." ".$user['lastname'], 64);
		$man_name = ($_SESSION['_language'] == 'zh') ? $manager['lastname'].$manager['firstname'] : CommonUtil::truncate($manager['firstname']." ".$manager['lastname'], 64);

		$table[$index] = array( $title, $dir_name, $man_name, $stat, $proj['end_date']);
	}

	if($hasRecord) {
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

		echo CommonUtil::getTable( $table, 
								   $sortColumn, 
								   "<label>".$l_header."</label>", 
								   null, 
								   null, 
								   "work_list_table", 
								   null, 
								   'search_result_table',
								   'search_result_table'
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