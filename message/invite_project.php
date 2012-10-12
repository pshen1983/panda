<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

include_once ("language/l_invite_project.inc.php");

if( isset($_POST['invite_proj']) && !empty($_POST['invite_proj']) &&
	isset($_POST['form_hid_input']) && $_POST['form_hid_input']>=0 )
{
	$result = array();
	$count = $_POST['form_hid_input'];

	for($ind=0; $ind<$count; $ind++)
	{
		if (isset($_POST['user_email_'.$ind]) && !empty($_POST['user_email_'.$ind])) 
		{
			if(CommonUtil::validateEmailFormat($_POST['user_email_'.$ind]))
			{
				if(DatabaseUtil::emailExists($_POST['user_email_'.$ind]))
				{
					$user = DatabaseUtil::getUserByEmail($_POST['user_email_'.$ind]);

					if(!DatabaseUtil::isProjectMember($user['id'], $_POST['invite_proj']))
					{
						if(!DatabaseUtil::invitationExist($_SESSION['_userId'], $_POST['user_email_'.$ind], $_POST['invite_proj']))
						{
							$sId = sha1( uniqid() );
							$insert = DatabaseUtil::insertProjInvitation( $_SESSION['_userId'], 
																		  $_POST['user_email_'.$ind], 
																		  $_POST['invite_proj'], 
																		  (isset($_POST['description']) ? $_POST['description'] : ""),
																		  $sId );
							if($insert)
								$result[$ind] = 0;
							else
								$result[$ind] = 1; //system error
						}
						else $result[$ind] = 6; //invitation already exist
					}
					else $result[$ind] = 2; //already a member
				}
				else if(!DatabaseUtil::invitationExist($_SESSION['_userId'], $_POST['user_email_'.$ind], $_POST['invite_proj']))
				{
					$sId = sha1( uniqid() );
					$insert = DatabaseUtil::insertProjInvitation( $_SESSION['_userId'], 
																  $_POST['user_email_'.$ind], 
																  $_POST['invite_proj'], 
																  (isset($_POST['description']) ? $_POST['description'] : ""),
																  $sId );
					if($insert)
						$result[$ind] = 3; //not registerted
					else
						$result[$ind] = 1; //system error
				}
				else $result[$ind] = 6; //invitation already exist
			}
			else $result[$ind] = 4; //format
		}
		else $result[$ind] = 5; //empty
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
	<link rel='stylesheet' type='text/css' href='css/mess_layout.css' />
	<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
	<script language="JavaScript" src="../js/common.js"></script>
	<script language="JavaScript" src="../js/message.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div style="text-align:left;margin-left:20px;margin-top:8px;"><label style="color:blue;">&laquo; <a class="back_invi" href="../message/invitation.php"> <?php echo $l_back_prof?></a></label></div>
	<div class="invite_proj">
	<div class="Invitation_header_label"><label><?php echo $l_header?></label></div>
	<div class="page_saperator"></div>
	<form id="team_invite" class='invite_form' method="post" enctype="multipart/form-data" action="invite_project.php" accept-charset="UTF-8">
	<table style="width:100%">
	<tbody id="invitation_sec">
	<tr>
	<td><label class="invite_disp_label"><?php echo $l_select_proj?>:</label></td>
	<td>
<?php
	$hasSelect = false;
	echo '<select name="invite_proj">';
	if(!isset($_SESSION['_oProjList'])) SessionUtil::getUserOpenProjList();

	$size = count($_SESSION['_oProjList']);
	$manager = 'MANA';
	$creator = 'OWNE';

	foreach($_SESSION['_oProjList'] as $proj)
//	for ($ind=0; $ind<$size; $ind++)
	{
		if( $proj['role'] == $manager || 
			$proj['role'] == $creator ) 
		{
			if(!$hasSelect) $hasSelect = true;
			$display = "<option value='".$proj['p_id']. "'";

			if(isset($_POST['invite_proj']) && !empty($_POST['invite_proj']))
				$display.= ( ($_POST['invite_proj'] == $proj['p_id']) ? " selected='true'" : "");
			else 
				$display.= ( (isset($_SESSION['_project']) && $_SESSION['_project']->id == $proj['p_id']) ? " selected='true'" : "");

				$display.= ">".CommonUtil::truncate($proj['title'], 16)."</option>"; 
			echo $display;
		}
	}

	if($hasSelect) {
		echo '</select>';
	}
	else {
		echo '</select><label style="font-size:.8em;color:red;">'.$l_none_proj.'</label>';
	}
?></td>
	</tr>
<?php
	if( isset($_POST['invite_proj']) && !empty($_POST['invite_proj']) &&
		isset($_POST['form_hid_input']) && $_POST['form_hid_input']>=0 )
	{
		for($ind=0; $ind<$count; $ind++)
		{
			$output = '<tr id="invitation_'.$ind.'">
					   <td><label class="invite_disp_label'.($result[$ind]==5 ? ' highlight' : '').'">'.$l_user_email.'</label></td>
					   <td class="invite_table_input_td"><input type="text" class="invite_email_input textfield" id="user_email_'.$ind.'" name="user_email_'.$ind.'" value="'.$_POST['user_email_'.$ind].'" />
					   <span class="invitation_result_span">';

			switch ($result[$ind])
			{	
			case 0:
				$output .= '<img class="invitation_check_mark" src="../image/checkmark.png" /><label style="margin-left:5px;" class="invitation_result_info">'.$l_suc_0.'</label>';
				break;
			case 1:
				$output .= '<label class="invitation_result_error">'.$l_err_1.'</label>';
				break;
			case 2:
				$output .= '<label class="invitation_result_info">'.$l_err_2.'</label>';
				break;
			case 3:
				$output .= '<label id="invi_link_'.$ind.'" class="invitation_result_error">'.$l_err_3_1.'<a href="javascript:inviteFriend(\'invi_link_'.$ind.'\', \''.$_POST['user_email_'.$ind].'\', \''.$l_suc_0.'\')">'.$l_err_3_2.'</a></label>';
				break;
			case 4:
				$output .= '<label class="invitation_result_error">'.$l_err_4.'</label>';
				break;
			case 6:
				$output .= '<label class="invitation_result_info">'.$l_err_6.'</label>';
				break;
			}

			$output .= '</span></td></tr>';
			echo $output;
		}

		echo '</table>
			  <div id="more_user_div">
			  <input id="more_user_botton" type="button" onmousedown="mousePress(\'more_user_botton\')" onmouseup="mouseRelease(\'more_user_botton\')" onmouseout="mouseRelease(\'more_user_botton\')" onClick="javascript:addMoreUserInvitation(\'invitation\', '.$count.', \'form_hid_input\', \''.$l_more_btn.'\', \''.$l_user_email.'\')" value="'.$l_more_btn.'" />
			  </div>
			  <input id="form_hid_input" type="hidden" value="'.$count.'" name="form_hid_input" />';
	}
	else {?>
	<tr id="invitation_0"><td><label class="invite_disp_label"><?php echo $l_user_email ?></label></td>
	<td class="invite_table_input_td"><input type="text" class="invite_email_input textfield" id="user_email_0" name="user_email_0" /></td>
	</tr>
	</tbody>
	</table>
	<div id="more_user_div">
	<input id="more_user_botton" type="button" onmousedown="mousePress('more_user_botton')" onmouseup="mouseRelease('more_user_botton')" onmouseout="mouseRelease('more_user_botton')" onClick="javascript:addMoreUserInvitation('invitation', 1, 'form_hid_input', '<?php echo $l_more_btn?>', '<?php echo $l_user_email ?>')" value="<?php echo $l_more_btn?>" />
	</div>
	<input id="form_hid_input" type="hidden" value="1" name="form_hid_input" />
<?php }?>
	<div style="padding-top:10px;"><label class="invite_disp_label"><?php echo $l_message?>:</label><br/>
	<textarea name="description" style="border:1px solid #AAA;width:96%;height:100px;"></textarea>
	</div>
	<input type="submit" class="submitbn" value="<?php echo $l_submit?>"/>
	</form>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
</body>
</html>