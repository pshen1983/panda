<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/MessageUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Create New Project | ProjNote';

	$l_create = 'Create a new';
	$l_create_proj = 'Project';
	$l_req_field = '- Required fileds are labled with';
	$l_info = 'A Project is to carefully plan, design and manage a set of work to achieve a particular aim. It could be building a website, writing a article, filming a movie or just a goal.<br>
			   In ProjNote, a Project could contain many 
			   <span class="proj_info_obj" title="Helps to break down a project into detailed parts. e.g. it could be a project department group, a milestone, a project phase and etc.">Project Components</span> and 
			   <span class="proj_info_obj" title="A single action or activity to achieve a goal.">Workitems</span>.';
	$l_proj_name = 'Project Name';
	$l_new_proj_deadline = 'End Date';
	$l_new_proj_descript = 'Description';
	$l_new_proj_submit = 'Submit';

	$l_err_1 = '- System is temporarily busy, please try again later.';
	$l_err_3 = '- End date must be after today.';
	$l_err_4 = '- field could NOT be empty.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#26032;&#24314;&#39033;&#30446; | ProjNote';
	
	$l_create = '&#26032;&#24314;';
	$l_create_proj = '&#39033;&#30446;';
	$l_req_field = '&#8212; &#24517;&#39035;&#22635;&#20889;&#30340;&#20869;&#23481;';
	$l_info = '&#19968;&#20010;&#39033;&#30446;&#26159;&#36890;&#36807;&#35745;&#21010;&#65292;&#35774;&#35745;&#21644;&#31649;&#29702;&#19968;&#31995;&#21015;&#24037;&#20316;&#26469;&#36798;&#21040;&#19968;&#20010;&#29305;&#23450;&#30340;&#30446;&#26631;&#65292;&#21487;&#20197;&#26159;&#20570;&#19968;&#20010;&#32593;&#31449;&#65292;&#20889;&#19968;&#20010;&#31243;&#24207;&#65292;&#23436;&#25104;&#19968;&#37096;&#20889;&#20316;&#20316;&#21697;&#65292;&#19968;&#37096;&#24433;&#35270;&#20316;&#21697;&#25110;&#26159;&#19968;&#20010;&#30446;&#26631;&#12290;<br>
			   &#22312;ProjNote&#65292;&#19968;&#20010;&#39033;&#30446;&#21487;&#20197;&#21019;&#24314;&#22810;&#20010;
			   <span class="proj_info_obj" title="&#23558;&#39033;&#30446;&#32452;&#25104;&#37096;&#20998;&#32454;&#33410;&#21270;&#65292;&#21487;&#20197;&#26159;&#19968;&#20010;&#39033;&#30446;&#37096;&#38376;&#65292;&#19968;&#20010;&#39033;&#30446;&#37324;&#31243;&#30865;&#25110;&#26159;&#19968;&#20010;&#39033;&#30446;&#38454;&#27573;&#12290;">&#39033;&#30446;&#32452;</span> &#21644;
			   <span class="proj_info_obj" title="&#19968;&#39033;&#21333;&#19968;&#30340;&#20855;&#20307;&#24037;&#20316;&#65292;&#29992;&#26469;&#23436;&#25104;&#19968;&#20010;&#20855;&#20307;&#20219;&#21153;&#12290;">&#24037;&#20316;&#39033;</span> &#26469;&#26377;&#25928;&#30340;&#23436;&#25104;&#39033;&#30446;&#12290;';
	$l_proj_name = '&#39033;&#30446;&#21517;&#31216;';
	$l_new_proj_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_new_proj_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_new_proj_submit = '&#30830;&#23450;';

	$l_err_1 = '&#8212; &#31995;&#32479;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_2 = '&#8212; &#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290;';
	$l_err_3 = '&#8212; &#19981;&#33021;&#20026;&#31354;&#30333;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}

//=========================================================================================================

function doCreateProj($title, $description, $end_date)
{
	$atReturn = 0;

	if(isset($end_date))
	{
		$title = trim($title);
		$end_date = trim($end_date);
	}
	else {
		$end_date = null;
	}

	$db_connection = DatabaseUtil::getConn(DatabaseUtil::$PROJ);

	if (!$db_connection)
	{
		$atReturn = 1;
	}
	else
	{
		$statusId = "NEWA";
		$_GET['sId'] = CommonUtil::genRandomNumString(8);
		$insert_query = "INSERT INTO PROJECT (TITLE, CREATOR, DESCRIPTION, STATUS, CREATE_DATE, OWNER, END_DATE, S_ID)
						 VALUES ('". mysql_real_escape_string($title) ."', ". $_SESSION['_userId'] .", '". mysql_real_escape_string($description) ."', '$statusId', NOW(), ". $_SESSION['_userId'] .", ". (isset($end_date) ? "'". $end_date . "'" : "NULL") .", ". $_GET['sId'] .")";

		if ( mysql_query($insert_query, $db_connection) )
		{
			$projId = mysql_insert_id($db_connection);

			MessageUtil::sendNewProjectMessage($projId);
			$relation_query = "INSERT INTO RELATION (U_ID, P_ID, ROLE)
							   VALUES (". $_SESSION['_userId'] .", $projId, 'OWNE')";
			if( mysql_query($relation_query, $db_connection) ) $_GET['pId'] = $projId;
		}
		else $atReturn = 1;
	}

	return $atReturn;
}

if (isset($_POST['status']))
{
	if(isset($_POST['title']) && !empty($_POST['title'])) {
		if(isset($_POST['end_date']) && !empty($_POST['end_date']))	{
			$insertResult = 0;
			$end = strtotime($_POST['end_date']);
			$today = strtotime(date("Y-m-d"));
		
			if ($end >= $today) {
				$insertResult = doCreateProj($_POST['title'], $_POST['description'], $_POST['end_date']);
			}
			else {
				$insertResult = 2;
			}
		}
		else {
			$insertResult = doCreateProj($_POST['title'], $_POST['description'], null);
		}
	}
	else {
		$insertResult = 3;
	}

	if ($insertResult == 0)
	{
		unset($_SESSION['_oProjList']);
		header( 'Location: index.php?p_id='. $_GET['pId'] .'&sid='. $_GET['sId'] );
		exit;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
<link rel="stylesheet" type='text/css' href="css/project_layout.css" />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script language="JavaScript" src="../js/jquery.js"></script>
<script type='text/javascript' src="../js/jquery-ext.js"></script>
<script language="JavaScript" src="../js/common.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	addProjectActionMenu();
	adjustHeight();
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
	<div id="right_nav"><?php $_GET['right_nav_creat']=1; include_once '../common/right_nav.inc.php'; unset($_GET['right_nav_creat']);?></div>
	<div id="main_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
	<div id="project_info">
	<div id="page_title"><label><span id="page_title_const"><?php echo $l_create?>: </span><?php echo $l_create_proj?></label></div>
<?php 
	if(isset($insertResult)) {
		switch ($insertResult)
		{
		case 1:
			$err_message = $l_err_1;
			break;
		case 2:
			$err_message = $l_err_2;
			break;
		case 3:
			$err_message = "<span class='error_message_italic'>".$l_proj_name."</span> ".$l_err_3;
			break;
		}
	
		echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
	}
?>
	<div class="proj_info_div">
	<div class="proj_info_detail"><?php echo $l_info?></div>
	</div>
	<div class="proj_update_div">
	<form method="post" enctype="multipart/form-data" action="new_project.php" name="create_project" id="create_project" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
	<label><span class="note_info"><?php echo $l_req_field?> " <span class="mandi_field">*</span>".</span></label>
	<div style="height:10px;"></div>
	<table>
	<tr>
	<td><label class="update_label"><?php echo $l_proj_name?><span class="mandi_field"> *</span>: </label></td>
	<td><input class="proj_name" type="text" name="title" value=""/>
	<?php
		echo '<input type="hidden" value="NEWA" name="status" />';
	?>
	<!-- calendar attaches to existing form element -->
	</td>
	</tr>
	<tr><td><label class="update_label"><?php echo $l_new_proj_deadline?> :</label></td>
	<td><input type="text" name="end_date" class="deadline_input" id="end_date" title="<?php echo $l_calendar?>" disabled value="<?php echo (isset($_POST['end_date']) && !empty($_POST['end_date'])) ? $_POST['end_date'] : ''?>" />
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'create_project',
		// input name
		'controlname': 'end_date'
	});
	</script>
	<label>(<span class="note_info">e.g. 2010-01-21</span>)</label></td></tr>
	</table>
	<div><label class="update_label"><?php echo $l_new_proj_descript?>:</label><br/>
	<textarea name="description" class="work_description"></textarea>
	</div>
	<div><input type="submit" value="<?php echo $l_new_proj_submit?>" id="submit_button"  class="update_submit_button" onmousedown="mousePress('submit_button');" onmouseout="mouseRelease('submit_button');" /></div>
</form>
</div></div></div></div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>