<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Invitations | ProjNote';
	$l_invitation = 'Invitations';
	$l_from = 'From';
	$l_subj = 'Subject';
	$l_date = 'Date';
	$l_invi_frd = 'Invite a friend to ProjNote';
	$l_invi_pro = 'Invite a friend to your project';
	$l_invi_to_proj = 'Invitation to Project - ';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#39033;&#30446;&#36992;&#35831; | ProjNote';
	$l_invitation = '&#39033;&#30446;&#36992;&#35831;';
	$l_from = '&#21457;&#36865;&#29992;&#25143;';
	$l_subj = '&#25552;&#35201;';
	$l_date = '&#21457;&#36865;&#26085;&#26399;';
	$l_invi_frd = '&#36992;&#35831;&#26379;&#21451;&#21152;&#20837; ProjNote';
	$l_invi_pro = '&#36992;&#35831;&#26379;&#21451;&#21152;&#20837;&#24744;&#30340;&#39033;&#30446;';
	$l_invi_to_proj = '&#39033;&#30446;&#36992;&#35831; &#8212; ';
}

//=========================================================================================================

$table = array();
$index = 0;
$table[$index] = array( '<span class="invitation_title_span">'.$l_from.':</span>', 
						'<span class="invitation_title_span">'.$l_subj.':</span>', 
						'<span class="invitation_title_span">'.$l_date.':</span>', 
						null );

$invitations = DatabaseUtil::getUserInvitations($_SESSION['_loginUser']->login_email);

while( $row = mysql_fetch_array($invitations, MYSQL_ASSOC) )
{
	$index = $index + 1;

	$user = DatabaseUtil::getUser($row['from_id']);
	$proj = DatabaseUtil::getProj($row['p_id']);

	$name = "<a class='user_link' href='../search/user_details.php?p1=".session_id()."&p2=".($row['from_id']*3-1)."'>".(($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : CommonUtil::truncate($user['firstname']." ".$user['lastname'], 16))."</a>";
	$from = '<label class="invitation_body_label">'.$name.'</label>';
	$subj = '<a id="link_'.$index.'" class="table_row_link" style="font-weight:bold;" href="javascript:displayInvitation(\'invitation_'.$row['id'].'\', \''.$row['id'].'\', \''.$row['s_id'].'\', \''.$row['p_id'].'\', \'link_'.$index.'\')">'.$l_invi_to_proj.CommonUtil::truncate($proj['title'], 67).'</a>';
	$date = '<label class="invitation_body_label_date">'.$row['create_time'].'</label>';

	$table[$index] = array($from, $subj, $date, $row['id']);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
	<script type='text/javascript' src="../js/message.js"></script>
	<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
	<link rel='stylesheet' type='text/css' href='css/mess_layout.css' />
<?php include('../utils/analytics.inc.php');?></head>
<body>
	<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div>
	<div class="invitation_table">
	<div class="invitation_list_label"><?php echo $l_invitation?></div>
	<div class="send_invite_div">
	<div style="text-align:left;margin-bottom:2px;padding-left:5px;background-color:#3567A8;"><input id="invi_pro" class="invi_link" type="button" onmousedown="mousePress('invi_pro')" onmouseup="mouseRelease('invi_pro')" onmouseout="mouseRelease('invi_pro')" onClick="window.location='invite_project.php'" value="<?php echo $l_invi_pro?>" /></div>
	</div>
		<?php
		$output = '';
		foreach($table as $key=>$elem)
			$output .= '<div><table class="message_table_row"'.($key%2==0 ? '' : 'style="background-color:#E5EDF2"').'><tr>
						<td class="from"><label class="invitation_body_label">'.$elem[0].'</label></td>
						<td class="subject"><label class="invitation_body_label">'.$elem[1].'</label></td>
						<td class="date"><label class="invitation_body_label">'.$elem[2].'</label></td>
						</tr></table></div>'.
						(isset($elem[3])?'<div id="invitation_'.$elem[3].'" class="invitation_body"></div>':'');

		echo $output;
	?>
	</div>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
</body>
</html>