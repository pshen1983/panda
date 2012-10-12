<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_mess_header = 'A Team Invitation has been send to you ';
		$l_mess_want = 'Do you want to';
		$l_mess_acce = 'Accept';
		$l_mess_or = ' or ';
		$l_mess_reje = 'Reject';
		$l_mess_ques = ' this Team Invitation?';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_mess_header = '&#24744;&#26377;&#19968;&#20010;&#39033;&#30446;&#36992;&#35831;';
		$l_mess_want = '&#24744;&#24819;&#35201; ';
		$l_mess_acce = '&#25509;&#21463;';
		$l_mess_or = ' &#36824;&#26159; ';
		$l_mess_reje = '&#25298;&#32477;';
		$l_mess_ques = ' &#36825;&#20010;&#36992;&#35831;&#65311;';
	}
	
	//=========================================================================================================
	
	if( isset($_GET['iid']) && !empty($_GET['iid']) && 
		isset($_GET['sid']) && !empty($_GET['sid']) && 
		isset($_GET['pid']) && !empty($_GET['pid']) ) {
		$message = DatabaseUtil::getInvitationBody($_GET['iid'], $_GET['sid']);
		echo '<div class="invitation_body_message">
			  <label class="invitation_body_label">'.$l_mess_header.':<ul>'.$message.'</ul></label>
			  <div class="invitation_body_links">
			  <label class="">'.$l_mess_want.
			  '<a href="invitation_process.php?iid='.$_GET['iid'].'&sid='.$_GET['sid'].'&pid='.$_GET['pid'].'">'.$l_mess_acce.'</a> '.$l_mess_or.
			  '<a href="invitation_process.php?iid='.$_GET['iid'].'&sid='.$_GET['sid'].'">'.$l_mess_reje.'</a>'.$l_mess_ques.'</label>
			  </div>
			  </div>';
	}
}
else {
	echo 1;
}
?>