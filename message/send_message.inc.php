<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/CommonUtil.php");
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_no_subj = 'No subject';
	
		$l_err_1 = 'x System is temporarily busy, please try again later.';
		$l_err_2 = 'x User you are sending message to does NOT exist. <a href="../message/invite_friend.php">Invite</a> this friend.';
		$l_err_3 = 'x Invalid User Email format.';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_no_subj = '&#65288;&#31354;&#65289;';
	
		$l_err_1 = 'x &#31995;&#32479;&#26242;&#26102;&#24537;&#65292;&#35831;&#31245;&#21518;&#20877;&#35797;&#12290;';
		$l_err_2 = 'x &#25910;&#20449;&#20154;&#19981;&#26159;&#27880;&#20876;&#29992;&#25143;&#65292;<a href="../message/invite_friend.php">&#36992;&#35831;</a>&#24744;&#30340;&#26379;&#21451;&#21152;&#20837;&#12290;';
		$l_err_3 = 'x &#29992;&#25143;&#65288;Email&#65289;&#26684;&#24335;&#26377;&#35823;&#12290;';
	}
	
	//=========================================================================================================
	
	if( isset($_POST['to']) && !empty($_POST['to']) )
	{
		$email = trim($_POST['to']);
	
		if(CommonUtil::validateEmailFormat($email))
		{
			if( DatabaseUtil::emailExists($email) )
			{
				$subject = ( isset($_POST['subject']) && !empty($_POST['subject']) ) ? trim($_POST['subject']) : $l_no_subj;
				$message = ( isset($_POST['mess_body']) ) ? $_POST['mess_body'] : "";
				$user = DatabaseUtil::getUserByEmail($email);
	
				if( DatabaseUtil::insertMessage($subject, $user['id'], $_SESSION['_userId'], $message) )
				{
					$_SESSION['_sendMessageResultCode'] = 0; //code used to hide the send message div.
					$_SESSION['_messMessage'] = 0; //code used to display success message on top of the table.
				}
				else {
					$_SESSION['_sendMessageResultCode'] = 1;
					$_SESSION['_sendMessageResultMess'] = $l_err_1;
					$_SESSION['_sendMessageResultEmail'] = $email;
				}
			}
			else {
				$_SESSION['_sendMessageResultCode'] = 2;
				$_SESSION['_sendMessageResultMess'] = $l_err_2;
				$_SESSION['_sendMessageResultEmail'] = $email;
			}
		}
		else {
			$_SESSION['_sendMessageResultCode'] = 3;
			$_SESSION['_sendMessageResultMess'] = $l_err_3;
			$_SESSION['_sendMessageResultEmail'] = $email;
		}
	}
	else {
		$_SESSION['_sendMessageResultCode'] = 4;
	}

	if(isset($_POST['page']) && !empty($_POST['page']))
	{
		header( 'Location: '.$_POST['page'] ) ;	
	}
	else {
		header( 'Location: ../message/index.php' ) ;	
	}
	exit;
}
else {
	echo 1;
}
?>