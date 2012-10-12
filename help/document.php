<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Document Help | ProjNote';

	$l_page_title = 'Document Help';
	$l_back_link = 'Back to Help Center';

	$l_all = array();

	$l_q_1 = 'What documentation functionalities does ProjNote provide?';
	$l_a_1 = 'ProjNote offers the user document <span style="color:red">uploading</span>, <span style="color:red">downloading</span> and <span style="color:red">sharing</span> functions, you could upload documents to a Project, a Project Component or a Workitem to be shared with different project members. 
			  Also, ProjNote offers document <span style="color:red">searching</span> function, after login, you could search a document through searching its name, uploading user, uploading time and etc from <a href="../search/document.php">Document Search</a> link.';
//			  Moreover, ProjNote offers <a href="../search/document.php">Document Broswer</a> function, which allows user to browse shared docuemnts in all project levels in a tree structure.';
	$l_all[$l_q_1] = $l_a_1;

//	$l_q_2 = 'How to use ProjNote document broswer?';
//	$l_a_2 = 'The Document Broswer function offered by ProjNote allows you quickly browse through all your Projects, Project Components, Workpackages and Workitems in a tree liked pattern for documents. Click on a Project, Project Component, Workpackage or Workitem, you will see all documents shared in that place; click on a document, you will download it to your local file system.';
//	$l_all[$l_q_2] = $l_a_2;
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#25991;&#26723;&#24110;&#21161; | ProjNote';

	$l_page_title = '&#25991;&#26723;&#24110;&#21161;';
	$l_back_link = '&#36820;&#22238;&#24110;&#21161;&#20013;&#24515;';

	$l_all = array();

	$l_q_1 = 'ProjNote &#25552;&#20379;&#21738;&#20123;&#25991;&#26723;&#21151;&#33021;&#65311;';
	$l_a_1 = 'ProjNote &#25552;&#20379;&#25991;&#20214;<span style="color:red">&#19978;&#20256;&#20849;&#20139;</span>&#21151;&#33021;&#65292;&#24744;&#21487;&#20197;&#19978;&#20256;&#25991;&#20214;&#21040;&#19968;&#20010;&#39033;&#30446;&#65292;&#19968;&#20010;&#39033;&#30446;&#32452;&#25110;&#19968;&#20010;&#24037;&#20316;&#39033;&#21644;&#19981;&#21516;&#30340;&#39033;&#30446;&#25104;&#21592;&#20849;&#20139;&#12290;ProjNote &#25552;&#20379;&#25991;&#20214;<a href="../search/document.php">&#25628;&#32034;</a>&#21151;&#33021;&#65292;&#22312;&#36873;&#25321;&#19968;&#20010;&#39033;&#30446;&#21518;&#65292;&#24744;&#21487;&#20197;&#36890;&#36807;&#25991;&#20214;&#21517;&#25628;&#32034;&#25991;&#20214;&#12290;';
	$l_all[$l_q_1] = $l_a_1;

//	$l_q_2 = '&#22914;&#20309;&#20351;&#29992;&#25991;&#26723;&#27983;&#35272;&#22120;&#65311;';
//	$l_a_2 = 'ProjNote &#30340;&#25991;&#26723;&#27983;&#35272;&#22120;&#35753;&#24744;&#36731;&#26494;&#19968;&#35272;&#24744;&#25152;&#26377;&#30340;&#39033;&#30446;&#65292;&#39033;&#30446;&#32452;&#65292;&#24037;&#20316;&#21253;&#21644;&#24037;&#20316;&#39033;&#30340;&#26641;&#35270;&#22270;&#26174;&#31034;&#12290;&#28857;&#20987;&#19968;&#20010;&#39033;&#30446;&#65292;&#39033;&#30446;&#32452;&#65292;&#24037;&#20316;&#21253;&#25110;&#24037;&#20316;&#39033;&#65292;&#24744;&#23558;&#19968;&#35272;&#39033;&#30446;&#22242;&#38431;&#19978;&#20256;&#20849;&#20139;&#30340;&#25991;&#26723;&#22312;&#24744;&#25152;&#36873;&#30340;&#39033;&#30446;&#65292;&#39033;&#30446;&#32452;&#65292;&#24037;&#20316;&#21253;&#25110;&#24037;&#20316;&#39033;&#20013;&#12290;';
//	$l_all[$l_q_2] = $l_a_2;
}

//=========================================================================================================
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/help_layout.css' />
<script type='text/javascript' src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once (isset($_SESSION['_userId'])) ? '../common/header_2.inc.php' : '../common/header_1.inc.php';?>
	<div id="page_body">
	<?php if(isset($_SESSION['_userId'])) {
		include_once '../common/path_nav.inc.php';
	?>
	<div id="top_link_saperator"></div>
	<?php }?>
	<div class="help_back_link"><label style="color:blue">&laquo; <a class="back_help" href="../help/index.php"> <?php echo $l_back_link?></a></label></div>
	<div class="help_body">
	<div class="help_head">
	<a name="top"><label class="help_header"><?php echo $l_page_title?></label></a>
	</div>
	<div class="page_saperator"></div>
<?php $count = 1;
foreach ($l_all as $q=>$a) {?>
	<div class="help_detail">
	<a class="back_top" href="#top">Top &uarr;</a>
	<a name="q<?php echo $count?>"><label class="help_header" style="font-size:.8em;"><?php echo $q?></label></a>
	<p><?php echo $a?></p>
	</div>
<?php $count++; } ?>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
