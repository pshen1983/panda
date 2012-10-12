<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/MessageUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if (isset($_POST['status']) && isset($_SESSION['_project']))
{
	if( isset($_POST['objective']) && !empty($_POST['objective']) &&
		isset($_POST['owner']) && is_numeric($_POST['owner']) &&
		isset($_POST['type']) && !empty($_POST['type']) &&
		isset($_POST['priority']) && !empty($_POST['priority']) &&
		isset($_POST['end_date']) && !empty($_POST['end_date']) )
	{
		if(DatabaseUtil::isProjectMember($_SESSION['_userId'], $_SESSION['_project']->id))
		{
			$result = 0;

			$proj = $_SESSION['_project'];
			$ownerdb = $_POST['owner'];
			$comp_id = null;
			$wp_id = null;

			if(isset($_POST['workpackage']) && !empty($_POST['workpackage']))
			{
				$wp_check = DatabaseUtil::getWorkPackage($_POST['workpackage']);
				if(isset($_POST['component']) && !empty($_POST['component']))
				{
					$comp_check = DatabaseUtil::getComp($_POST['component']);
					$comp_id = (isset($comp_check['p_id']) && $comp_check['p_id']==$proj->id) ? $_POST['component'] : -1;
					$wp_id = (isset($wp_check['comp_id']) && $wp_check['comp_id']==$_POST['component']) ? $_POST['workpackage'] : -1;
				}
				else
				{
					$wp_id = (isset($wp_check['proj_id']) && $wp_check['proj_id']==$proj->id) ? $_POST['workpackage'] : -1;
				}
			}

			if(isset($_POST['component']) && !empty($_POST['component']))
			{
				$comp_check = DatabaseUtil::getComp($_POST['component']);
				$comp_id = (isset($comp_check['p_id']) && $comp_check['p_id']==$proj->id) ? $_POST['component'] : -1;
				SessionUtil::selectComponent($_SESSION['_userId'], $comp_id, $comp_check['s_id']);
			}

			if($comp_id!=-1 && $wp_id!=-1) {
				if (DatabaseUtil::isProjectMember($ownerdb, $proj->id))
				{
					$sId = CommonUtil::genRandomNumString(8);
					$result = DatabaseUtil::insertWorkItem( $ownerdb, 
															$_SESSION['_userId'], 
															$proj->id,
															$comp_id,
															$wp_id, 
															$_POST['objective'],
															$_POST['description'],
															$_POST['type'],
															$_POST['priority'], 
															$_POST['end_date'], 
															$sId );
					if ($result)
					{
						$newId = DatabaseUtil::getWorkItemId($ownerdb, $_SESSION['_userId'], $proj->id, $sId);
						if( isset($_POST['form_hidden_input']) && is_numeric($_POST['form_hidden_input']) )
						{
							$count = $_POST['form_hidden_input'];

							for($ind=0; $ind<$count; $ind++)
							{
								if (isset($_POST['follow_email_'.$ind]) && is_numeric($_POST['follow_email_'.$ind])) 
								{
									$userId = $_POST['follow_email_'.$ind];
									if( $userId != $_SESSION['_userId'] &&
										!DatabaseUtil::isUserSubscribedToWorkitem( $newId, $userId ) &&
										DatabaseUtil::isProjectMember( $userId, $_SESSION['_project']->id) )
									{
										DatabaseUtil::insertSubscription($_SESSION['_project']->id, $newId, $userId);
									}
								}
							}
						}

						if($ownerdb != $_SESSION['_userId']) MessageUtil::sendNewWorkItemMessage($newId);
						MessageUtil::sendSubscriptionMessage( $newId, true );
						if( $ownerdb!=$_SESSION['_userId'] && !DatabaseUtil::isUserSubscribedToWorkitem( $newId, $_SESSION['_userId'] ) )
							DatabaseUtil::insertSubscription($_SESSION['_project']->id, $newId, $_SESSION['_userId']);
						if( $ownerdb==$_SESSION['_userId'] && isset($_SESSION['_component']) && !empty($_SESSION['_component']) ) {
							header( 'Location: ../project/project_component.php' );
						}
						else if( $ownerdb==$_SESSION['_userId'] ){
							header( 'Location: ../project/index.php' );
						}
						else {
							header( 'Location: work_item.php?wi_id='. $newId .'&sid='. $sId );
						}
						exit;
					}
					else $result = 2;
				}
				else $result = 2;
			}
			else $result = 6;
		}
		else $result = 4;
	}
	else $result = 5;
	
}
else if (!isset($_SESSION['_project']))$result = 3;

include_once ("language/l_new_workitem.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" type='text/css' href="../css/AutoComplete.css" media="screen" /> 
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
<link rel="stylesheet" type='text/css' href="css/project_layout.css" />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script language="JavaScript" src="../js/jquery.js"></script>
<script type='text/javascript' src="../js/jquery-ext.js"></script>
<script language="JavaScript" src="../js/common.js"></script>
<script language="JavaScript">
function setConfirmUnload(on){ window.onbeforeunload = (on) ? unloadMessage : null; }
function unloadMessage(){ return '<?php echo $l_leave?>'; }
$(document).ready(function() {
$("#type").change(function() { $("#img_type").attr("src", "../image/type/"+$(this).val()+".gif"); });
$("#priority").change(function() { $("#img_priority").attr("src", "../image/priority/"+$(this).val()+".gif"); });
addProjectActionMenu();
adjustHeight();
setInterval( longpollLeftNav, 5000 );
$("#create_workitem").bind("submit", function() { setConfirmUnload(false); });
$("#create_workitem").bind("change", function() { setConfirmUnload(true); }); // Prevent accidental navigation away
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
<div id="page_title"><label><?php echo $l_create?><span id="page_title_const"><?php echo $l_create_wi?></span></label></div>
<?php
if (isset($result))
{
	echo "<p style=\"position:absolute; top:180px; left:0px; \">";

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
	}

	echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
}
?>
<div class="proj_info_div">
<div class="proj_info_detail"><?php echo $l_info?></div>
</div>
<div class="proj_update_div">
<form method="post" enctype="multipart/form-data" action="new_workitem.php" name="create_workitem" id="create_workitem" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
<label><span class="note_info"><?php echo $l_req_field?> " <span class="mandi_field">*</span>".</span></label>
<div><label class="update_label"><?php echo $l_nwi_name?><span class="mandi_field"> *</span>: </label>
<input class="work_objective" name="objective" maxlength="254" value="<?php if(isset($_POST['objective']) && !empty($_POST['objective'])) echo $_POST['objective']?>"/>
</div>
<table id="new_wi_detail">
<tr><td class="first"><label class="update_label"><?php echo $l_nwi_owner?> <span class="mandi_field">*</span> : </label></td>
<td>
<?php
echo '<select class="work_user_id" name="owner">';
$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
foreach($users as $uid => $user) echo '<option value="'.$uid.'"'.(isset($_POST['owner']) && $_POST['owner']==$uid ? ' SELECTED' : ($_SESSION['_userId']==$uid ? ' SELECTED' : '')).'>'.$user.'</option>';
echo '</select>';
?></td></tr>
<?php
if( !isset($_SESSION['_compExist'][$_SESSION['_project']->id]) )
	$_SESSION['_compExist'][$_SESSION['_project']->id] = DatabaseUtil::hasComponent($_SESSION['_project']->id);
if( $_SESSION['_compExist'][$_SESSION['_project']->id] ) { 
	echo '<tr><td class="first"><label class="update_label">'.$l_nwi_pc_blong.' :</label></td><td>'; 
	echo '<select class="work_user_id" name="component" id="component" onchange="javascript:getCompWp(\'component\', \'workpackage\', \''.$proj->id.'\')">';
	echo '<option value=""></option>';
	$comps = DatabaseUtil::getProjCompList($proj->id);
	while($comp = mysql_fetch_array($comps, MYSQL_ASSOC))
		echo '<option value="'.$comp['id'].(isset($_SESSION['_component']) && $comp['id']==$_SESSION['_component']->id ? '" SELECTED': '"').'>'.$comp['title'].'</option>';
	echo '</select></td></tr>';
} ?>
<!-- tr><td><label class="update_label"><?php echo $l_nwi_wp_blong?>:</label></td>
<td>
<select class="work_user_id" name="workpackage" id="workpackage">
<option value="" ></option>
<?php 
//	if(isset($_SESSION['_workpackage'])) $_GET['i']=$_SESSION['_workpackage']->id;
//	if(isset($_SESSION['_component'])) {
//		$_GET['c']=$_SESSION['_component']->id; 
//		include_once '../project/get_comp_wp.inc.php';
//		unset($_GET['c']);
//	} 
//	else {
//		$_GET['p']=$proj->id; 
//		include_once '../project/get_proj_wp.inc.php';
//		unset($_GET['p']);
//	} 
//	if(isset($_GET['i'])) unset($_GET['i']);
?>
</select>
</td></tr -->
<tr>
<td class="first"><label class="update_label"><?php echo $l_nwi_type?><span class="mandi_field"> *</span> :</label></td>
<td><select name="type" id="type">
<?php 
	$wi_type = $_SESSION[DatabaseUtil::$WI_TYPE];
	foreach($wi_type as $row_type)
		echo '<option value="'. $row_type['code'] .'"'.(isset($_POST['type']) && $_POST['type']==$row_type['code'] ? ' SELECTED' : '').'>'. $row_type['description'] .'</option><br />';
?></select><img id="img_type" class="enum_img" src="../image/type/<?php echo (isset($_POST['type']) ? $_POST['type'] : $wi_type[0]['code'])?>.gif" />
</td>
</tr>
<tr>
<td class="first">
<label class="update_label"><?php echo $l_nwi_priority?><span class="mandi_field"> *</span> :</label></td>
<td>
<select name="priority" id="priority">
<?php 
	$wi_type = $_SESSION[DatabaseUtil::$PRIORITY];
	foreach($wi_type as $row_priority)
		echo '<option value="'. $row_priority['code'] .'"'.(isset($_POST['priority']) && $_POST['priority']==$row_priority['code'] ? ' SELECTED' : '').'>'. $row_priority['description'] .'</option><br />';
?></select><img id="img_priority" class="enum_img" src="../image/priority/<?php echo (isset($_POST['priority']) ? $_POST['priority'] : $wi_type[0]['code'])?>.gif" />
</td>
</tr>
<tr><td class="first"><label class="update_label"><?php echo $l_nwi_deadline?> (yyyy-mm-dd)<span class="mandi_field"> *</span> :</label></td>
<td>
<input type="text" name="end_date" class="deadline_input" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php 
if( isset($_POST['end_date']) ) 
	echo $_POST['end_date'];
else if( isset($_GET['end_date']) ) 
	echo $_GET['end_date'];
?>" />
<script language="JavaScript">new tcal ({ 'formname': 'create_workitem', 'controlname': 'end_date' });</script>
<label>(<span class="note_info">e.g. 2010-01-21</span>)</label>
</td></tr>
</table>
<div id="more_follow_div">
<table>
<tbody id="follow_sec">
<tr id="follow_0">
<td><label class="update_label"><?php echo $l_nwi_follow?>:</label></td>
<td class="invite_table_input_td"><?php
echo '<select class="work_user_id" name="follow_email_0" id="follow_email_0"><option value="0"></option>';
$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
foreach($users as $uid => $user) echo '<option value="'.$uid.'"'.(isset($_POST['follow_email_0']) && $_POST['follow_email_0']==$uid ? ' SELECTED' : '').'>'.$user.'</option>';
echo '</select>';?></td>
</tr>
</tbody>
</table>
<div id="more_follow_botton">
<input id="more_follow_button" type="button" onmousedown="mousePress('more_follow_button')" onmouseup="mouseRelease('more_follow_button')" onmouseout="mouseRelease('more_follow_button')" onClick="javascript:addMoreWIFollower('follow', 1, 'form_hidden_input', '<?php echo $l_nwi_follow_btn?>', '<?php echo $l_nwi_follow?>:')" value="<?php echo $l_nwi_follow_btn?>" />
</div>
<input id="form_hidden_input" type="hidden" value="1" name="form_hidden_input" />
<p id="follow_note"><?php echo $l_follow_note?></p>
</div>
<div><label class="update_label"><?php echo $l_nwi_descript?>:</label><br/>
<textarea name="description" class="work_description"></textarea>
</div>
<input type="hidden" value="NEWA" name="status" />
<div><input type="submit" value="<?php echo $l_nwi_submit?>" id="submit_button"  class="update_submit_button" onmousedown="mousePress('submit_button')" onmouseout="mouseRelease('submit_button')" /></div>
</form>
</div>
</div></div></div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>