<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/mzk.php");
	include_once ("../utils/MessageUtil.php");
	include_once ("../utils/CommonUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");
	
	if( isset($_POST['msn_acct']) && !empty($_POST['msn_acct']) &&
		isset($_POST['msn_pass']) && !empty($_POST['msn_pass']) )
	{
		$_SESSION['_msnAccount'] = $_POST['msn_acct'];
	
		if(CommonUtil::validateEmailFormat($_POST['msn_acct']))
		{
			$t = new MezzengerKlient;
		
			$t->init( $_POST['msn_acct'], $_POST['msn_pass'], "NLN" );
			$t->login();
			$t->load_login();
			$t->quit();

			if( isset($t->mycontacts) )
			{
				foreach( $t->mycontacts as $userEmail ) {
					if( !DatabaseUtil::emailExists($userEmail) )
						MessageUtil::sendInvitation($_POST['msn_acct'], $userEmail);
				}
		
				$_SESSION['_msnResult'] = 0;
			}
			else {
				$_SESSION['_msnResult'] = 1;
			}
		}
		else {
			$_SESSION['_msnResult'] = 2;
		}
	}
	else {
		unset( $_SESSION['_msnResult'] );
	}
	
	header( 'Location: ../message/invite_friend.php' ) ;
	exit;
}
else {
	echo 1;
}
?>