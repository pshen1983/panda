<?php
include_once '../utils/DatabaseUtil.php';

session_start();
if( !isset($_SESSION['_userId']) || $_SESSION['_userId']!=1 )
{
    header( 'Location: ../default/index.php' ) ;
    exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Feedback</title>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<?php
$feedbacks = DatabaseUtil::getFeedbackList();
while($feedback = mysql_fetch_array($feedbacks, MYSQL_ASSOC))
{
echo '{<br />
	  Email => '.$feedback['from_email'].'<br />
	  Detail => '.$feedback['body'].'<br />
	  Date => '.$feedback['create_time'].'<br />
	  }<br /><br />';
}
?>
</body>
</html>