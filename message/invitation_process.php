<?php
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_invi_pro_acce_summary = 'Project Invitation Accepted';
	$l_invi_pro_acce_body = ' has <strong>ACCEPTED</strong> your project inviation to ';
	$l_invi_pro_reje_summary = 'Project Invitation Rejected';
	$l_invi_pro_reje_body = ' has <strong>REJECTED</strong> your project inviation to ';
}
else if($_SESSION['_language'] == 'zh') {
	$l_invi_pro_acce_summary = '&#29992;&#25143;&#25509;&#21463;&#20102;&#24744;&#30340;&#39033;&#30446;&#36992;&#35831;';
	$l_invi_pro_acce_body = '<strong>&#25509;&#21463;</strong>&#20102;&#24744;&#30340;&#36992;&#35831;&#26469;&#21442;&#21152;&#39033;&#30446;: ';
	$l_invi_pro_reje_summary = '&#29992;&#25143;&#25298;&#32477;&#20102;&#24744;&#30340;&#39033;&#30446;&#36992;&#35831;';
	$l_invi_pro_reje_body = '<strong>&#25298;&#32477;</strong>&#20102;&#24744;&#30340;&#36992;&#35831;&#21040;&#39033;&#30446;: ';
}

//=========================================================================================================

if( isset($_GET['iid']) && !empty($_GET['iid']) && 
	isset($_GET['sid']) && !empty($_GET['sid']) && 
	isset($_GET['pid']) && !empty($_GET['pid']) )
{
	$invitation = DatabaseUtil::getInvitation($_GET['iid'], $_GET['sid']);
	if($invitation['to_email']==$_SESSION['_loginUser']->login_email && $invitation['p_id']==$_GET['pid'])
	{
		if(DatabaseUtil::insertRelation($_SESSION['_userId'], $_GET['pid']))
		{
			$user = $_SESSION['_loginUser'];
			$name = ($_SESSION['_language'] == 'zh') ? $user->lastname.$user->firstname : $user->firstname." ".$user->lastname;
			DatabaseUtil::deleteInvitation($_GET['iid'], $_GET['sid']);
			$proj = DatabaseUtil::getProj($_GET['pid']);
			$title = $proj['title'];
			unset($_SESSION['_oProjList']);
			DatabaseUtil::insertMessage( $l_invi_pro_acce_summary, 
										 $invitation['from_id'], 
										 $user->id, 
										 $name.$l_invi_pro_acce_body.$title);
			header( 'Location: ../project/index.php?p_id='.$_GET['pid'].'&sid='.$proj['s_id'] ) ;
			exit;
		}
	}
}
else if(isset($_GET['iid']) && !empty($_GET['iid']) && isset($_GET['sid']) && !empty($_GET['sid']) )
{
	$invitation = DatabaseUtil::getInvitation($_GET['iid'], $_GET['sid']);
	if($invitation['to_email']==$_SESSION['_loginUser']->login_email)
	{
		$user = $_SESSION['_loginUser'];
		$name = ($_SESSION['_language'] == 'zh') ? $user->lastname.$user->firstname : $user->firstname." ".$user->lastname;
		DatabaseUtil::deleteInvitation($_GET['iid'], $_GET['sid']);
		$proj = DatabaseUtil::getProj($invitation['p_id']);
		$title = $proj['title'];
		DatabaseUtil::insertMessage( $l_invi_pro_acce_summary, 
									 $invitation['from_id'], 
									 $user->id, 
									 $name.$l_invi_pro_reje_body.$title);
		header( 'Location: ../message/invitation.php' ) ;
		exit;
	}
}
else {
	header( 'Location: ../message/invitation.php' ) ;
	exit;
}
?>