<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Messages | ProjNote';
	$l_messages = 'Messages';
	$l_from = 'From';
	$l_subj = 'Subject';
	$l_date = 'Date';
	
	$l_to = 'To <span style="font-size:.8em;font-weight:normal;">(Email)</span>';
	$l_subject = 'Subject';
	$l_message_body = 'Message';
	$l_send = 'New';
	$l_delete = 'Delete';
	$l_submit = 'Send';
	$l_cancel = 'Close';
	$l_delete_confirm = 'Do you want to delete all selected messages?';
	$l_delete_message = 'x No message selected. Please select at least one message and try again.';
	$l_send_message = '- Message has been send successfully.';
	
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#31449;&#20869;&#30701;&#20449; | ProjNote';
	$l_messages = '&#31449;&#20869;&#30701;&#20449;';
	$l_from = '&#21457;&#20449;&#29992;&#25143;';
	$l_subj = '&#25552;&#35201;';
	$l_date = '&#21457;&#36865;&#26085;&#26399;';
	
	$l_to = '&#29992;&#25143;<span style="font-size:.8em;font-weight:normal;">(Email)</span>';
	$l_subject = '&#25552;&#35201;';
	$l_message_body = '&#30701;&#20449;&#20869;&#23481;';
	$l_send = '&#21457;&#36865;&#30701;&#20449;';
	$l_delete = '&#21024;&#38500;&#30701;&#20449;';
	$l_submit = '&#21457;&#36865;';
	$l_cancel = '&#20851;&#38381;';
	$l_delete_confirm = '确定删除所有被选择的信息？';
	$l_delete_message = 'x &#35831;&#36873;&#25321;&#33267;&#23569;&#19968;&#26465;&#35201;&#21024;&#38500;&#30340;&#30701;&#20449;&#21518;&#37325;&#35797;&#12290;';
	$l_send_message = '&#8212; &#20449;&#24687;&#25104;&#21151;&#21457;&#36865;&#12290;';	
}

//=========================================================================================================

$table = array();
$index = 0;
$table[$index] = array( '<span class="invitation_title_span">'.$l_from.':</span>', 
						'<span class="invitation_title_span">'.$l_subj.':</span>', 
						'<span class="invitation_title_span">'.$l_date.':</span>', 
						null,
						true,
						'' );

$messages = DatabaseUtil::getMessages($_SESSION['_userId']);

while( $row = mysql_fetch_array($messages, MYSQL_ASSOC) )
{
	$index = $index + 1;

	$user = DatabaseUtil::getUser($row['from_id']);

	$name = "<a class='user_link' href='../search/user_details.php?p1=".session_id()."&p2=".($row['from_id']*3-1)."'>".(($_SESSION['_language'] == 'zh') ? $user['lastname'].$user['firstname'] : CommonUtil::truncate($user['firstname']." ".$user['lastname'], 16))."</a>";
	$from = '<label class="invitation_body_label">'.$name.'</label>';
	$subj = '<a class="table_row_link" href="javascript:displayMessage(\'message_'.$index.'\', \''.$row['id'].'\', \''.$_SESSION['_userId'].'\', \'mess_label_'.$index.'\')">'.$row['title'].'</a>';
	$date = '<label class="invitation_body_label_date">'.$row['create_time'].'</label>';
	$chek = '<input style="border:0 none;" type="checkbox" name="check_'.$index.'" id="check_'.$index.'" />';

	$table[$index] = array($from, $subj, $date, $row['id'], $row['is_read']=='Y', $chek);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<script type='text/javascript' src="../js/message.js"></script>
<script type='text/javascript'>
function confirmDelete() {
	var r=confirm("<?php echo $l_delete_confirm?>");
	if( r==true ) {
		document.message_form.submit();
	}
}
</script>
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/mess_layout.css' />
<?php include('../utils/analytics.inc.php');?></head>
<body onLoad="javascript:setMessageBoxPosition()">
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div class="send_invite_div">
</div>
<div class="invitation_table">
<div class="invitation_list_label"><?php echo $l_messages?></div>
<?php if( isset($_SESSION['_messMessage']) ) { ?>
<div style="text-align:left;display:block">
<label style="font-size:.8em;color:<?php echo $_SESSION['_messMessage']==0  ? 'green' : 'red'?>"> <?php 
if( $_SESSION['_messMessage']==0 ) {
	echo $l_send_message;
}
else {
	echo $l_delete_message;
}
unset( $_SESSION['_messMessage'] );?></label>
</div>
<?php }?>
<form method="post" enctype="multipart/form-data" action="delete_message.inc.php" name="message_form" id="message_form" accept-charset="UTF-8">
<div style="text-align:left;margin-bottom:2px;padding-left:5px;background-color:#3567A8;">
<input id="invi_frd" class="mess_link" type="button" onmousedown="mousePress('invi_frd')" onmouseup="mouseRelease('invi_frd')" onmouseout="mouseRelease('invi_frd')" onClick="javascript:showMessageBox()" value="<?php echo $l_send?>" />
<input type="hidden" name="delete_input" value="delete" />
<input id="mess_del" class="mess_link" type="button" onmousedown="mousePress('mess_del')" onmouseup="mouseRelease('mess_del')" onmouseout="mouseRelease('mess_del')" onClick="confirmDelete()"value="<?php echo $l_delete?>" />
</div><?php
	$output = '';
	foreach($table as $key=>$elem)
		$output .= '<div><table class="message_table_row" '.($key%2==0 ? '' : 'style="background-color:#E5EDF2"').'><tr>
					<td class="check">'.$elem[5].'</td>
					<td class="from"><label class="invitation_body_label">'.$elem[0].'</label></td>
					<td class="subject"><label id="mess_label_'.$key.'" class="'.($elem[4] ? 'invitation_body_label' : 'unread_message_body_label').'">'.$elem[1].'</label></td>
					<td class="date"><label class="invitation_body_label">'.$elem[2].'</label></td>
					</tr></table></div>'.
					(isset($elem[3])? '<div id="message_'.$key.'" class="invitation_body"></div>' : '').
					(isset($elem[3])? '<input type="hidden" name="hide_'.$key.'" value="'.$elem[3].'" />' : '');
	echo $output;
?></form>
</div>
<div id="send_box" style="<?php echo isset($_SESSION['_sendMessageResultCode'])&&$_SESSION['_sendMessageResultCode']!=0 ? 'display:block;visibility:visible;' : 'display:none;visibility:hidden;';?>">
<div id="screen" class="screen"></div>
<div id="send_mess_div">
<form class="mess_send_form" method="post" enctype="multipart/form-data" action="send_message.inc.php" name="send_message" id="send_message" accept-charset="UTF-8">
<div class="send_mess_result"><label style="color:<?php 
echo (isset($_SESSION['_sendMessageResultCode']) && $_SESSION['_sendMessageResultCode']==0) ? 'green' : 'red';
?>"><?php 
if (isset($_SESSION['_sendMessageResultMess'])) echo $_SESSION['_sendMessageResultMess'];?></label></div>
<table>
<tr>
<td><label class="invite_disp_label" <?php echo (isset($_SESSION['_sendMessageResultCode']) && $_SESSION['_sendMessageResultCode']==4) ? 'style="color:red"' : '' ?>><?php echo $l_to ?>:</label></td>
<td><input id="subject" name="to" class="mess_input_send" type="text" value="<?php if (isset($_SESSION['_sendMessageResultEmail'])) echo $_SESSION['_sendMessageResultEmail'];?>"/></td>
</tr>
<tr>
<td><label class="invite_disp_label"><?php echo $l_subject ?>:</label></td>
<td><input id="subject" name="subject" class="mess_input_send" type="text" /></td>
</tr>
<tr>
<td><label class="invite_disp_label"><?php echo $l_message_body?>:</label></td>
<td><textarea id="mess_body" name="mess_body" class="mess_send"></textarea></td>
</tr><?php
if(isset($_SESSION['_sendMessageResultCode'])) unset($_SESSION['_sendMessageResultCode']);
if(isset($_SESSION['_sendMessageResultMess'])) unset($_SESSION['_sendMessageResultMess']);
if(isset($_SESSION['_sendMessageResultEmail'])) unset($_SESSION['_sendMessageResultEmail']);
?></table>
<div style="">
<input style="margin-right:100px;" id="send_button" class="button_input" onmousedown="mousePress('send_button')" onmouseup="mouseRelease('send_button')" onmouseout="mouseRelease('send_button')" type="submit" value="<?php echo $l_submit?>" />
<input id="cancel_button" class="button_input" onmousedown="mousePress('cancel_button')" onmouseup="mouseRelease('cancel_button')" onmouseout="mouseRelease('cancel_button')" type="button" onClick="javascript:hideMessageBox()" value="<?php echo $l_cancel?>" />
</div>
</form>
</div>
</div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>