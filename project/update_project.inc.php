<?php
include_once ("../common/Objects.php");
if (!isset($_SESSION)) session_start();
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/SessionUtil.php");

if (!isset($_SESSION['_project']))
{
	header( 'Location: ../home/index.php' );
	exit;
}

include_once ("language/l_update_project.inc.php");

$proj = $_SESSION['_project'];
$update_result = 0;

if (isset($_POST['update_project_post']))
{
	if ( $_POST['update_id']==$proj->id )
	{
		if ( SecurityUtil::canUpdateProjectInfo() )
		{
			$update_creator = null;
			$update_owner = null;
	
			if( isset($_POST['owner']) && is_numeric($_POST['owner']) && 
				DatabaseUtil::isProjectMember($_POST['owner'], $_SESSION['_project']->id) &&
				isset($_POST['manager']) && is_numeric($_POST['manager']) && 
				DatabaseUtil::isProjectMember($_POST['manager'], $_SESSION['_project']->id) && 
				SecurityUtil::canUpdateProjectOwner() )
			{
				$update_creator = $_POST['owner'];
				$update_owner = $_POST['manager'];
			}

			$pname = (isset($_POST['pname']) && !empty($_POST['pname'])) ? trim($_POST['pname']) : null;

			if( isset($_POST['end_date']) && !empty($_POST['end_date']))
			{
				$end = strtotime($_POST['end_date']);
				$today = strtotime(date("Y-m-d"));
		
				if( $proj->end_date == $_POST['end_date'] || $end >= $today )
				{
					if(DatabaseUtil::updateProj( $proj->id, $pname, $update_owner, $update_creator, $_POST['description'], $_POST['status'], $_POST['end_date'] ))
						$update_result = 0;
					else $update_result = 1;
				}
				else $update_result = 2;
			}
			else {
				if(DatabaseUtil::updateProj( $proj->id, $pname, $update_owner, $update_creator, $_POST['description'], $_POST['status'], null))
					$update_result = 0;
				else $update_result = 1;
			}
	
			if ($update_result == 0) 
			{
				if(isset($_POST['pre_manager']) && isset($update_owner))
				{
					DatabaseUtil::updateRole($_POST['pre_manager'], $proj->id, "MEMB");
					DatabaseUtil::updateRole($update_owner, $proj->id, 'MANA');
				}
				if(isset($_POST['pre_owner']) && isset($update_creator))
				{
					if($update_owner!=$_POST['pre_owner'])
						DatabaseUtil::updateRole($_POST['pre_owner'], $proj->id, "MEMB");
					DatabaseUtil::updateRole($update_creator, $proj->id, 'OWNE');
				}
				$pre_stat = $proj->status;
				SessionUtil::selectProject($_SESSION['_userId'], $proj->id, $proj->s_id);
				$proj = $_SESSION['_project'];
				$post_stat = $proj->status;

				

				if ($pre_stat != 'COMP' && $post_stat == 'COMP')
				{
					$_SESSION['_cProjExist'] = true;
					unset($_SESSION['_oProjList']);

					$link = '<a href="../project/index.php?p_id='.$proj->id.'&sid='.$proj->s_id.'">'.$proj->title.'</a>';
					$users = DatabaseUtil::getUserListByProj($proj->id);
					while ($user = mysql_fetch_array($users, MYSQL_ASSOC))
					{
						if($user['u_id'] != $_SESSION['_userId'])
							DatabaseUtil::insertMessage( 'Project Complete - '.CommonUtil::truncate($proj->title, 13), 
														 $user['u_id'], 
														 $_SESSION['_userId'], 
														 'Project '.$link.' is completed.' );
					}

					DatabaseUtil::removeProjUserDefault($proj->id);
				}
				else if ($pre_stat == 'COMP' && $post_stat !='COMP')
				{
					unset($_SESSION['_cProjExist']);
					unset($_SESSION['_oProjList']);
				}
				else if( isset($pname) ) $_SESSION['_oProjList'][$proj->id]['title'] = $pname;
				$update_result = 0;
			}
			else if($update_result != 2) $update_result = 1;
		}
		else
		{
			$update_result = 3;
		}
	}
	else {
		$update_result = 4;
	}

	$_SESSION['update_project_result'] = $update_result;
	header( 'Location:../project/index.php?p_id='.$_POST['update_id'].'&sid='.$_POST['update_sid'] );
	exit;
}
else {
	if (isset($_SESSION['update_project_result']))
	{
		switch ($_SESSION['update_project_result'])
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
		}

		unset($_SESSION['update_project_result']);

		if(isset($err_message))
			echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
	}
}
?>
<div class="proj_update_div">
<div class="proj_deailt_link_div"><a id="proj_detail_link" href="javascript:showHideDiv('proj_detail_arrow', 'proj_update_form')"><?php echo $proj->title.$l_up_showhide?> <img id='proj_detail_arrow' class='double_arrow' src='../image/common/double_arrow_down.png'></img></a></div>
<div id="proj_update_form" class="proj_update_form">
<form method="post" enctype="multipart/form-data" action="update_project.inc.php" name="update_project" id="update_project" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
<table>
<tr>
<td><label class="update_label"><?php echo $l_up_title?></label></td>
<td><label for="creat_date"><?php if(SecurityUtil::canUpdateProjectOwner()) { ?>
<input id="pname" name="pname" value="<?php echo $proj->title?>" />
<?php } else {?>
<span class="update_value_date_span"><?php echo $proj->title?></span>
<?php }?>
</label></td></tr>
<tr>
<td><label class="update_label"><?php echo $l_up_create?></label></td>
<td><label for="creat_date"><span class="update_value_date_span"><?php echo $proj->create_date?></span></label></td>
</tr>
<tr>
<td><label class="update_label"><?php echo $l_up_dir?></label></td>
<td><?php
	$owner = $_SESSION['_projectCreator'];
	$manager = $_SESSION['_projectManager'];
	if (SecurityUtil::canUpdateProjectOwner())
	{
		echo '<select class="work_user_id" name="owner">';
		$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
		foreach($users as $uid => $user) echo '<option value="'.$uid.($owner->id==$uid ? '" SELECTED ' : '"').'>'.$user.'</option>';
		echo '</select><input type="hidden" value="'.$owner->id.'" name="pre_owner" />';
	}
	else
	{
		$name = ($_SESSION['_language']=='zh') ? $owner->fullname_cn : $owner->firstname ." ". $owner->lastname;
		echo '<label for="owner"><span class="update_value_span">'.$name." (". $owner->login_email .")</span></label>";
	}
?></td></tr>
<tr>
<td><label class="update_label"><?php echo $l_up_pm?></label></td>
<td><?php
	if (SecurityUtil::canUpdateProjectOwner())
	{
		echo '<select class="work_user_id" name="manager">';
		$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
		foreach($users as $uid => $user) echo '<option value="'.$uid.($manager->id==$uid ? '" SELECTED ' : '"').'>'.$user.'</option>';
		echo '</select><input type="hidden" value="'.$manager->id.'" name="pre_manager" />';
	}
	else
	{
		$name = ($_SESSION['_language']=='zh') ? $manager->fullname_cn : $manager->firstname ." ". $manager->lastname;
		echo '<label for="owner"><span class="update_value_span">'.$name." (". $manager->login_email .")</span></label>";
	}
?></td></tr>
	<tr>
	<td><label class="update_label"><?php echo $l_up_deadline?></label></td>
	<td><input type="text" name="end_date" class="deadline_input" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php echo (isset($proj->end_date) ? date('Y-m-d',strtotime($proj->end_date)) : "" )?>" />
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'update_project',
		// input name
		'controlname': 'end_date'
	});
	</script>
	<label>(<span class="note_info">e.g. 2010-01-21</span>)</label></td>
	</tr>
	<tr>
	<td><label class="update_label"><?php echo $l_up_status?></label></td>
	<td><select name="status">
	<?php
		$status = $_SESSION[DatabaseUtil::$PROJ_STATUS];
		foreach($status as $row)
			echo '<option value="'. $row['code'] . ($row['code']==$proj->status ? '" SELECTED ' : '"') .'>'. $row['description'] .'</option><br />';
	?>
	</select></td>
	</tr>
	</table>
	<div>
	<label class="update_label"><?php echo $l_up_descript?>:</label><br>
	<textarea name="description" class="work_description_update"><?php echo $proj->description?></textarea>
	</div>
	<div>
	<label class="update_label"><?php echo $l_up_role?> </label>
	<label for="project_role"><span class="update_value_span" style="color:#008;"><?php echo $_SESSION['_roleD']?></span></label>
	</div>
	<input type="hidden" value="<?php echo $proj->id?>" name="update_id" />
	<input type="hidden" value="<?php echo $proj->s_id?>" name="update_sid" />
	<input type="hidden" value="update_project_post" name="update_project_post" />
	<div><input id="update_submit_button" class="update_submit_button" onmousedown="mousePress('update_submit_button')" onmouseup="mouseRelease('update_submit_button')" onmouseout="mouseRelease('update_submit_button')" type="submit" value="<?php echo $l_up_submit?>" /></div>
</form>
</div>
</div>