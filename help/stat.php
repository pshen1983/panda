<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Project Management and Statistic Help | ProjNote';

	$l_page_title = 'Project Management and Statistic Help';
	$l_back_link = 'Back to Help Center';

	$l_all = array();

	$l_q_1 = 'How to send and accept project invitations?';
	$l_a_1 = 'After login, you could click on <a href="../message/invitation.php">Project Invitation</a> link to enter Invitation page. If you are invited to any projects, you will see messages on this page. Click to open an invitation and select <span style="color:red">Accept</span> or <span style="color:red">Reject</span> to deal with the invitation.
			  When you send invitations to others, you could enter their emails, plus a brief message and send your invitations. (Note: you need to be a project director or manager to be able to send project invitations)';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = 'How to change the role of or delete a project member?';
	$l_a_2 = 'After login and select a project, if you are the project director or manager, you could click on <a href="../admin/index.php">Project Administration</a> to enter the project management and statistic page. In the <span style="color:red">Team Management</span> section, you could change the role or delete project members.
			  (Note: you cannot change the role of project director or manager on this page, to set a memeber to the porject director or manager, you need to change on the project page in <span style="color:red">Project Detail Information</span> section)';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = 'What project statistics does myProject provide?';
	$l_a_3 = 'In order to assist you manage your projects better, help you to know the productivity of your team better, ProjNote provides <span style="color:red">four</span> critical statistics for your to evaluate and plan the process of your project.
			  <ul style="margin-top:0px;margin-left:10px;">
			  <li style="margin-bottom:15px;">Number of Workitems created and closed over a period of time: <span style="color:#888">Graph includes <span style="color:red">two curves</span>; the first curve shows the number of <span style="color:red">newly created</span> Workitems within a period of time and the second curve shows the number of <span style="color:red">closed</span> Workitems within the same period of time. The number of newly created Workitem reveals the planed work load and the number of closed Workitem shows how quickly the team could finish existing work. With such a graph, you would know <span style="color:red">how fast the team could finish the work</span> and <span style="color:red">how much work is lined up</span> for the team in a period of time.</span></li>
			  <li style="margin-bottom:15px;">Number of none closed Workitems over a period of time: <span style="color:#888">Graph includes <span style="color:red">one curve</span> indicates the number of none complete Workitems within a period of time. Such a statistic reveals both <span style="color:red">how quickly work is finished</span> and <span style="color:red">how busy the project team is</span>. (e.g. If the number of none complete Workitems declines very fast, this means the team finishes work very fast. Also, if the number of none complete Workitems is high, this means the team is relatively busy)</span></li>
			  <li style="margin-bottom:15px;">Number of Workitems being created over 8 period of time: <span style="color:#888">Graph includes <span style="color:red">eight columns</span> shows the number of <span style="color:red">newly created</span> Workitems in 8 periods of time. You can vary the periods duration (e.g. if you pick the duration to be one week, the graph shows the number of newly created Workitems in the past eight weeks, each column represents one week. If you pick the duration to be 3 months, the graph shows the number of newly created Workitems in the past 24 months, each column represents 3 month). Such a graph reveals the created work load for the project team, plus the past performance of the team, one could find <span style="color:red">the rate of project growth</span> and <span style="color:red">how the team reacts with such a growth</span>.</span></li>
			  <li>Number of Workitems being closed over 8 period of time: <span style="color:#888">Graph includes <span style="color:red">eight columns</span> shows the number of <span style="color:red">closed</span> Workitems in 8 periods of time. You can vary the periods duration (e.g. if you pick the duration to be one week, the graph shows the number of closed Workitems in the past eight weeks, each column represents one week. If you pick the duration to be 3 months, the graph shows the number of closed Workitems in the past 24 months, each column represents 3 month). Such a graph reveals <span style="color:red">how well the project team could handle the work load</span>, so one could <span style="color:red">find the balance and plan better in the future</span>.</span></li>
			  </ul>';
	$l_all[$l_q_3] = $l_a_3;
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#39033;&#30446;&#31649;&#29702;&#19982;&#32479;&#35745;&#24110;&#21161; | ProjNote';

	$l_page_title = '&#39033;&#30446;&#31649;&#29702;&#19982;&#32479;&#35745;&#24110;&#21161;';
	$l_back_link = '&#36820;&#22238;&#24110;&#21161;&#20013;&#24515;';

	$l_all = array();

	$l_q_1 = '&#22914;&#20309;&#21457;&#36865;&#21644;&#25509;&#21463;&#39033;&#30446;&#36992;&#35831;&#65311;';
	$l_a_1 = '&#30331;&#24405;&#21518;&#65292;&#24744;&#21487;&#20197;&#28857;&#20987; <a href="../message/invitation.php">&#25910;&#21457;&#39033;&#30446;&#36992;&#35831;</a> &#36827;&#20837;&#36992;&#35831;&#39029;&#12290;&#24403;&#26377;&#39033;&#30446;&#36992;&#35831;&#24744;&#30340;&#26102;&#20505;&#65292;&#24744;&#23558;&#20250;&#30475;&#21040;&#36992;&#35831;&#30701;&#20449;&#65292;&#25171;&#24320;&#30701;&#20449;&#26377;&#24744;&#21487;&#20197;<span style="color:red">&#25509;&#21463;</span>&#25110;<span style="color:red">&#25298;&#32477;</span>&#36992;&#35831;&#12290;&#24403;&#24744;&#35201;&#36992;&#35831;&#26379;&#21451;&#21152;&#20837;&#24744;&#30340;&#39033;&#30446;&#22242;&#38431;&#26102;&#65292;&#24744;&#21487;&#20197;&#30452;&#25509;&#36755;&#20837;&#26379;&#21451;&#30340;&#65288;Email&#65289;&#65292;&#25110;&#26159;&#20174;&#24744;&#36807;&#21435;&#21512;&#20316;&#36807;&#30340;&#26379;&#21451;&#21015;&#34920;&#20013;&#26597;&#25214;&#26379;&#21451;&#28982;&#21518;&#36992;&#35831;&#12290;&#65288;&#27880;&#65306;&#24744;&#24517;&#39035;&#26159;&#39033;&#30446;&#30340;&#24635;&#30417;&#25110;&#32463;&#29702;&#25165;&#33021;&#36992;&#35831;&#20182;&#20154;&#21152;&#20837;&#24744;&#30340;&#22242;&#38431;&#65289;&#12290;';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = '&#22914;&#20309;&#20462;&#25913;&#39033;&#30446;&#25104;&#21592;&#22312;&#39033;&#30446;&#20013;&#30340;&#32844;&#36131;&#65292;&#25110;&#21024;&#38500;&#39033;&#30446;&#25104;&#21592;&#65311;';
	$l_a_2 = '&#30331;&#24405;&#21518;&#65292;&#36873;&#25321;&#19968;&#20010;&#39033;&#30446;&#65292;&#22914;&#26524;&#24744;&#26159;&#35813;&#39033;&#30446;&#24635;&#30417;&#25110;&#32463;&#29702;&#65292;&#24744;&#21487;&#20197;&#28857;&#20987; <a href="../admin/index.php">&#39033;&#30446;&#31649;&#29702;&#19982;&#30417;&#25511;</a> &#36827;&#20837;&#39033;&#30446;&#30340;&#31649;&#29702;&#21644;&#32479;&#35745;&#39029;&#38754;&#12290;&#23637;&#24320;&#35813;&#39029;&#30340;<span style="color:red">&#25104;&#21592;&#31649;&#29702;</span>&#37096;&#20998;&#65292;&#24744;&#21487;&#20197;&#25913;&#21464;&#39033;&#30446;&#25104;&#21592;&#30340;&#32844;&#21153;&#25110;&#32773;&#21024;&#38500;&#39033;&#30446;&#25104;&#21592;&#12290;&#65288;&#27880;&#65306;&#24744;&#19981;&#33021;&#22312;&#39033;&#30446;&#31649;&#29702;&#19982;&#30417;&#25511;&#39029;&#26356;&#25913;&#39033;&#30446;&#32463;&#29702;&#25110;&#24635;&#30417;&#65292;&#24744;&#38656;&#35201;&#21040;&#39033;&#30446;&#39029;&#38754;&#65292;&#22312;<span style="color:red">&#39033;&#30446;&#32454;&#33410;</span>&#20013;&#26356;&#25913;&#65289;&#12290;';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = 'ProjNote &#25552;&#20379;&#21738;&#20123;&#39033;&#30446;&#32479;&#35745;&#65311;';
	$l_a_3 = '&#20026;&#20102;&#26356;&#22909;&#30340;&#21327;&#21161;&#24744;&#31649;&#29702;&#39033;&#30446;&#65292;&#24110;&#21161;&#24744;&#26356;&#22909;&#30340;&#20102;&#35299;&#24744;&#30340;&#22242;&#38431;&#30340;&#24037;&#20316;&#33021;&#21147;&#65292;ProjNote &#25552;&#20379;&#20197;&#19979;&#30340;<span style="color:red">&#22235;&#31181;</span>&#39033;&#30446;&#32479;&#35745;&#24110;&#21161;&#24744;&#26356;&#22909;&#30340;&#35780;&#20272;&#21644;&#35745;&#21010;&#39033;&#30446;&#30340;&#36827;&#31243;&#65306;
			  <ul style="margin-top:0px;margin-left:10px;">
			  <li style="margin-bottom:15px;">&#19968;&#20010;&#26102;&#26399;&#20869;&#25152;&#26032;&#24314;&#21644;&#20851;&#38381;&#30340;&#24037;&#20316;&#39033;&#32479;&#35745;&#65306; <span style="color:#888">&#32479;&#35745;&#22270;&#21253;&#25324;<span style="color:red">&#20004;&#26465;&#26354;&#32447;</span>&#65292;&#19968;&#26465;&#34920;&#31034;&#22312;&#19968;&#27573;&#26102;&#38388;&#20869;&#26032;&#24314;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#65292;&#21478;&#19968;&#26465;&#34920;&#31034;&#22312;&#36825;&#27573;&#26102;&#38388;&#20869;&#20851;&#38381;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#12290;&#26032;&#24314;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#23637;&#31034;&#20102;&#39044;&#26399;&#35745;&#21010;&#30340;&#24037;&#20316;&#37327;&#65292;&#20851;&#38381;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#23637;&#31034;&#20102;&#22242;&#38431;&#23436;&#25104;&#24037;&#20316;&#30340;&#36895;&#24230;&#12290;&#36825;&#20010;&#32479;&#35745;&#23637;&#31034;&#20102;&#39033;&#30446;<span style="color:red">&#24037;&#20316;&#37327;&#31215;&#32047;&#30340;&#36827;&#24230;</span>&#20197;&#21450;&#39033;&#30446;<span style="color:red">&#22242;&#38431;&#23436;&#25104;&#24037;&#20316;&#30340;&#25928;&#29575;</span>&#12290;</span></li>
			  <li style="margin-bottom:15px;">&#19968;&#20010;&#26102;&#26399;&#20869;&#26410;&#23436;&#25104;&#30340;&#24037;&#20316;&#39033;&#32479;&#35745;&#65306; <span style="color:#888">&#32479;&#35745;&#22270;&#21253;&#25324;<span style="color:red">&#19968;&#26465;&#26354;&#32447;</span>&#34920;&#31034;&#22312;&#19968;&#27573;&#26102;&#38388;&#20869;&#27809;&#26377;&#34987;&#23436;&#25104;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#65292;&#27809;&#26377;&#34987;&#23436;&#25104;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#23637;&#31034;&#20102;&#39033;&#30446;<span style="color:red">&#22242;&#38431;&#30340;&#32321;&#24537;&#31243;&#24230;</span>&#21644;<span style="color:red">&#23436;&#25104;&#24037;&#20316;&#36895;&#24230;</span>&#12290;&#65288;&#20363;&#65306;&#25152;&#26377;&#24037;&#20316;&#39033;&#37117;&#23436;&#25104;&#65292;&#35828;&#26126;&#22242;&#38431;&#27809;&#26377;&#24037;&#20316;&#12290;&#24403;&#26377;&#24456;&#22810;&#24037;&#20316;&#39033;&#26410;&#23436;&#25104;&#26102;&#65292;&#35828;&#26126;&#22242;&#38431;&#38750;&#24120;&#32321;&#24537;&#65289;&#12290;</span></li>
			  <li style="margin-bottom:15px;">&#20843;&#27573;&#26102;&#26399;&#38388;&#38548;&#20869;&#26032;&#24314;&#30340;&#24037;&#20316;&#39033;&#32479;&#35745;&#65306; <span style="color:#888"><span style="color:red">&#26609;&#24418;</span>&#32479;&#35745;&#34920;&#23637;&#31034;8&#20010;&#30456;&#21516;&#30340;&#26102;&#38388;&#27573;&#20013;<span style="color:red">&#26032;&#24314;</span>&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#12290;&#24744;&#21487;&#20197;&#20808;&#25321;&#26102;&#38388;&#27573;&#30340;&#38388;&#38548;&#38271;&#24230;&#65288;&#20363;&#65306;&#22914;&#26524;&#24744;&#36873;&#25321;&#38388;&#38548;&#38271;&#24230;&#20026;&#19968;&#21608;&#65292;&#37027;&#20040;&#22270;&#34920;&#23558;&#23637;&#31034;&#36807;&#21435;8&#21608;&#20013;&#26032;&#24314;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#65292;&#27599;&#20010;&#26609;&#20195;&#34920;&#19968;&#21608;&#12290;&#22914;&#26524;&#38388;&#38548;&#38271;&#24230;&#20026;&#19977;&#20010;&#26376;&#65292;&#37027;&#20040;&#22270;&#34920;&#23637;&#31034;&#36807;&#21435;&#20004;&#24180;&#20013;&#26032;&#24314;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#65292;&#27599;&#20010;&#26609;&#20195;&#34920;&#19977;&#20010;&#26376;&#65289;&#12290;&#27492;&#39033;&#32479;&#35745;&#23637;&#31034;&#36807;&#21435;&#26032;&#24314;&#30340;&#24037;&#20316;&#37327;&#65292;&#20877;&#21152;&#19978;&#22242;&#38431;&#36807;&#21435;&#30340;&#34920;&#29616;&#65292;&#26377;&#21161;&#20110;&#24744;<span style="color:red">&#23637;&#26395;&#23558;&#26469;&#30340;&#24037;&#20316;&#24378;&#24230;&#23545;&#22242;&#38431;&#30340;&#24433;&#21709;</span>&#20197;&#21450;<span style="color:red">&#23398;&#20064;&#39033;&#30446;&#36827;&#23637;&#19982;&#24037;&#20316;&#24378;&#24230;&#30340;&#20851;&#31995;</span>&#12290;</span></li>
			  <li>&#20843;&#27573;&#26102;&#26399;&#38388;&#38548;&#20869;&#34987;&#20851;&#38381;&#30340;&#24037;&#20316;&#39033;&#32479;&#35745;&#65306; <span style="color:#888"><span style="color:red">&#26609;&#24418;</span>&#32479;&#35745;&#34920;&#23637;&#31034;8&#20010;&#30456;&#21516;&#30340;&#26102;&#38388;&#27573;&#20013;<span style="color:red">&#23436;&#25104;</span>&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#12290;&#24744;&#21487;&#20197;&#20808;&#25321;&#26102;&#38388;&#27573;&#30340;&#38388;&#38548;&#38271;&#24230;&#65288;&#20363;&#65306;&#22914;&#26524;&#24744;&#36873;&#25321;&#38388;&#38548;&#38271;&#24230;&#20026;&#19968;&#21608;&#65292;&#37027;&#20040;&#22270;&#34920;&#23558;&#23637;&#31034;&#36807;&#21435;8&#21608;&#20013;&#23436;&#25104;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#65292;&#27599;&#20010;&#26609;&#20195;&#34920;&#19968;&#21608;&#12290;&#22914;&#26524;&#38388;&#38548;&#38271;&#24230;&#20026;&#19977;&#20010;&#26376;&#65292;&#37027;&#20040;&#22270;&#34920;&#23637;&#31034;&#36807;&#21435;&#20004;&#24180;&#20013;&#23436;&#25104;&#30340;&#24037;&#20316;&#39033;&#25968;&#30446;&#65292;&#27599;&#20010;&#26609;&#20195;&#34920;&#19977;&#20010;&#26376;&#65289;&#12290;&#27492;&#39033;&#32479;&#35745;&#23637;&#31034;&#36807;&#21435;&#22242;&#38431;&#23436;&#25104;&#30340;&#24037;&#20316;&#37327;&#65292;&#26377;&#21161;&#20110;&#23398;&#20064;<span style="color:red">&#22242;&#38431;&#30340;&#24037;&#20316;&#33021;&#21147;</span>&#24182;<span style="color:red">&#35745;&#21010;&#26410;&#26469;&#30340;&#24037;&#20316;&#20998;&#37197;</span>&#12290;</span></li>
			  </ul>';
	$l_all[$l_q_3] = $l_a_3;
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
