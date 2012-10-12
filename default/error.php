<?php
include_once ("../common/Objects.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
	<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<?php include('../utils/analytics.inc.php');?></head>
    <body>
	<center>
	<?php include_once '../common/header_1.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';
		if (isset($_GET['m']))
		{
			echo '<label class="general_error_message"><span class="general_error_span">'.$_GET['m'].'</span></label>';
		}
	?>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
	</body>
</html>