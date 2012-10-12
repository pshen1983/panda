<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SessionUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);
SessionUtil::clearComponentSession();

include_once ('language/l_index.inc.php');

if(!isset($_POST['work_due_start_date']) || empty($_POST['work_due_start_date']))
	$_POST['work_due_start_date'] = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-28,date("Y")));
if(!isset($_POST['work_due_end_date']) || empty($_POST['work_due_end_date']))
	$_POST['work_due_end_date'] = date('Y-m-d', mktime(0,0,0,date("m"),date("d")+28,date("Y")));

if ( (isset($_GET['p_id']) && isset($_GET['sid'])) || isset($_SESSION['_project']) )
{
	if(!isset($_SESSION['_project']))
	{
		SessionUtil::selectProject($_SESSION['_userId'], $_GET['p_id'], $_GET['sid']);
	}
	else 
	{
		if(isset($_GET['p_id']) && isset($_GET['sid']))
		{
			SessionUtil::selectProject($_SESSION['_userId'], $_GET['p_id'], $_GET['sid']);
		}
		else
		{
			$project = $_SESSION['_project'];
			SessionUtil::selectProject($_SESSION['_userId'], $project->id, $project->s_id);
		}
	}

	if(!isset($_SESSION['_role']))
	{
		header( 'Location: ../home/index.php' );
		exit;
	}

	$proj = $_SESSION['_project'];
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
<script language="JavaScript" src="../js/jquery.js"></script>
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script type='text/javascript' src="../js/ajax_calendar.js"></script>
<script type='text/javascript' src="../js/common.js"></script>
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
<link rel="stylesheet" type="text/css" href="../css/AutoComplete.css" media="screen"> 
<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
<link rel='stylesheet' type='text/css' href='../css/ajax_calendar.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/project_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
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
<div id="page_title"><span id="proj_title"><?php echo CommonUtil::truncate($_SESSION['_project']->title, 61)?></span> 
<?php 
if ($_SESSION['_project']->id != $_SESSION['_loginUser']->proj_id) 
	echo '<a id="proj_default" class="proj_default_link" title="'.$l_default_title.'" href="javascript:addDefaultProject(\'proj_default\')">'.$l_set_default.'</a>';
else
	echo '<a id="proj_default" class="proj_default_link" title="'.$l_default_title.'" href="javascript:removeDefaultProject(\'proj_default\')">'.$l_uns_default.'</a>';
?>
</div>
<?php 
	include_once 'update_project.inc.php';
   	echo '<div id="mid_link_saperator"></div>';
?>
<div id="calback"><label class="cal_info"><?php echo $l_double_click?></label><div id="calendar"></div></div>
<div class="page_saperator"></div>
<?php
    $_GET['s'] = '';//$_POST['work_due_start_date']; 
    $_GET['e'] = '';//$_POST['work_due_end_date']; 
    $_GET['p'] = 'index.php';
    include_once '../project/workTable.php'; 
    unset( $_GET['s']); unset( $_GET['e']); unset( $_GET['p']);
    include_once '../project/project_document.inc.php';
?>
</div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
<ul id="myMenu" class="contextMenu">
<li class="goto"><a href="#goto"><?php echo $l_goto?></a></li>
<li class="done separator"><a href="#done"><?php echo $l_done?></a></li>
</ul>
</body>
</html>
