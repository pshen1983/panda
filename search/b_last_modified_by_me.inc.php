<?php
include_once ("../utils/SearchDBUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

if(!isset($_SESSION)) session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

include_once ("language/l_b_last_modified_by_me.inc.php");

if( isset($_SESSION['_project']) && !empty($_SESSION['_project']) ) 
{
	$hasRecord = false;
	$table = array();
	$index = 0;
	$table[$index] = array($l_summary, $l_owner, $l_status, $l_type, $l_priority, /*$l_wp,*/ $l_comp, $l_proj, $l_deadline);
	
	$wps = SearchDBUtil::getWorkPackageLastModifiedByMe($_SESSION['_userId'], $_SESSION['_project']->id);

	if(isset($wps))
	{
		if(!$hasRecord) $hasRecord = true;
		while($wp = mysql_fetch_array($wps, MYSQL_ASSOC))
		{
			$userO = DatabaseUtil::getUser($wp['owner_id']);
			$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WP_STATUS, $wp['status']);
	 
			if(isset($wp['comp_id'])) {
				$comp = DatabaseUtil::getComp($wp['comp_id']);
				$comp_content = '<a href="../project/project_component.php?c_id='.$wp['comp_id'].'&sid='.$comp['s_id'].'" title="'.str_replace('"', '&quot;', $comp['title']).'">'.CommonUtil::truncate($comp['title'], 16)."</a>";
			}
			if(isset($wp['workpackage_id'])) {
				$wp = DatabaseUtil::getWorkPackage($wp['workpackage_id']);
				$wp_content = '<a href="../project/work_package.php?wp_id='.$wp['workpackage_id'].'&sid='.$wp['s_id'].'" title="'.str_replace('"', '&quot;', $wp['objective']).'">'.CommonUtil::truncate($wp['objective'], 16)."</a>";
			}		

			$o_name = ($_SESSION['_language'] == 'zh') ? $userO['lastname'].$userO['firstname'] : CommonUtil::truncate($userO['firstname']." ".$userO['lastname'], 16);
			$index = $index + 1;
			$wptitle = '<img style="width:12px;height:12px;" src="../image/work_icon/Package.png" /> : <a href="../project/work_package.php?wp_id='.$wp["id"].'&sid='.$wp["s_id"].'" title="'.str_replace('"', '&quot;', $wp["objective"]).'">'.CommonUtil::truncate($wp["objective"], 25).'</a>';
			$projtitle = '<a href="../project/index.php?p_id='.$_SESSION["_project"]->id.'&sid='.$_SESSION["_project"]->s_id.'" title="'.str_replace('"', '&quot;', $_SESSION["_project"]->title).'">'.CommonUtil::truncate($_SESSION["_project"]->title, 16).'</a>';
			$table[$index] = array( $wptitle, 
									$o_name,
									$status,
									"-",
									"-",
									"-",
									//(isset($wp['comp_id']) ? $comp_content : "-"),
									$projtitle,
									$wp['deadline']
								  );
		}
	}

	$wis = SearchDBUtil::getWorkItemLastModifiedByMe($_SESSION['_userId'], $_SESSION['_project']->id);

	if(isset($wis)) 
	{
		if(!$hasRecord) $hasRecord = true;
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
			$wititle = '<a href="../project/work_item.php?wi_id='.$wi["id"].'&sid='.$wi["s_id"].'" title="Work Item '.str_pad($wi['pw_id'], 4, "0", STR_PAD_LEFT).' - '.str_replace('"', '&quot;', $wi['title']).'">'.str_pad($wi['pw_id'], 4, "0", STR_PAD_LEFT).' - '.$wi["title"].'</a>';
			$projtitle = '<a href="../project/index.php?p_id='.$_SESSION["_project"]->id.'&sid='.$_SESSION["_project"]->s_id.'" title="'.str_replace('"', '&quot;', $_SESSION["_project"]->title).'">'.CommonUtil::truncate($_SESSION["_project"]->title, 16).'</a>';
			$table[$index] = array( $wititle, 
									$o_name,
									$status,
									'<img class="enum_img" src="../image/type/'.$wi['type'].'.gif" />'.$type,
									'<img class="enum_img" src="../image/priority/'.$wi['priority'].'.gif" />'.$priority,
									//(isset($wi['workpackage_id']) ? $wp_content : "-"),
									(isset($wi['comp_id']) ? $comp_content : "-"),
									$projtitle,
									( strtotime($wi['deadline'])<$today )? '<span style="color:red;">'.$wi['deadline'].'</span>':$wi['deadline']
								   );
		}
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
								   array(39, 10, 8, 6, 8, 10, 10, 9)
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