<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
CommonUtil::setSessionLanguage();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
	<script language="JavaScript" src="../js/calendar_us.js"></script>
	<script type='text/javascript' src="../js/ajax_calendar.js"></script>
	<link rel="stylesheet" type='text/css' href="../css/calendar.css" />
	<link rel='stylesheet' type='text/css' href='../css/ajax_calendar.css' />
<?php include('../utils/analytics.inc.php');?></head>
    <body onLoad='navigate("","")'>
	<center>
	<?php include_once '../common/header_1.inc.php';?>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
	</body>
</html>