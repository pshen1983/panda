<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Self Note | ProjNote';
	$l_subject = 'Subject';
	$l_descrip = 'Description';
	$l_submit = 'Add Note';
	$l_in_prog = 'In Progress';
	$l_done = 'Done';
	$l_set_done = '(checkbox to set note done)';
	$l_set_prog = '(checkbox to set note in progress)';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#35760;&#20107;&#26412; | ProjNote';
	$l_subject = '&#20027;&#39064;';
	$l_descrip = '&#32454;&#33410;';
	$l_submit = '&#28155;&#21152;';
	$l_in_prog = '&#26410;&#23436;&#25104;';
	$l_done = '&#24050;&#23436;&#25104;';
	$l_set_done = '&#65288;&#28857;&#20987;&#22797;&#36873;&#26694;&#21464;&#20026;&#24050;&#23436;&#25104;&#65289;';
	$l_set_prog = '&#65288;&#28857;&#20987;&#22797;&#36873;&#26694;&#21464;&#20026;&#26410;&#23436;&#25104;&#65289;';
}

//=========================================================================================================

$active = DatabaseUtil::getUserActiveNotes($_SESSION['_userId']);
$done = DatabaseUtil::getUserDoneNotes($_SESSION['_userId']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
	<script type='text/javascript' src="../js/message.js"></script>
	<script type='text/javascript' src="../js/common.js"></script>
	<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
	<link rel='stylesheet' type='text/css' href='css/mess_layout.css' />
<?php include('../utils/analytics.inc.php');?></head>
    <body>
	<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div class="self_form_div">
	<form id="create_note" class='create_note' method="post" enctype="multipart/form-data" action="selfnote_process.inc.php" accept-charset="UTF-8">
	<label class="invite_disp_label"><?php echo $l_subject ?>:</label>
	<input id="subject" name="subject" class="subject_input" type="text" /><br>
	<label class="invite_disp_label"><?php echo $l_descrip?>:</label><br>
	<textarea id="description" name="description" class="description"></textarea>
	<div style="text-align:right;padding-right:2%;">
	<input id="search_submit_button" class="search_submit_button" onmousedown="mousePress('search_submit_button')" onmouseup="mouseRelease('search_submit_button')" onmouseout="mouseRelease('search_submit_button')" type="submit" value="<?php echo $l_submit?>" />
	</div>
	</form>
	</div>
	<div id="active_note" class="note_section">
	<label class="note_sec_title"><?php echo $l_in_prog?> <span style="font-size:.8em;font-weight:normal;font-style:italic"><?php echo $l_set_done?></span></label>
	<div id="acti_note_list" class="note_list_sec">
<?php 
	while($note = mysql_fetch_array($active, MYSQL_ASSOC))
	{
		echo '<input type="button" class="note_un_check" onClick="javascript:setNoteStatus('.$note['id'].')"/><label class="note_display" title="'.$note['description'].'">'.$note['title']."</label><br>";
	}
?></div></div>
	<div id="done_note" class="note_section">
	<a class="note_sec_title_link" href="javascript:showHideDoneNote('double_arrow_com')"><?php echo $l_done?><img id="double_arrow_com" style="padding-left:5px;border:0 none;" src="../image/common/double_arrow_down.png"></img></a><span style="font-size:.8em;font-weight:normal;font-style:italic;margin-left:5px;"><?php echo $l_set_prog?></span>
	<div id="done_note_list" class="note_list_sec"></div></div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
	</body>
</html>