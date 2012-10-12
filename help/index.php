<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Help Center | ProjNote';

	$l_page_title = 'Help Center';

	$l_all = array();

	$l_basic_t = 'Basic Help';
	$l_basic = array();
	$l_basic[0] = 'basic.php';
	$l_basic[1] = 'What is ProjNote?';
	$l_basic[2] = 'How does ProjNote assist you to manage your project and work?';
	$l_basic[3] = 'How to use ProjNote to manage your project and work?';
	$l_all[$l_basic_t] = $l_basic;

	$l_account_t = 'Account Help';
	$l_account = array();
	$l_account[0] = 'account.php';
	$l_account[1] = 'How to register?';
	$l_account[2] = 'What does ProjNote personal information contain?';
	$l_account[3] = 'How to invite friends to join ProjNote?';
	$l_all[$l_account_t] = $l_account;

	$l_status_t = 'Project Management and Statistic Help';
	$l_status = array();
	$l_status[0] = 'stat.php';
	$l_status[1] = 'How to send and accept project invitations?';
	$l_status[2] = 'How to change the role of or delete a project member?';
	$l_status[3] = 'What project statistics does myProject provide?';
	$l_all[$l_status_t] = $l_status;

	$l_doc_t = 'Document Help';
	$l_doc = array();
	$l_doc[0] = 'document.php';
	$l_doc[1] = 'What documentation functionalities does ProjNote provide?';
//	$l_doc[2] = 'How to use ProjNote document broswer?';
	$l_all[$l_doc_t] = $l_doc;

	$l_search_t = 'Search Help';
	$l_search = array();
	$l_search[0] = 'search.php';
	$l_search[1] = 'What kind of search functions does ProjNote provide?';
	$l_search[2] = 'How to use advanced search?';
	$l_search[3] = 'How to use quick search links?';
	$l_search[4] = 'How to use ProjNote search bar?';
	$l_all[$l_search_t] = $l_search;
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#24110;&#21161;&#20013;&#24515; | ProjNote';

	$l_page_title = '&#24110;&#21161;&#20013;&#24515;';

	$l_all = array();

	$l_basic_t = '&#22522;&#26412;&#24110;&#21161;';
	$l_basic = array();
	$l_basic[0] = 'basic.php';
	$l_basic[1] = 'ProjNote &#26159;&#20160;&#20040;&#65311;';
	$l_basic[2] = 'ProjNote &#36890;&#36807;&#21738;&#20123;&#26041;&#24335;&#26469;&#24110;&#21161;&#24744;&#31649;&#29702;&#24744;&#30340;&#39033;&#30446;&#21644;&#24037;&#20316;&#65311;';
	$l_basic[3] = '&#22914;&#20309;&#20351;&#29992; ProjNote &#26469;&#31649;&#29702;&#24744;&#30340;&#39033;&#30446;&#21644;&#24037;&#20316;&#65311;';
	$l_all[$l_basic_t] = $l_basic;

	$l_account_t = '&#36134;&#25143;&#24110;&#21161;';
	$l_account = array();
	$l_account[0] = 'account.php';
	$l_account[1] = '&#22914;&#20309;&#27880;&#20876; ProjNote &#65311;';
	$l_account[2] = 'ProjNote &#30340;&#20010;&#20154;&#24080;&#25143;&#20449;&#24687;&#21253;&#25324;&#20160;&#20040;&#65311;';
	$l_account[3] = '&#22914;&#20309;&#36992;&#35831;&#26379;&#21451;&#21152;&#20837; ProjNote &#65311;';
	$l_all[$l_account_t] = $l_account;

	$l_status_t = '&#39033;&#30446;&#31649;&#29702;&#19982;&#32479;&#35745;&#24110;&#21161;';
	$l_status = array();
	$l_status[0] = 'stat.php';
	$l_status[1] = '&#22914;&#20309;&#21457;&#36865;&#21644;&#25509;&#21463;&#39033;&#30446;&#36992;&#35831;&#65311;';
	$l_status[2] = '&#22914;&#20309;&#20462;&#25913;&#39033;&#30446;&#25104;&#21592;&#22312;&#39033;&#30446;&#20013;&#30340;&#32844;&#36131;&#65292;&#25110;&#21024;&#38500;&#39033;&#30446;&#25104;&#21592;&#65311;';
	$l_status[3] = 'ProjNote &#25552;&#20379;&#21738;&#20123;&#39033;&#30446;&#32479;&#35745;&#65311;';
	$l_all[$l_status_t] = $l_status;

	$l_doc_t = '&#25991;&#26723;&#24110;&#21161;';
	$l_doc = array();
	$l_doc[0] = 'document.php';
	$l_doc[1] = 'ProjNote &#25552;&#20379;&#21738;&#20123;&#25991;&#26723;&#21151;&#33021;&#65311;';
//	$l_doc[2] = '&#22914;&#20309;&#20351;&#29992;&#25991;&#26723;&#27983;&#35272;&#22120;&#65311;';
	$l_all[$l_doc_t] = $l_doc;

	$l_search_t = '&#25628;&#32034;&#24110;&#21161;';
	$l_search = array();
	$l_search[0] = 'search.php';
	$l_search[1] = 'ProjNote &#25552;&#20379;&#21738;&#20123;&#25628;&#32034;&#24418;&#24335;&#65311;';
	$l_search[2] = '&#22914;&#20309;&#20351;&#29992;&#39640;&#32423;&#25628;&#32034;&#65311;';
	$l_search[3] = '&#22914;&#20309;&#20351;&#29992;&#24555;&#36895;&#25628;&#32034;&#38142;&#25509;&#65311;';
	$l_search[4] = '&#22914;&#20309;&#20351;&#29992; ProjNote &#30340;&#25628;&#32034;&#26465;&#65311;';
	$l_all[$l_search_t] = $l_search;
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
	<div style="height:1px;"></div>
	<div class="help_body">
	<div class="help_head" style="">
	<label class="help_header"><?php echo $l_page_title?></label>
	</div>
	<div class="page_saperator"></div>
<?php foreach ($l_all as $key=>$value) { ?>
	<div class="help_detail">
	<label class="help_header" style="font-size:.8em;"><?php echo $key?></label>
	<ul>
<?php foreach ($value as $v_key=>$v_value)
{
	if($v_key!=0) echo '<li><a href="../help/'.$value[0].'#q'.$v_key.'" class="help_link">'.$v_value.'</a></li>';
}
?></ul>
	</div>
	<div class="weak_sap"></div>
<?php }?>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
