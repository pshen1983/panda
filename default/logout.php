<?php
include_once ("../utils/configuration.inc.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::unsetCookie();

$language = $_SESSION['_language'];
session_unset();
$_SESSION['_language'] = $language;

header( 'Location: '.$HTTP_BASE.'/default/index.php' ) ;
?>