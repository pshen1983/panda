<?php
include_once ("SecurityUtil.php");
include_once ("DatabaseUtil.php");
include_once ("CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( !isset($_GET['s_id']) )
{
    header( 'Location: ../home/index.php' ) ;
    exit;
}

if( !SecurityUtil::isProjectMember($_SESSION['_userId'], $_GET['s_id']/3-7) )
{
	header( 'Location: ../default/error.php?m=You need to be a member of the project in order to downlaod the project files.' ) ;
    exit;
}

set_time_limit(0);

if (!(isset($_GET['f']) && !empty($_GET['f']) && isset($_GET['id']) && !empty($_GET['id'])))
{
	die("Please specify file name for download.");
}

$doc = DatabaseUtil::getDoc($_GET['id'], $_GET['f']);

$mtype = "application/force-download";

$asfname = CommonUtil::ncr_decode($doc['title']);

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: $mtype");
header("Content-Disposition: attachment; filename=\"$asfname\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $doc['size']);

echo $doc['content'];
?>