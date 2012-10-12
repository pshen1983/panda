<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SessionUtil.php");

session_start();

SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);
SessionUtil::clearProjectSession();

include_once ('language/l_index.php');

if(!isset($_POST['work_due_start_date']) || empty($_POST['work_due_start_date']))
	$_POST['work_due_start_date'] = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-28,date("Y")));
if(!isset($_POST['work_due_end_date']) || empty($_POST['work_due_end_date']))
	$_POST['work_due_end_date'] = date('Y-m-d', mktime(0,0,0,date("m"),date("d")+28,date("Y")));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/ajax_calendar.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
<script type='text/javascript' src="../js/ajax_calendar.js"></script>
<script type='text/javascript' src="../js/common.js"></script>
<script type='text/javascript' src="../js/jquery.js"></script>
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
setInterval( longpollLeftNav, 5000 );
});
</script>
<?php include('../utils/analytics.inc.php');?>
</head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<div id="left_nav"><?php include_once '../common/left_nav.inc.php';?></div>
<div id="right_nav"><?php include_once '../common/right_nav.inc.php';?></div>
<div id="main_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div id="page_title"><?php echo $l_welcome?>: <span id="page_title_const"><?php echo ($_SESSION['_language']=='zh') ? $_SESSION['_loginUser']->fullname_cn : $_SESSION['_loginUser']->firstname." ".$_SESSION['_loginUser']->lastname?></span></div>
<?php 
	if($invitations>0) echo '<div class="home_message_div"><label>'.$l_you_have.'<span class="home_msg_info">'.$invitations.'</span> <a href="../message/invitation.php">'.$l_invis.'</a>'.$l_period.'</label></div>';
	else if(!$hasProj) echo '<div class="home_message_div"><label>'.$l_create_proj.'</label></div>';
?>
<div id="calback"><div id="calendar"></div></div>
<div class="page_saperator"></div>
<?php
    $_GET['s'] = '';//$_POST['work_due_start_date']; 
    $_GET['e'] = '';//$_POST['work_due_end_date'];
    $_GET['p'] = 'index.php';
    include_once '../project/workTableHome.inc.php'; 
    unset( $_GET['s']); unset( $_GET['e']); unset( $_GET['p']);
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