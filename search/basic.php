<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SessionUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = array();
	$l_title['last_modified_by_me'] = 'Quick Search | Last Modified by Me';
	$l_title['my_open_workitem'] = 'Quick Search | My Open Workitems';
	$l_title['my_subscriptions'] = 'Quick Search | My Subscriptions';
	$l_title['work_closed_by_me'] = 'Quick Search | Work Closed by Me';
	$l_title['work_created_by_me'] = 'Quick Search | Work Created by Me';
	$l_title['work_owned_by_me'] = 'Quick Search | Work Owned by Me';
	$l_title['all'] = 'Quick Search Result';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = array();
	$l_title['last_modified_by_me'] = '我最后修改 | ProjNote';
	$l_title['my_open_workitem'] = '&#24555;&#36895;&#25628;&#32034; | &#24744;&#26410;&#23436;&#25104;&#30340;&#24037;&#20316;&#39033;';
	$l_title['my_subscriptions'] = '我的关注 | ProjNote';
	$l_title['work_closed_by_me'] = '我完成的工作 | ProjNote';
	$l_title['work_created_by_me'] = '我创建的工作 | ProjNote';
	$l_title['work_owned_by_me'] = '我全部的工作 | ProjNote';
	$l_title['all'] = '&#24555;&#36895;&#25628;&#32034;&#32467;&#26524;';
}

//=========================================================================================================
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo (isset($_GET['s']) && isset($l_title[$_GET['s']])) ? $l_title[$_GET['s']] : $l_title['all']?></title>
<link rel='stylesheet' type='text/css' href='css/search_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<script type='text/javascript' src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
    <center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>	<div id="search_result" style="#margin-top:25px;">
	<?php if(isset($_GET['s']) && file_exists('b_'.$_GET['s'].'.inc.php')) { include_once 'b_'.$_GET['s'].'.inc.php'; }?>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
	</center>
</body>
</html>