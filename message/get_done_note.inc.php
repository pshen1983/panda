<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	
	$output = '';
	
	$done = DatabaseUtil::getUserDoneNotes($_SESSION['_userId']);
	
	while($note = mysql_fetch_array($done, MYSQL_ASSOC))
	{
		$output.= '<input type="button" class="note_check" onClick="javascript:setNoteStatus('.$note['id'].')"/><label class="note_display" title="'.$note['description'].'">'.$note['title']."</label><br>";
	}
	
	echo $output;
}
else {
	echo 1;
}
?>