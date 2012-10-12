<?php
include_once ("../common/Objects.php");
if (!isset($_SESSION)) session_start();
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

if (!isset($_SESSION['_component']))
{
	header( 'Location: index.php' );
	exit;
}

include_once ("language/l_update_component.inc.php");

$comp = $_SESSION['_component'];
$update_result = 0;

if (isset($_POST['update_component_post']))
{	
	$lastUpDate = DatabaseUtil::getCompDate($comp->id);
	if ( $_POST['update_id']==$comp->id && $_POST['last_update_date']==$lastUpDate )
	{
		if( (isset($_POST['owner']) && is_numeric($_POST['owner']) && SecurityUtil::canUpdateComponentOwner()) ||
			(!isset($_POST['owner']) && SecurityUtil::canUpdateComponentInfo()) )
		{
			if(isset($_POST['end_date']) && !empty($_POST['end_date']))
			{
				$end = strtotime($_POST['end_date']);
				$today = strtotime(date("Y-m-d"));

				if ( $comp->end_date == $_POST['end_date'] || $end >= $today )
				{
					$input_end_date = $_POST['end_date'];
				}
				else $update_result = 2;
			}
			else{
				$input_end_date = null;
			}

			$cname = (isset($_POST['cname']) && !empty($_POST['cname'])) ? trim($_POST['cname']) : null;

			if($update_result != 2)
			{
				$ownerdb = (isset($_POST['owner']) && is_numeric($_POST['owner'])) ? $_POST['owner'] : null;
	
				//if (DatabaseUtil::isProjectLeader($ownerdb, $_SESSION['_project']->id))
				if (!isset($ownerdb) || DatabaseUtil::isProjectMember($ownerdb, $_SESSION['_project']->id))
				{
					$update_result = DatabaseUtil::updateComp( $comp->id, 
															   $cname,
															   $ownerdb, 
															   $_POST['description'], 
															   $_POST['status'],
															   (isset($_POST['is_milestone'])&&($_POST['is_milestone']=='Y')) ? true : false,
															   $input_end_date );
					if ($update_result)
					{
						if( $comp->status!='COMP' && $_POST['status']=='COMP' ) $_SESSION['_cCompExist'][$_SESSION['_project']->id] = true;
						else unset($_SESSION['_cCompExist'][$_SESSION['_project']->id]);
						SessionUtil::selectComponent($_SESSION['_userId'], $comp->id, $comp->s_id);
						$comp = $_SESSION['_component'];
						$update_result = 0;
					}
					else $update_result = 1;
				}
				else $update_result = 4;
			}
		}
		else $update_result = 3;
	}
	else $update_result = 5;
	
	$_SESSION['update_component_result'] = $update_result;
	header( 'Location:../project/project_component.php?c_id='.$_POST['update_id'].'&sid='.$_POST['update_sid'] );
	exit;
}
else {
	if (isset($_SESSION['update_component_result']))
	{	
		switch ($_SESSION['update_component_result'])
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
		}

		unset($_SESSION['update_component_result']);

		if(isset($err_message))
			echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
	}
}
?>
<div class="proj_update_div">
<div class="proj_deailt_link_div"><a id="proj_detail_link" href="javascript:showHideDiv('comp_detail_arrow', 'proj_update_form')"><?php echo $comp->title.$l_uc_showhide?> <img id='comp_detail_arrow' class='double_arrow' src='../image/common/double_arrow_down.png'></img></a></div>
<div id="proj_update_form" class="proj_update_form">
<form method="post" enctype="multipart/form-data" action="update_component.inc.php" name="update_component" id="update_component" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
<table>
<tr>
<td class="first"><label class="update_label"><?php echo $l_uc_title?></label></td>
<td><?php if (SecurityUtil::canUpdateComponentOwner()) { ?>
<input id="cname" name="cname" value="<?php echo $comp->title?>" />
<?php } else {?>
<span class="update_value_date_span"><?php echo $comp->title?></span>
<?php } ?></td>
</tr>
<tr>
<td class="first"><label class="update_label"><?php echo $l_uc_owner?></label></td>
<td>
<?php
	$owner = $_SESSION['_componentOwner'];
	if (SecurityUtil::canUpdateComponentOwner())
	{
		echo '<select class="work_user_id" name="owner">';
		//$users = CommonUtil::getProjLeads($_SESSION['_project']->id);
		$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
		foreach($users as $uid => $user) echo '<option value="'.$uid.($owner->id==$uid ? '" SELECTED ' : '"').'>'.$user.'</option>';
		echo '</select>';
	}
	else
	{
		$name = ($_SESSION['_language'] == 'zh') ? $owner->lastname.$owner->firstname : $owner->firstname ." ". $owner->lastname;
		echo '<label for="owner"><span class="update_value_span">'.$name." (". $owner->login_email .")</span></label>";
	}
?></td>
</tr>
<tr>
<td class="first"><label class="update_label"><?php echo $l_uc_deadline?></label></td>
<td><input type="text" name="end_date" class="deadline_input" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php echo (isset($comp->end_date) ? date('Y-m-d',strtotime($comp->end_date)) : "") ?>" />
<script language="JavaScript">
new tcal ({
	// form name
	'formname': 'update_component',
	// input name
	'controlname': 'end_date'
});
</script>
<label>(<span class="note_info">e.g. 2010-01-21</span>)</label></td>
</tr>
<tr>
<td class="first"><label class="update_label"><?php echo $l_uc_status?></label></td>
<td><select name="status">
<?php
	$status = $_SESSION[DatabaseUtil::$PROJ_STATUS];
	foreach($status as $row)
		echo '<option value="'. $row['code'] . ($row['code']==$comp->status ? '" SELECTED ' : '"') .'>'. $row['description'] .'</option><br />';
?>
</select></td>
</tr>
<tr>
<td class="first"><label class="update_label"><?php echo $l_uc_milestone?></label></td>
<td><select class="" name="is_milestone">
	<option value='N' <?php echo ($comp->is_milestone ? '':'SELECTED')?>><?php echo $l_uc_no?></option>
	<option value='Y' <?php echo ($comp->is_milestone ? 'SELECTED':'')?>><?php echo $l_uc_yes?></option>
</select></td></tr>
</table>
<div><label class="update_label"><?php echo $l_uc_descript?>: </label><br />
<textarea name="description" class="work_description_update" style="height:80px;"><?php echo $comp->description?></textarea>
</div>
<input type="hidden" value="<?php echo $comp->id?>" name="update_id" />
<input type="hidden" value="<?php echo $comp->s_id?>" name="update_sid" />
<input type="hidden" value="update_component_post" name="update_component_post" />
<input type="hidden" value="<?php echo $comp->lastupdate_date?>" name="last_update_date" />
<div><input id="update_submit_button" class="update_submit_button" onmousedown="mousePress('update_submit_button')" onmouseup="mouseRelease('update_submit_button')" onmouseout="mouseRelease('update_submit_button')" type="submit" value="<?php echo $l_uc_submit?>" /></div>
</form>
</div>
</div>