<?php
include_once ('../utils/DatabaseUtil.php');
include_once ('../utils/MessageUtil.php');

if( isset($_POST['wid']) && is_numeric($_POST['wid']) && isset($_POST['sid']) && is_numeric($_POST['sid']) ) {
	session_start();
	if( isset($_SESSION['_userId']) ) {
		$wi = DatabaseUtil::getWorkItemSid($_POST['wid'], $_POST['sid']);
		if( isset($wi) && $wi ) {
			if( $wi['owner_id']==$_SESSION['_userId'] ) {
				if( DatabaseUtil::updateWorkItemStatus($_POST['wid'], 'DONE') ) {
					if( $_SESSION['_userId']!=$wi['creator_id'] )
						MessageUtil::sendWorkitemStatusChangeMessage( $_POST['wid'], $wi['status'] );
					echo 0;
				}
				else echo 5;
			}
			else echo 4;
		}
		else echo 3;
	}
	else echo 2;
}
else echo 1;
?>