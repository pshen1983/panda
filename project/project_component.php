<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SessionUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);
SessionUtil::clearWorkpackageSession();

include_once ('language/l_project_component.inc.php');

if(!isset($_POST['work_due_start_date']) || empty($_POST['work_due_start_date']))
	$_POST['work_due_start_date'] = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-28,date("Y")));
if(!isset($_POST['work_due_end_date']) || empty($_POST['work_due_end_date']))
	$_POST['work_due_end_date'] = date('Y-m-d', mktime(0,0,0,date("m"),date("d")+28,date("Y")));

if ( (isset($_GET['c_id']) && isset($_GET['sid'])) || isset($_SESSION['_component']) )
{
	if(!isset($_SESSION['_component']))
	{
		SessionUtil::selectComponent( $_SESSION['_userId'], $_GET['c_id'],$_GET['sid'] );
	}
	else 
	{
		if(isset($_GET['c_id']) && isset($_GET['sid']))
		{
			$component = $_SESSION['_component'];
			if ($component->id != $_GET['c_id'] || $component->s_id != $_GET['sid'])
			{
				SessionUtil::selectComponent( $_SESSION['_userId'], $_GET['c_id'],$_GET['sid'] );
			}
			else
			{
				$comp_date = DatabaseUtil::getCompDate($component->id);
				if ($comp_date != $component->lastupdate_date)
				{
					SessionUtil::selectComponent( $_SESSION['_userId'], $component->id, $component->s_id );
				}
			}
		}
		else
		{
			$component = $_SESSION['_component'];
			$comp_date = DatabaseUtil::getCompDate($component->id);
			if ($comp_date != $component->lastupdate_date)
			{
				SessionUtil::selectComponent( $_SESSION['_userId'], $component->id, $component->s_id );
			}
		}
	}

	$comp = $_SESSION['_component'];
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
<link rel="stylesheet" type="text/css" href="../css/AutoComplete.css" media="screen"> 
<link rel="stylesheet" type='text/css' href="../css/calendar.css">
<link rel='stylesheet' type='text/css' href='../css/ajax_calendar.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/project_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
<!-- link calendar files  -->
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script type='text/javascript' src="../js/ajax_calendar.js"></script>
<script language="JavaScript" src="../js/jquery.js"></script>
<script language="JavaScript" src="../js/common.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$.ajax({
	url: "../utils/calendar.php?month=&year=",
	success: function(data){
		setFade(0);
		$("div#calendar").html(data);
		adjustHeight();
		fade(0);
		addCalWorkItemMenu();
		addProjectActionMenu();
	}
});
$('td.en_day').live('dblclick', function() {
	date = $("table.cal").attr('id') + $(this).attr('id');
	window.location.href = "../project/new_workitem.php?end_date="+date;
});
setInterval( longpollLeftNav, 5000 );
});
</script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<div id="left_nav"><?php include_once '../common/left_nav.inc.php';?></div>
<div id="right_nav"><?php include_once '../common/right_nav.inc.php';?></div>
<div id="main_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div id="page_title"><?php echo $l_proj_comp?>: <span id="proj_title"><?php echo CommonUtil::truncate($_SESSION['_component']->title, 28)?>
</span> <span id="page_title_const">( <a title="<?php echo $_SESSION['_project']->title; ?>" href="../project/index.php"><?php echo CommonUtil::truncate($_SESSION['_project']->title, 34)?></a> )</span></div>
<?php
include_once 'update_component.inc.php';
echo '<div id="mid_link_saperator"></div>';
?>
<div id="calback"><label class="cal_info"><?php echo $l_double_click?></label><div id="calendar"></div></div>
<div class="page_saperator"></div>
<?php
$_GET['s'] = '';//$_POST['work_due_start_date']; 
$_GET['e'] = '';//$_POST['work_due_end_date']; 
$_GET['p'] = 'project_component.php';
include_once '../project/workTable.php'; 
unset( $_GET['s']); unset( $_GET['e']); unset( $_GET['p']);
include_once '../project/project_document.inc.php';
?>
</div></div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
<ul id="myMenu" class="contextMenu">
<li class="goto"><a href="#goto"><?php echo $l_goto?></a></li>
<li class="done separator"><a href="#done"><?php echo $l_done?></a></li>
</ul>
</body>
</html>