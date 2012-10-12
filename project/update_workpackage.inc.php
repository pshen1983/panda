<?php
include_once ("../common/Objects.php");
if (!isset($_SESSION)) session_start();
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

if (!isset($_SESSION['_workpackage']))
{
	header( 'Location: index.php' );
	exit;
}

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_uwp_summary = 'Summary';
	$l_uwp_owner = 'Workpackage Owner';
	$l_uwp_create = 'Created by';
	$l_uwp_last = 'Last Updated by';
	$l_uwp_status = 'Status';
	$l_uwp_deadline = 'Deadline';
	$l_uwp_descript = 'Description';
	$l_uwp_submit = 'Update';

	$l_suc_0 = '- Workpackage has been saved successfully.';
	$l_err_1 = '- System is temporarily busy, please try again later.';
	$l_err_2 = '- Workpackage deadline must be after today.';
	$l_err_3 = '- You do NOT have enough priviliage to update this Workpackage.';
	$l_err_4 = '- The owner you specified is NOT a member of this project.';
	$l_err_5 = '- The Workpackage you are trying to change has been updated, please refres and try again.';
	$l_err_6 = '- The Workpackage summary cannot be empty.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
	$l_uwp_summary = '&#31616;&#20171;';
	$l_uwp_owner = '&#39033;&#30446;&#32452;&#25152;&#26377;&#32773;';
	$l_uwp_create = '&#26032;&#24314;&#29992;&#25143;';
	$l_uwp_last = '&#26368;&#21518;&#20462;&#25913;&#29992;&#25143;';
	$l_uwp_status = '&#29366;&#24577;';
	$l_uwp_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_uwp_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_uwp_submit = '&#26356;&#26032;';
	
	$l_suc_0 = '&#8212; &#24037;&#20316;&#21253;&#25104;&#21151;&#26356;&#26032;&#12290;';
	$l_err_1 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_2 = '&#8212; &#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290;';
	$l_err_3 = '&#8212; &#24744;&#27809;&#26377;&#36275;&#22815;&#26435;&#38480;&#26356;&#25913;&#27492;&#24037;&#20316;&#21253;&#12290;';
	$l_err_4 = '&#8212; &#24037;&#20316;&#21253;&#25152;&#26377;&#32773;&#19981;&#26159;&#26412;&#39033;&#30446;&#25104;&#21592;&#12290;';
	$l_err_5 = '&#8212; &#24037;&#20316;&#21253;&#24050;&#34987;&#26356;&#25913;&#65292;&#35831;&#21047;&#26032;&#21518;&#20877;&#35797;&#12290;';
	$l_err_6 = '&#8212; &#24037;&#20316;&#21253;&#31616;&#20171;&#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}

//=========================================================================================================

$wp = $_SESSION['_workpackage'];

if (isset($_POST['update_workpackage_post']))
{
	$lastUpDate = DatabaseUtil::getWorkPackageDate($wp->id);
	if ( $_POST['update_id']==$wp->id && $_POST['last_update_date']==$lastUpDate )
	{
		if(isset($_POST['objective']) && !empty($_POST['objective']))
		{
			if ( (isset($_POST['owner']) && is_numeric($_POST['owner']) && SecurityUtil::canUpdateworkpackageOwner()) ||
			 	 (!isset($_POST['owner']) && SecurityUtil::canUpdateworkpackageInfo()) )
			{
				$end = strtotime($_POST['end_date']);
				$today = strtotime(date("Y-m-d"));

				if( $wp->end_date == $_POST['end_date'] || $end >= $today )
				{
					if(isset($_POST['owner']) && is_numeric($_POST['owner']))
					{
						$ownerdb = $_POST['owner'];
		
						if( DatabaseUtil::isProjectMember($ownerdb, $_SESSION['_project']->id) )
						{
							$update_result = DatabaseUtil::updateWorkPackage( $wp->id, 
																			  $ownerdb['id'],
																			  $_POST['objective'],
																			  $_POST['description'], 
																			  $_POST['status'],
																			  $_POST['end_date'] );
							if ($update_result)
							{
								SessionUtil::selectWorkpackage($_SESSION['_userId'], $wp->id, $wp->s_id);
								$wp = $_SESSION['_workpackage'];
								$update_result = 0;
							}
							else $update_result = 1;
						}
						else $update_result = 4;
					}
					else
					{
						$update_result = DatabaseUtil::updateWorkPackage( $wp->id, 
																		  null,
																		  $_POST['objective'],
																		  $_POST['description'], 
																		  $_POST['status'],
																		  $_POST['end_date'] );
							if ($update_result)
								$update_result = 0;
							else $update_result = 1;
					}
				}
				else $update_result = 2;
			}
			else
			{
				$update_result = 3;
			}
		}
		else $update_result = 6;
	}
	else {
		$update_result = 5;
	}

	$_SESSION['update_workpackage_result'] = $update_result;
	$_SESSION['owner'] = $_POST['owner'];
	header( 'Location:work_package.php?wp_id='.$_POST['update_id'].'&sid='.$_POST['update_sid'] );
	exit;
}
else {
	if (isset($_SESSION['update_workpackage_result']))
	{
		echo "<p>";
	
		switch ($_SESSION['update_workpackage_result'])
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
			break;;
		case 5:
			$err_message = $l_err_5;
			break;
		case 6:
			$err_message = $l_err_6;
			break;
		}

		echo "</p>";

		unset($_SESSION['update_workpackage_result']);
		unset($_SESSION['owner']);

		if(isset($err_message))
			echo '<div class="update_error_message"><label><span class="msg_err">'.$err_message.'</span></label></div>';
	}
}
?>

<div class="proj_update_div">
<form method="post" enctype="multipart/form-data" action="update_workpackage.inc.php" name="update_workpackage" id="update_workpackage" class="proj_update_form" accept-charset="UTF-8" onsubmit="document.getElementById('end_date').disabled=false;">
	<div><label class="update_label"><?php echo $l_uwp_summary?><span class="mandi_field">*</span> : </label><input class="work_objective" name="objective" maxlength="254" value="<?php echo str_replace('"', '&quot;', $wp->objective)?>" /></div>
	<div><label class="update_label"><?php echo $l_uwp_owner?> :</label> 
<?php
	$owner = $_SESSION['_workpackageOwner'];
	if (SecurityUtil::canUpdateWorkpackageOwner())
	{
		echo '<select class="work_user_id" name="owner">';
		$users = CommonUtil::getProjUsers($_SESSION['_project']->id);
		foreach($users as $uid => $user) echo '<option value="'.$uid.($owner->id==$uid ? '" SELECTED ' : '"').'>'.$user.'</option>';
		echo '</select> <span class="mandi_field">*</span>';
	}
	else
	{
		$name = ($_SESSION['_language']=='zh') ? $owner->fullname_cn : $owner->firstname ." ". $owner->lastname;
		echo '<label for="owner">'.$name."(". $owner->login_email .")";
	}
?>
</div>
<div>
<table>
<tr>
<td><label class="update_label"><?php echo $l_uwp_create?>: </label></td>
<td><label for="creator"><span class="update_value_span"><?php $creator = $_SESSION['_workpackageCreator']; echo ($_SESSION['_language']=='zh') ? $creator->fullname_cn : $creator->firstname ." ". $creator->lastname;?></span> </label><label for="creat_date"><span class="update_value_date_span">(<?php echo $wp->creation_time?>)</span></label></td>
</tr>
<tr>
<td><label class="update_label"><?php echo $l_uwp_last?>: </label></td>
<td><label for="last_update_user"><span class="update_value_span"><?php $lastUp = $_SESSION['_workpackageLaup']; echo ($_SESSION['_language']=='zh') ? $lastUp->fullname_cn : $lastUp->firstname .' '. $lastUp->lastname;?></span> </label><label for="last_update_date"><span class="update_value_date_span">(<?php echo $wp->lastupdated_time?>)</span></label>
</td>
</tr>
</table>
</div>
<div>
<table>
<tr>
<td class="update_input_table"><label class="update_label"><?php echo $l_uwp_status?>: </label>
<select name="status">
<?php
	$status = $_SESSION[DatabaseUtil::$WP_STATUS];
	foreach($status as $row)
		echo '<option value="'. $row['code'] . ($row['code']==$wp->status ? '" SELECTED ' : '"') .'>'. $row['description'] .'</option><br />';
?>
	</select></td>

<td class="update_input_table"><label class="update_label"><?php echo $l_uwp_deadline?> <span class="italic_info">(yyyy-mm-dd)</span>: </label>
<input type="text" name="end_date" class="deadline_input" id="end_date" disabled title="<?php echo $l_calendar?>" value="<?php echo date('Y-m-d',strtotime($wp->deadline))?>" />
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'update_workpackage',
		// input name
		'controlname': 'end_date'
	});
	</script></td>
</tr>
</table></div>

	<div><label class="update_label"><?php echo $l_uwp_descript?>:</label><br>
	<textarea name="description" class="work_description_update"><?php echo $wp->description?></textarea>
	</div>
	<input type="hidden" value="<?php echo $wp->id?>" name="update_id" />
	<input type="hidden" value="<?php echo $wp->s_id?>" name="update_sid" />
	<input type="hidden" value="update_workpackage_post" name="update_workpackage_post" />
	<input type="hidden" value="<?php echo $wp->lastupdated_time?>" name="last_update_date" />
	<div><input id="update_submit_button" class="update_submit_button" onmousedown="mousePress('update_submit_button')" onmouseup="mouseRelease('update_submit_button')" onmouseout="mouseRelease('update_submit_button')" type="submit" value="<?php echo $l_uwp_submit?>" /></div>
</form>
</div>