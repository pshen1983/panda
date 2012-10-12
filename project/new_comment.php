<?php
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/MessageUtil.php");

if(!isset($_SESSION)) session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( isset($_POST['content']) && !empty($_POST['content']) && 
	isset($_POST['comment_type']) && !empty($_POST['comment_type']) && 
	isset($_POST['work_sid']) && !empty($_POST['work_sid']) && 
	isset($_POST['work_id']) && is_numeric($_POST['work_id']) )
{
	if( $_POST['comment_type']=='wi' ) {
		$content = str_replace("<", "&lt", $_POST['content']);
		$content = str_replace(">", "&gt", $content);
		$content = "<pre style='font-family:tahoma;'>".$content."</pre>";
		DatabaseUtil::insertWorkItemComment($_SESSION['_userId'], $_POST['work_id'], $content);
		MessageUtil::sendWorkitemCommentMessage($_POST['work_id']);
		header( 'Location: ../project/work_item.php?wi_id='.$_POST['work_id'].'&sid='.$_POST['work_sid'] );
	}
	else if( $_POST['comment_type']=='wp' ) {
		$content = str_replace("<", "&lt", $_POST['content']);
		$content = str_replace(">", "&gt", $content);
		$content = "<pre style='font-family:tahoma;'>".$content."</pre>";
		DatabaseUtil::insertWorkPackageComment($_SESSION['_userId'], $_POST['work_id'], $content);
		header( 'Location: ../project/work_package.php?wp_id='.$_POST['work_id'].'&sid='.$_POST['work_sid'] );
	}
	else
		header( 'Location: ../default/index.php' );
}
else
	header( 'Location: ../default/index.php' );
?>