<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/SearchDBUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Search Result | ProjNote';
	$l_user_label = 'User';
	$l_proj_label = 'My Project';
	$l_comp_label = 'Component';
	$l_wp_label = 'Workpackage';
	$l_wi_label = 'Workitem';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#25628;&#32034;&#32467;&#26524; | ProjNote';
	$l_user_label = '&#29992;&#25143;';
	$l_proj_label = '&#25105;&#30340;&#39033;&#30446;';
	$l_comp_label = '&#39033;&#30446;&#32452;';
	$l_wp_label = '&#24037;&#20316;&#21253;';
	$l_wi_label = '&#24037;&#20316;&#39033;';
}

//=========================================================================================================

if(isset($_POST['seach_input']))
{
	if(!isset($_SESSION['seach_input']) || $_SESSION['seach_input'] != $_POST['seach_input'])
	{
		$_SESSION['seach_input'] = $_POST['seach_input'];
	}
	else {
		
	}
}

if(!isset($_GET['page'])) $_GET['page']=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
	<script type='text/javascript' src="../js/search.js"></script>
	<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
	<link rel='stylesheet' type='text/css' href='css/search_layout.css' />
<?php include('../utils/analytics.inc.php');?></head>
    <body>
    <center>
<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div id="domain_link" class="domain_link">
	<ul class="domain_link_contain">
	<li class="link_elem_sep"></li>
	<li id="user_re" class="link_elem<?php if(isset($_GET['page']) && $_GET['page']==0) echo ' selected';?>"><a class="domain_link_elem" href="../search/header_result.php?page=0"><span class="domain_link_label"><?php echo $l_user_label?></span> <span class="link_num"><?php if(isset($_SESSION['seach_input'])) {
		$userCount = SearchDBUtil::searchUserCount($_SESSION['seach_input']);
		echo $userCount!=0 ? '(<span style="color:red">'.$userCount.'</span>)' : '(0)';
	}?></span></a></li>
	<li class="link_elem_sep"></li>
	<li id="proj_re" class="link_elem<?php if(isset($_GET['page']) && $_GET['page']==1) echo ' selected';?>"><a class="domain_link_elem" href="../search/header_result.php?page=1"><span class="domain_link_label"><?php echo $l_proj_label?></span> <span class="link_num"><?php if(isset($_SESSION['seach_input'])) {
		$projCount = SearchDBUtil::getProjListByTitleCount($_SESSION['seach_input'], $_SESSION['_userId']);
		echo $projCount!=0 ? '(<span style="color:red">'.$projCount.'</span>)' : '(0)';
	}?></span></a></li>
<?php if(isset($_SESSION['_project']) && !empty($_SESSION['_project'])) {?>
	<li class="link_elem_sep"></li>
	<li id="comp_re" class="link_elem<?php if(isset($_GET['page']) && $_GET['page']==2) echo ' selected';?>"><a class="domain_link_elem" href="../search/header_result.php?page=2"><span class="domain_link_label"><?php echo $l_comp_label?></span> <span class="link_num"><?php if(isset($_SESSION['seach_input'])) {
		$compCount = SearchDBUtil::getCompListByTitleCount($_SESSION['seach_input'], $_SESSION['_project']->id);
		echo $compCount!=0 ? '(<span style="color:red">'.$compCount.'</span>)' : '(0)';
	}?></span></a></li>
	<li class="link_elem_sep"></li>
	<!-- li id="wp_re" class="link_elem"><a class="domain_link_elem" href="../search/header_result.php?page=4"><span class="domain_link_label"><?php echo $l_wp_label?></span> <span class="link_num"><?php if(isset($_SESSION['seach_input'])) {
		$wpCount = SearchDBUtil::getWorkPackageListByTitleCount($_SESSION['seach_input'], $_SESSION['_project']->id);
		echo $wpCount!=0 ? '(<span style="color:red">'.$wpCount.'</span>)' : '(0)';
	}?></span></a></li -->
	<li class="link_elem_sep"></li>
	<li id="wi_re" class="link_elem<?php if(isset($_GET['page']) && $_GET['page']==3) echo ' selected';?>"><a class="domain_link_elem" href="../search/header_result.php?page=3"><span class="domain_link_label"><?php echo $l_wi_label?></span> <span class="link_num"><?php if(isset($_SESSION['seach_input'])) {
		$wiCount = SearchDBUtil::getWorkItemListByTitleCount($_SESSION['seach_input'], $_SESSION['_project']->id);
		echo $wiCount!=0 ? '(<span style="color:red">'.$wiCount.'</span>)' : '(0)';
	}?></span></a></li>
<?php }?>
	<li class="link_elem_sep"></li>
	</ul>
	</div>
	<div id="search_result">
<?php
switch ($_GET['page'])
{
	case 0:
		include_once 'user.inc.php';
		break;
	case 1:
		include_once 'project.inc.php';
		break;
	case 2:
		include_once 'component.inc.php';
		break;
	case 3:
		include_once 'workitem.inc.php';
		break;
}
?>
	</div>
	</div>
<?php include_once '../common/footer_1.inc.php';?>
    </center>
    </body>
</html>