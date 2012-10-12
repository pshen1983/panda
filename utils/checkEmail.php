<?php
include_once ("CommonUtil.php");
include_once ("DatabaseUtil.php");

session_start();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_message = 'Email already exist';
	$l_format = 'Invalid email format';
}
else if($_SESSION['_language'] == 'zh') {
	$l_message = '账户已注册';
	$l_format = '账户(Email)格式错误';
}

if(!isset($_GET['e']) || empty($_GET['e']))
{
	header( 'Location:../default/index.php' );
	exit;
}

$user = DatabaseUtil::emailExists(trim($_GET['e']));
if (isset($user))
{
	echo $l_message; // user exist
}
else if(!CommonUtil::validateEmailFormat(trim($_GET['e'])))
{
	echo $l_format;
}
else
{
	echo "0"; // user doesn't exist
}
?>