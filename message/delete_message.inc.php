<?php
session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/DatabaseUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
	}
	else if($_SESSION['_language'] == 'zh') {
	}
	
	//=========================================================================================================
	
	$hasDelete = false;
	if( isset($_POST['delete_input']) && $_POST['delete_input']=='delete' )
	{
		$index = 1;
		while( isset($_POST['hide_'.$index]) && is_numeric($_POST['hide_'.$index]) )
		{
			if( isset($_POST['check_'.$index]) && $_POST['check_'.$index]=='on')
			{
				DatabaseUtil::deleteMessage($_POST['hide_'.$index]);
				if(!$hasDelete) $hasDelete = true;
			}
			$index++;
		}
	}
	
	if( $hasDelete ) {
		unset( $_SESSION['_messMessage'] );
	}
	else {
		$_SESSION['_messMessage'] = 1;
	}
	
	header( 'Location: ../message/index.php' ) ;
	exit;
}
else {
	echo 1;
}
?>