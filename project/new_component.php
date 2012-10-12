<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

include_once ('language/l_new_component.inc.php');

if (isset($_POST['status']) && isset($_SESSION['_project']))
{
	$result = 0;

	if ( DatabaseUtil::isProjectMember($_SESSION['_userId'], $_SESSION['_project']->id) && SecurityUtil::canUpdateProjectInfo() )
	{
		if( isset($_POST['title']) && !empty($_POST['title']) &&
			isset($_POST['owner']) && is_numeric($_POST['owner']) ) 
		{
			if(isset($_POST['end_date']) && !empty($_POST['end_date']))	{
				$end = strtotime($_POST['end_date']);
				$today = strtotime(date("Y-m-d"));
				
				if (true)//$end > $today)
				{
					$input_end_date = $_POST['end_date'];
				}
				else $result = 2;
			}
			else {
				$input_end_date = null;
			}

			if($result != 2)
			{
				$proj = $_SESSION['_project'];
				$existId = DatabaseUtil::getCompId($_POST['title'], $proj->id);
		
				if( !isset($existId) )
				{
					$ownerdb = $_POST['owner'];
					//if (DatabaseUtil::isProjectLeader($ownerdb, $proj->id))
					if( DatabaseUtil::isProjectMember($ownerdb, $proj->id) )
					{
						$sId = CommonUtil::genRandomNumString(8);
						$result = DatabaseUtil::insertComp( $_SESSION['_userId'],
															$ownerdb, 
															$_POST['title'], 
															$_POST['description'], 
															$input_end_date, 
															$proj->id, 
															$sId,
															isset($_POST['is_milestone'])&&($_POST['is_milestone']=='Y') );
						if( $result!=-1 )
						{
							$_SESSION['_compExist'][$_SESSION['_project']->id] = true;
							$newId = $result;
							//$newId = DatabaseUtil::getCompId($_POST['title'], $proj->id);
							header( 'Location: project_component.php?c_id='. $newId .'&sid='. $sId );
							exit;
						}
						else $result = 3;
					}
					else $result = 5;
				}
				else $result = 1;
			}
		}
		else if (isset($_POST['title']) && !empty($_POST['title']))
			$result = 6;
		else $result = 7;
	}
	else $result = 4;

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/AutoComplete.css" media="screen" /> 
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
<?php include('../utils/analytics.inc.php');?></head>
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
	<div id="page_title"><label><?php echo $l_create?>: <span id="page_title_const"><?php echo $l_create_comp?></span></label></div>
<?php 
	if(isset($result)) {
		switch ($result)
		{
		case 1:
			$err_message = $l_err_1;
			break;
		case 2:
			$err_message = $l_err_2;
			break;
		case 3:
			$err_message = $l_err_3;
			break;
		case 4:
			$err_message = $l_err_4;
			break;
		case 5:
			$err_message = $l_err_5;
			break;
		case 6:
			$err_message = $l_err_6;
			break;
		case 7:
			$err_message = $l_err_7;
			break;
		}

		echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
	}
?>
	<div class="proj_info_div">
	<div class="proj_info_detail"><?php echo $l_info?></div>
	</div>
	<div class="proj_update_div">
	<form method="post" enctype="multipart/form-data" action="new_component.php" name="create_component" id="create_component" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
	<label><span class="note_info"><?php echo $l_req_field?> " <span class="mandi_field">*</span>".</span></label>
	<table>
	<tr>
	<td class="first">
	<div><label class="update_label"><?php echo $l_nc_name?><span class="mandi_field"> *</span> : </label>
	</div>
	</td><td>
	<input class="comp_name" type="text" name="title" value="" />
	</td>
	</tr><tr>
	<td class="first">
	<div><label class="update_label"><?php echo $l_nc_owner?><span class="mandi_field"> *</span> : </label></div>
	</td><td>
	<select class="work_user_id" name="owner">
<?php
	//$users = CommonUtil::getProjLeads($_SESSION['_project']->id);
	$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
	foreach($users as $uid => $user) echo '<option value="'.$uid.'" '.($_SESSION['_userId']==$uid ? ' SELECTED' : '').'>'.$user.'</option>';
?></select></td>
</tr><tr>
	<td class="first"><label class="update_label"><?php echo $l_nc_deadline?>:</label></td>
	<td><input type="text" class="deadline_input" name="end_date" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php echo (isset($_POST['end_date']) && !empty($_POST['end_date'])) ? $_POST['end_date'] : ''?>" />
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'create_component',
		// input name
		'controlname': 'end_date'
	});
	</script>
	<label>(<span class="note_info">e.g. 2010-01-21</span>)</label></td></tr>
	<tr>
	<td class="first">
	<label class="update_label"><?php echo $l_nc_milestone?>:</label></td>
	<td><select class="" name="is_milestone">
		<option value='N'><?php echo $l_select_no?></option>
		<option value='Y'><?php echo $l_select_yes?></option>
	</select></td>
	</tr>
	</table>
	<div><label class="update_label"><?php echo $l_nc_descript?>:</label><br/>
	<textarea name="description" class="work_description"></textarea>
	</div>
	<input type="hidden" value="1" name="status" />
	<!-- calendar attaches to existing form element -->
	<div><input type="submit" value="<?php echo $l_nc_submit?>" id="submit_button" class="update_submit_button" onmousedown="mousePress('submit_button');" onmouseout="mouseRelease('submit_button');" /></div>
</form>
</div>
</div></div></div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>