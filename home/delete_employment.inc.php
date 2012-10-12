<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( isset($_GET['n']) && is_numeric($_GET['n']) )
{
	DatabaseUtil::deleteEmployment($_GET['n'], $_SESSION['_userId']);
	header( 'Location:../home/employment_history.php' );
	exit;
}
?>