<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SessionUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);
SessionUtil::clearWorkitemSession();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Workpackage | ProjNote';
	$l_workpackage = 'Workpackage';
	$l_list_wis = 'List of Workitem(s) in this Workpackage ';
	$l_list_wis_0 = '0 Workitem found in this Workpackage';
	$l_list_comm = 'List of Comments';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#24037;&#20316;&#21253; | ProjNote';
	$l_workpackage = '&#24037;&#20316;&#21253;';
	$l_list_wis = '&#25152;&#21547;&#24037;&#20316;&#39033;&#21015;&#34920;';
	$l_list_wis_0 = '&#30446;&#21069;&#27492;&#24037;&#20316;&#21253;&#27809;&#26377;&#24037;&#20316;&#39033;&#12290;';
	$l_list_comm = '&#30041;&#35328;&#34920;';
}

//=========================================================================================================

function buildWorkitemTableArray()
{
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_lwi_id = 'ID';
		$l_lwi_type = 'Type';
		$l_lwi_summary = 'Summary';
		$l_lwi_owner = 'Owner';
		$l_lwi_status = 'Status';
		$l_lwi_priority = 'Priority';
		$l_lwi_deadlin = 'Deadline';
		$l_lwi_modified = 'Modified';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_lwi_id = '&#39033;&#21495;';
		$l_lwi_type = '&#31867;&#21035;';
		$l_lwi_summary = '&#31616;&#20171;';
		$l_lwi_owner = '&#25152;&#26377;&#32773;';
		$l_lwi_status = '&#29366;&#24577;';
		$l_lwi_priority = '&#20248;&#20808;&#24230;';
		$l_lwi_deadlin = '&#25130;&#27490;&#26085;&#26399;';
		$l_lwi_modified = '&#26368;&#21518;&#26356;&#25913;';
	}
	
	//=========================================================================================================

	$todays_date = date("Y-m-d");
	$today = strtotime($todays_date);

	$table = array();
	$index = 0;
	$table[$index] = array($l_lwi_id, $l_lwi_type, $l_lwi_summary, $l_lwi_owner, $l_lwi_status, $l_lwi_priority, $l_lwi_deadlin, $l_lwi_modified);
	
	$result = DatabaseUtil::getWorkPackageWorkItemList($_SESSION['_workpackage']->id);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$index = $index + 1;

		$type = '<span style="font-weight:bold;">'.DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_TYPE, $row['type']).'</span>';
		$objective = '<a href="../project/work_item.php?wi_id='.$row['id'].'&sid='.$row['s_id'].'"title="Work Item '.str_pad($row['pw_id'], 4, "0", STR_PAD_LEFT).' - '.str_replace('"', '&quot;', $row['title']).'">'.CommonUtil::truncate($row['title'], 19)."</a>";
		$user = DatabaseUtil::getUser($row['owner_id']);
		$name = ($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : CommonUtil::truncate($user['firstname']." ".$user['lastname'], 25);
		$status = DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_STATUS, $row['status']);
		$priority = DatabaseUtil::getEnumDescription(DatabaseUtil::$PRIORITY, $row['priority']);
		$deadline = ( strtotime($row['deadline'])<$today )? '<span style="color:red;">'.$row['deadline'].'</span>':$row['deadline'];
		$modified = substr($row['lastupdated_time'], 0, 10);
		
		$table[$index] = array( str_pad($row['pw_id'], 4, "0", STR_PAD_LEFT), $type, $objective, $name, $status, $priority, $deadline, $modified);
	}

	return $table;
}

if ( (isset($_GET['wp_id']) && isset($_GET['sid'])) || isset($_SESSION['_workpackage']) )
{
	if(!isset($_SESSION['_workpackage']))
	{
		SessionUtil::selectWorkpackage( $_SESSION['_userId'], $_GET['wp_id'], $_GET['sid'] );
	}
	else
	{
		if(isset($_GET['wp_id']) && isset($_GET['sid']))
		{
			$workpackage = $_SESSION['_workpackage'];
			if ($workpackage->id != $_GET['wp_id'] || $workpackage->s_id != $_GET['sid'])
			{
				SessionUtil::selectWorkpackage( $_SESSION['_userId'], $_GET['wp_id'],$_GET['sid'] );
			}
			else
			{
				$wp_date = DatabaseUtil::getWorkPackageDate($workpackage->id);
				if ($wp_date != $workpackage->lastupdated_time)
				{
					SessionUtil::selectWorkpackage( $_SESSION['_userId'], $workpackage->id, $workpackage->s_id );
				}
			}
		}
		else
		{
			$workpackage = $_SESSION['_workpackage'];
			$wp_date = DatabaseUtil::getWorkPackageDate($workpackage->id);
			if ($wp_date != $workpackage->lastupdated_time)
			{
				SessionUtil::selectWorkpackage( $_SESSION['_userId'], $workpackage->id, $workpackage->s_id );
			}
		}
	}

	$wp = $_SESSION['_workpackage'];
}
else {
	header( 'Location: ../home/index.php' );
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<!-- link calendar files  -->
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script language="JavaScript" src="../js/autocomplete.js"></script>
<script language="JavaScript" src="../js/common.js"></script>
<link rel="stylesheet" href="../css/AutoComplete.css" media="screen" type="text/css"> 
<link rel="stylesheet" href="../css/calendar.css">
<link rel='stylesheet' type='text/css' href='css/work_comments.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<?php include('../utils/analytics.inc.php');?>
</head>
<body onLoad='<?php if(isset($_SESSION['show_comment'])) {echo "showComments(\"show_hide_wp_comments\", \"wp_comments\", \"wp\", \"$wp->id\", \"$wp->s_id\");"; unset($_SESSION['show_comment']);}?>setLeftRightNavHeight()'>
<center>
<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<div id="left_nav"><?php include_once '../common/left_nav.inc.php';?></div>
	<div id="right_nav"><?php include_once '../common/right_nav.inc.php';?></div>
	<div id="main_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div id="page_title"><?php echo $l_workpackage?>: <span id="page_title_const"><?php echo CommonUtil::truncate($_SESSION['_workpackage']->objective, 70)?></span></div>

	<div id="project_info">
	<?php
		include_once 'update_workpackage.inc.php';
	?>
	<div style="margin-top:10px;"></div>
	
	<div class="page_saperator"></div>
	<?php 
		$sortColumn =
			"<script id='filter_bar_js' type='text/javascript'>
			$(function() {
				$('table')
					.tablesorter({widthFixed: true, widgets: ['zebra']})
			});
			var table_Props = 	{
									col_0: \"none\",
									col_1: \"select\",
									col_2: \"none\",
									col_3: \"select\",
									col_4: \"select\",
									col_5: \"select\",
									col_6: \"none\",
									col_7: \"none\",
									display_all_text: \"\",
									sort_select: false 
								};
			setFilterGrid( \"table3\",table_Props );
			</script>";	
	
	echo CommonUtil::getTable( buildWorkitemTableArray(), 
							   $sortColumn, 
							   $l_list_wis, 
							   null, 
							   "workitem_list_table_show_hide_link", 
							   "workitem_list_table", 
							   $l_list_wis_0, 
							   'table3',
							   'sort_table',
							   array(7, 5, 40, 11, 6, 7, 12, 12)
							  );
	?>
	<div class="page_saperator"></div>
	<div class="work_comments">
	<div class="list_of_comments_header"><a class="show_hide_comment" href="javascript:showComments('show_hide_wp_comments', 'wp_comments', 'wp', '<?php echo $wp->id?>', '<?php echo $wp->s_id?>')"><img id="show_hide_wp_comments" class="double_arrow" src='../image/common/double_arrow_down.png'/><span style="position:relative;left:2px;"><?php echo $l_list_comm?> <span style="font-size:.7em;font-weight:normal;"> (<?php echo DatabaseUtil::getWorkPackageCommentCount($_SESSION['_workpackage']->id);?>)</span></span></a></div>
	<div id="wp_comments" class="comment_list"></div>
	</div>
	</div>
<?php include_once '../project/project_document.inc.php';?>	
	</div>
	</div>
<?php include_once '../common/footer_1.inc.php';?>
	</center>
    </body>
</html>