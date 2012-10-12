<?php
include_once ("../common/Objects.php");
if (!isset($_SESSION)) session_start();
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/MessageUtil.php");

if (!isset($_SESSION['_workitem']))
{
	header( 'Location: index.php' );
	exit;
}

$wi = $_SESSION['_workitem'];

include_once ("language/l_update_workitem.inc.php");

if (isset($_POST['update_workitem_post']))
{
	$lastUpDate = DatabaseUtil::getWorkItemDate($wi->id);
	if ( $_POST['update_id']==$wi->id && $_POST['last_update_time']==$lastUpDate )
	{
		if ( SecurityUtil::canUpdateWorkitem() )
		{
			$today = strtotime(date("Y-m-d"));

			if (isset($_POST['objective']) && !empty($_POST['objective']))
			{
				if( isset($_POST['owner']) && is_numeric($_POST['owner']) )
				{
					$ownerdb = $_POST['owner'];

					if (DatabaseUtil::isProjectMember($ownerdb, $_SESSION['_project']->id))
					{
						$statOld = $wi->status;
						$update_result = DatabaseUtil::updateWorkItem( $wi->id, 
																	   $ownerdb,
																	   isset($_POST['component'])&&is_numeric($_POST['component']) ? $_POST['component'] : null,
																	   isset($_POST['workpackage'])&&is_numeric($_POST['workpackage']) ? $_POST['workpackage'] : null,
																	   $_POST['objective'],
																	   $_POST['description'], 
																	   $_POST['status'],
																	   $_POST['priority'],
																	   $_POST['end_date'] );
						if ($update_result)
						{
							if( $statOld != $_POST['status'] && $_SESSION['_userId'] != $wi->creator_id )
								MessageUtil::sendWorkitemStatusChangeMessage($wi->id, $statOld);

							$old_comp = isset($wi->comp_id) ? $wi->comp_id : 0;
							$cur_comp = isset($_POST['component']) ? $_POST['component'] : 0;
							if( $old_comp != $cur_comp )
								DatabaseUtil::moveWorkitemDocToComponent( $wi->id, $cur_comp );

							SessionUtil::clearComponentSession();
							SessionUtil::selectWorkItem($_SESSION['_userId'], $wi->id, $wi->s_id);

							if( $_POST['status']=='DONE' ) {
								if( isset($_SESSION['_component']) && !empty($_SESSION['_component']) )
									header( 'Location: ../project/project_component.php' );
								else header( 'Location: ../project/index.php' );
								exit;
							}

							$wi = $_SESSION['_workitem'];
							$update_result = 0;
						}
						else $update_result = 1;
					}
					else $update_result = 4;
				}
				else $update_result = 6;
			}
			else $update_result = 2;
		}
		else $update_result = 3;
	}
	else $update_result = 5;

	$_SESSION['update_workitem_result'] = $update_result;
	if($update_result == 0) MessageUtil::sendSubscriptionMessage( $wi->id, false );
	header( 'Location:work_item.php?wi_id='.$_POST['update_id'].'&sid='.$_POST['update_sid'] );
	exit;
}
else {
	if (isset($_SESSION['update_workitem_result']))
	{	
		switch ($_SESSION['update_workitem_result'])
		{
		case 0:
			echo '<div class="update_error_message"><label><span class="msg_suc">'.$l_suc_0.'</span></label></div>';
			break;
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

		unset($_SESSION['update_workitem_result']);
		
		if(isset($err_message))
			echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
	}
}

function checkOwnerFormat($inOwner)
{
	return eregi("^[^\(]* \([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})\)$", $inOwner);
}
?>
<div class="proj_update_div">
<form method="post" enctype="multipart/form-data" action="update_workitem.inc.php" name="update_workitem" id="update_workitem" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
<div><label class="update_label"><?php echo $l_uwi_summary?><span class="mandi_field"> *</span>: </label><input class="work_objective" type="text" name="objective" value="<?php echo str_replace('"', '&quot;', $wi->title)?>" /></div>
<table style="width:530px;margin:10px 0 10px 0">
<tr>
<td style="width:30%"><label class="update_label"><?php echo $l_uwi_owner?> : </label></td>
<td><?php
	$owner = $_SESSION['_workitemOwner'];
	if (SecurityUtil::canUpdateWorkitem())
	{
		echo '<select class="work_user_id" name="owner">';
		$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
		foreach($users as $uid => $user) echo '<option value="'.$uid.($owner->id==$uid ? '" SELECTED ' : '"').'>'.$user.'</option>';
		echo '</select>';
	}
	else
	{
		$name = ($_SESSION['_language']=='zh') ? $owner->fullname_cn : $owner->firstname ." ". $owner->lastname;
		echo '<label for="owner" class="wi_owner">'.$name." ( ". $owner->login_email ." )";
	}
?></td></tr>
<?php
if( !isset($_SESSION['_compExist'][$_SESSION['_project']->id]) )
	$_SESSION['_compExist'][$_SESSION['_project']->id] = DatabaseUtil::hasComponent($_SESSION['_project']->id);
if( $_SESSION['_compExist'][$_SESSION['_project']->id] ) {
	echo '<tr><td><label class="update_label">'.$l_uwi_comp.' : </label></td><td>';
	echo '<select class="work_user_id" name="component" id="component" onchange="javascript:getCompWp(\'component\', \'workpackage\', \''.$proj->id.'\')">';
	echo '<option value=""></option>';
	$comps = DatabaseUtil::getProjCompList($proj->id);
	while($comp = mysql_fetch_array($comps, MYSQL_ASSOC))
		echo '<option value="'.$comp['id'].($comp['id']==$wi->comp_id ? '" SELECTED': '"').'>'.$comp['title'].'</option>';
	echo '</select></td></tr>';
} ?>
<!-- tr><td><label class="update_label"><?php echo $l_uwi_wp?>:</label></td>
<td>
<select class="work_user_id" name="workpackage" id="workpackage">
<option value="" ></option>
<?php 
//	$wp_id = $wi->workpackage_id;
//	if(isset($wp_id) && is_numeric($wp_id)) $_GET['i']=$wp_id;
//	if(isset($wi->comp_id) && is_numeric($wi->comp_id)) {
//		$_GET['c']=$wi->comp_id; 
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
<td><label class="update_label"><?php echo $l_uwi_create?> : </label></td>
<td><label for="creator"><span class="update_value_span"><?php $creator = $_SESSION['_workitemCreator']; echo ($_SESSION['_language']=='zh') ? $creator->fullname_cn : $creator->firstname ." ". $creator->lastname;?></span></label><label for="creat_date"><span class="update_value_date_span"> <?php echo $wi->creation_time?></span></label></td>
</tr>
<tr>
<td><label class="update_label"><?php echo $l_uwi_last?> : </label></td>
<td><label for="last_update_user"><span class="update_value_span"><?php $lastUp = $_SESSION['_workitemLaup']; echo ($_SESSION['_language']=='zh') ? $lastUp->fullname_cn : $lastUp->firstname .' '. $lastUp->lastname;?></span></label><label for="last_update_date"><span class="update_value_date_span"> <?php echo $wi->lastupdated_time?></span></label>
</td>
</tr>
</table>
<table>
<tr>
<td class="update_input_table">
<table>
<tr>
<td><label class="update_label"><?php echo $l_uwi_type?>: </label></td>
<td style="height:32px;"><label for="type" class="update_label_value"><?php echo DatabaseUtil::getEnumDescription(DatabaseUtil::$WI_TYPE, $wi->type)?></label>
<img id="img_type" class="enum_img" src="../image/type/<?php echo $wi->type;?>.gif" /></td>
</tr>
<tr>
<td><label class="update_label"><?php echo $l_uwi_status?>: </label></td>
<td><select name="status">
<?php
	$status = $_SESSION[DatabaseUtil::$WI_STATUS];
	foreach($status as $row)
		echo '<option value="'. $row['code'] . ($row['code']==$wi->status ? '" SELECTED ' : '"') .'>'. $row['description'] .'</option><br />';
?>
</select></td>
</tr>
</table>
</td>
<td>
<table>
<tr>
<td><label class="update_label"><?php echo $l_uwi_priority?>: </label></td>
<td><select name="priority" id="priority">
<?php
	$priority = $_SESSION[DatabaseUtil::$PRIORITY];
	foreach($priority as $row)
		echo '<option value="'. $row['code'] . ($row['code']==$wi->priority ? '" SELECTED ' : '"') .'>'. $row['description'] .'</option><br />';
?>
</select><img id="img_priority" class="enum_img" src="../image/priority/<?php echo $wi->priority;?>.gif" /></td>
</tr>
<tr>
<td><label class="update_label"><?php echo $l_uwi_deadline?> <span class="italic_info">(yyyy-mm-dd)</span>: </label></td>
<td><input type="text" name="end_date" class="deadline_input" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php echo date('Y-m-d',strtotime($wi->deadline))?>" />
	<script language="JavaScript">new tcal({'formname': 'update_workitem', 'controlname': 'end_date'});</script></td>
</tr>
</table>
</td>
</tr>
</table>
<div><label class="update_label"><?php echo $l_uwi_descript?>: </label>
<textarea name="description" class="work_description_update"><?php echo $wi->description?></textarea>
</div>
<input type="hidden" value="<?php echo $wi->id?>" name="update_id" />
<input type="hidden" value="<?php echo $wi->s_id?>" name="update_sid" />
<input type="hidden" value="update_workitem_post" name="update_workitem_post" />
<input type="hidden" value="<?php echo $wi->lastupdated_time?>" name="last_update_time" />
<div><input id="update_submit_button" class="update_submit_button" onmousedown="mousePress('update_submit_button')" onmouseup="mouseRelease('update_submit_button')" onmouseout="mouseRelease('update_submit_button')" type="submit" value="<?php echo $l_uwi_submit?>" /></div>
</form>
</div>