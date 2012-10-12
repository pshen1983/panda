<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Search Help | ProjNote';

	$l_page_title = 'Search Help';
	$l_back_link = 'Back to Help Center';

	$l_all = array();

	$l_q_1 = 'What kind of search functions does ProjNote provide?';
	$l_a_1 = 'myProject provides three kind of searching mechanism: <span style="color:red">Quick Search</span>, <span style="color:red">Advanced Search</span> and <span style="color:red">ProjNote Search Bar</span> to help you find what you needs in minutes.
			  <ul style="margin-top:0px;margin-left:10px;">
			  <li style="margin-bottom:15px;">Quick Search: <span style="color:#888">Only contains <span style="color:red">fixed search</span> for <span style="color:red">Workpackage</span> and <span style="color:red">Workitem</span> related information. After you login and select a project, you will find Quick Search links on the left side. Each Quick Seach link is a particular fixed search, which is used most often.</span></li>
			  <li style="margin-bottom:15px;">Advanced Search: <span style="color:#888">myProject provides <span style="color:red">User</span>, <span style="color:red">Workitem</span> and <span style="color:red">Docuemnt</span> advanced search. In order to use Advanced Search, one must login first, after login, Advanced Search will appear on the left side. With Advanced Search, user could enter more search criteria to search more <span style="color:red">precisely</span>.</span></li>
			  <li>ProjNote Search Bar: <span style="color:#888">ProjNote offers Search Bar for <span style="color:red">User</span>, <span style="color:red">Project</span>, <span style="color:red">Project Component</span> and <span style="color:red">Workitem</span> searching. Search Bar is free text search, enter the name of a User, Project, Project Component, Workpackage and Workitem to search the information. (Note: Search Bar support partial text search)</span></li>';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = 'How to use advanced search?';
	$l_a_2 = 'ProjNote provides Advanced Search including <span style="color:red">User</span>, <span style="color:red">Workitem</span> and <span style="color:red">Docuemnt</span>. To use Advanced Search, the user must login, and Advanced Search links will appear on the left, click on the link to enter searching page.
			  <ul style="margin-top:0px;margin-left:10px;">
			  <li style="margin-bottom:15px;">User Search: <span style="color:#888">Entering user\'s <span style="color:red">last name</span>, <span style="color:red">first name</span> and <span style="color:red">email account</span> to search user. Entering one of the three information one could search for users fit the criteria.</span></li>
			  <li style="margin-bottom:15px;">Workitem Search: <span style="color:#888">Workitem is the most frequently searched information in ProjNote. With Workitem Advanced Search, one could search workitems with the <span style="color:red">Project</span> and <span style="color:red">Project Component</span> it is in, or the Workitem\'s <span style="color:red">Summary</span>, <span style="color:red">Time Created</span>, <span style="color:red">Most Resent Modified Time</span>, <span style="color:red">Deadline</span> as well as <span style="color:red">Type</span>, <span style="color:red">Progress</span> and <span style="color:red">Priority</span>. Workitem Advanced Search also supports partial search, entering one of the above information, one could search for workitems.</span></li>
			  <li>Document Search: <span style="color:#888">Document could be uploaded to a <span style="color:red">Project</span>, <span style="color:red">Project Component</span> or <span style="color:red">Workitem</span> to be shared by the team. As a result, Document searching is frequently used. To search a document, one could enter its <span style="color:red">name</span>, <span style="color:red">uploading user name</span> and <span style="color:red">time uploaded</span>. Again, Document Advanced Search supports partial searching, with one of the above information one could search for desired documents.</span></li>';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = 'How to use quick search links?';
	$l_a_3 = 'Quick Search links in ProjNote are <span style="color:red">fixed</span> searching criterias for commonly used searches. After <span style="color:red">login</span> and <span style="color:red">selecting a project</span>, Quick Search links will appear on the left side of the page. (e.g. "All my open workitems" is a Quick Search link, which will search for all your opened workitems in this project)';
	$l_all[$l_q_3] = $l_a_3;

	$l_q_4 = 'How to use ProjNote Search Bar?';
	$l_a_4 = 'To use Search Bar, the user must be logged in the tye system first and with ProjNote\'s Search Bar, one could search for <span style="color:red">other users</span> as well as the <span style="color:red">Projects</span>, <span style="color:red">Project Components</span> and <span style="color:red">Workitems</span> that he or she is involved in. (Note: Search Bar searches information with the beginning of the words entered, such as if you enter "First" for search, information like "First Project" or "First Document" will be found; however, "My First Project" will NOT be found becuase it does not started with "First").';
	$l_all[$l_q_4] = $l_a_4;
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#25628;&#32034;&#24110;&#21161; | ProjNote';

	$l_page_title = '&#25628;&#32034;&#24110;&#21161;';
	$l_back_link = '&#36820;&#22238;&#24110;&#21161;&#20013;&#24515;';

	$l_all = array();

	$l_q_1 = 'ProjNote &#25552;&#20379;&#21738;&#20123;&#25628;&#32034;&#24418;&#24335;&#65311;';
	$l_a_1 = 'ProjNote &#20026;&#24744;&#25552;&#20379;&#19977;&#31181;&#25628;&#32034;&#26041;&#24335;&#26381;&#21153;&#24744;&#22312;&#26368;&#30701;&#30340;&#26102;&#38388;&#20869;&#25214;&#21040;&#24744;&#25152;&#38656;&#35201;&#30340;&#31449;&#20869;&#20449;&#24687;&#12290;&#19977;&#31181;&#25628;&#32034;&#26041;&#24335;&#21253;&#25324;&#65306;<span style="color:red">&#24555;&#36895;&#25628;&#32034;</span>&#65292;<span style="color:red">&#39640;&#32423;&#25628;&#32034;</span>&#21644;<span style="color:red">&#25628;&#32034;&#26465;&#25628;&#32034;</span>&#12290;
			  <ul style="margin-top:0px;margin-left:10px;">
			  <li style="margin-bottom:15px;">&#24555;&#36895;&#25628;&#32034;&#65306;<span style="color:#888">&#20165;&#38480;&#20110;&#39033;&#30446;&#20013;&#24037;&#20316;&#21253;&#19982;&#24037;&#20316;&#39033;&#30340;&#30456;&#20851;&#20869;&#23481;&#30340;<span style="color:red">&#29305;&#23450;&#25628;&#32034;</span>&#12290;&#22312;&#24744;&#30331;&#24405;&#24182;&#36873;&#25321;&#19968;&#20010;&#39033;&#30446;&#20043;&#21518;&#65292;&#24744;&#23558;&#20250;&#22312;&#24038;&#20391;&#30475;&#21040;&#24555;&#36895;&#25628;&#32034;&#30340;&#38142;&#25509;&#12290;&#27599;&#19968;&#20010;&#24555;&#36895;&#25628;&#32034;&#38142;&#25509;&#37117;&#26159;&#19968;&#20010;&#29305;&#23450;&#30340;&#24120;&#29992;&#25628;&#32034;&#65292;&#20415;&#20110;<span style="color:red">&#26356;&#24555;</span>&#30340;&#25214;&#21040;&#25628;&#32034;&#30340;&#20449;&#24687;&#12290;</span></li>
			  <li style="margin-bottom:15px;">&#39640;&#32423;&#25628;&#32034;&#65306;<span style="color:#888">ProjNote &#25552;&#20379;<span style="color:red">&#29992;&#25143;</span>&#65292;<span style="color:red">&#24037;&#20316;&#39033;</span>&#21644;<span style="color:red">&#25991;&#26723;</span>&#30340;&#39640;&#32423;&#25628;&#32034;&#12290;&#20351;&#29992;&#39640;&#32423;&#25628;&#32034;&#21151;&#33021;&#65292;&#29992;&#25143;&#38656;&#35201;&#20808;&#30331;&#24405;&#65292;&#32780;&#21518;&#39640;&#32423;&#25628;&#32034;&#26639;&#23558;&#23637;&#31034;&#22312;&#24038;&#20391;&#12290;&#39640;&#32423;&#25628;&#32034;&#21487;&#20197;&#35753;&#29992;&#25143;&#36755;&#20837;&#26356;&#22810;&#30340;&#25628;&#32034;&#20449;&#24687;&#65292;&#20415;&#20110;<span style="color:red">&#26356;&#20934;&#30830;</span>&#30340;&#25214;&#21040;&#25628;&#32034;&#30340;&#20449;&#24687;&#12290;</span></li>
			  <li>&#25628;&#32034;&#26465;&#25628;&#32034;&#65306;<span style="color:#888">ProjNote &#30340;&#25628;&#32034;&#26465;&#25552;&#20379;<span style="color:red">&#29992;&#25143;</span>&#65292;<span style="color:red">&#39033;&#30446;</span>&#65292;<span style="color:red">&#39033;&#30446;&#32452;</span>&#21644;<span style="color:red">&#24037;&#20316;&#39033;</span>&#30340;&#25628;&#32034;&#12290;&#25628;&#32034;&#26465;&#26159;&#33258;&#30001;&#25991;&#26412;&#25628;&#32034;&#65292;&#36755;&#20837;&#29992;&#25143;&#65292;&#39033;&#30446;&#65292;&#39033;&#30446;&#32452;&#65292;&#24037;&#20316;&#21253;&#25110;&#24037;&#20316;&#39033;&#30340;&#21517;&#31216;&#21363;&#21487;&#25628;&#32034;&#12290;&#65288;&#27880;&#65306;&#25628;&#32034;&#26465;&#25903;&#25345;&#19981;&#24536;&#20840;&#21517;&#31216;&#25628;&#32034;&#65289;&#12290;</span></li>
			  </ul>';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = '&#22914;&#20309;&#20351;&#29992;&#39640;&#32423;&#25628;&#32034;&#65311;';
	$l_a_2 = 'ProjNote &#25552;&#20379;&#30340;&#39640;&#32423;&#25628;&#32034;&#21253;&#25324;<span style="color:red;">&#29992;&#25143;</span>&#25628;&#32034;&#65292;<span style="color:red;">&#24037;&#20316;&#39033;</span>&#25628;&#32034;&#21644;<span style="color:red;">&#25991;&#26723;</span>&#25628;&#32034;&#12290;&#20351;&#29992;&#39640;&#32423;&#25628;&#32034;&#65292;&#24744;&#38656;&#35201;&#20808;&#30331;&#24405;&#65292;&#30331;&#24405;&#21518;&#24744;&#23558;&#22312;&#24038;&#20391;&#30340;&#25805;&#20316;&#26639;&#25214;&#21040;&#39640;&#32423;&#25628;&#32034;&#30340;&#19977;&#20010;&#36830;&#25509;&#65292;&#28857;&#20987;&#36827;&#20837;&#25628;&#32034;&#39029;&#38754;&#12290;
			  <ul style="margin-top:0px;margin-left:10px;">
			  <li style="margin-bottom:15px;">&#29992;&#25143;&#25628;&#32034;&#65306;<span style="color:#888;">&#24744;&#21487;&#20197;&#36890;&#36807;&#36755;&#20837;&#29992;&#25143;<span style="color:red;">&#22995;&#27663;</span>&#65292;&#29992;&#25143;<span style="color:red;">&#21517;&#31216;</span>&#21644;&#29992;&#25143;<span style="color:red;">&#37038;&#31665;&#65288;&#24080;&#21495;&#65289;</span>&#26469;&#25152;&#25628;&#12290;&#29992;&#25143;&#25628;&#32034;&#25903;&#25345;&#37096;&#20998;&#25628;&#32034;&#65292;&#24744;&#21482;&#38656;&#35201;&#36755;&#20837;&#35201;&#25628;&#32034;&#30340;&#29992;&#25143;&#22995;&#27663;&#65292;&#21517;&#31216;&#25110;&#24080;&#25143;&#20013;&#30340;&#19968;&#20010;&#25110;&#22810;&#20010;&#65292;&#28982;&#21518;&#28857;&#20987;&#25628;&#32034;&#25353;&#38062;&#25628;&#32034;&#29992;&#25143;&#12290;</span></li>
			  <li style="margin-bottom:15px;">&#24037;&#20316;&#39033;&#25628;&#32034;&#65306;<span style="color:#888;">&#24037;&#20316;&#39033;&#26159; ProjNote &#20013;&#26368;&#24120;&#35265;&#30340;&#25628;&#32034;&#20869;&#23481;&#12290;&#24744;&#21487;&#20197;&#36890;&#36807;&#24037;&#20316;&#39033;&#25152;&#22312;<span style="color:red;">&#39033;&#30446;</span>&#65292;<span style="color:red;">&#39033;&#30446;&#32452;</span>&#21644;<span style="color:red;">&#24037;&#20316;&#39033;&#21495;</span>&#65292;&#24037;&#20316;&#39033;&#30340;<span style="color:red;">&#31616;&#20171;</span>&#65292;<span style="color:red;">&#21019;&#24314;&#26102;&#38388;</span>&#65292;<span style="color:red;">&#26368;&#36817;&#20462;&#25913;&#26102;&#38388;</span>&#65292;<span style="color:red;">&#25130;&#27490;&#26085;&#26399;</span>&#36824;&#26377;&#24037;&#20316;&#39033;&#30340;<span style="color:red;">&#31867;&#21035;</span>&#65292;<span style="color:red;">&#29366;&#24577;</span>&#65292;<span style="color:red;">&#20248;&#20808;&#24230;</span>&#36827;&#34892;&#25628;&#32034;&#12290;&#24037;&#20316;&#39033;&#25628;&#32034;&#21516;&#26679;&#25903;&#25345;&#37096;&#20998;&#25628;&#32034;&#65292;&#24744;&#21482;&#38656;&#35201;&#36755;&#20837;&#19968;&#20010;&#20197;&#19978;&#20869;&#23481;&#21363;&#21487;&#25628;&#32034;&#24037;&#20316;&#39033;&#12290;</span></li>
			  <li>&#25991;&#26723;&#25628;&#32034;&#65306;<span style="color:#888;">&#25991;&#26723;&#21487;&#20197;&#19978;&#31359;&#21040;<span style="color:red">&#39033;&#30446;</span>&#65292;<span style="color:red">&#39033;&#30446;&#32452;</span>&#21644;<span style="color:red">&#24037;&#20316;&#39033;</span>&#12290;&#25152;&#20197;&#25991;&#26723;&#25628;&#32034;&#24179;&#20961;&#20351;&#29992;&#65292;&#38500;&#20102;&#36755;&#20837;&#25991;&#26723;&#25152;&#22312;&#30340;&#39033;&#30446;&#65292;&#39033;&#30446;&#32452;&#65292;&#24037;&#20316;&#21253;&#21644;&#24037;&#20316;&#39033;&#65292;&#24744;&#36824;&#21487;&#20197;&#36755;&#20837;&#25991;&#26723;&#30340;<span style="color:red">&#21517;&#31216;</span>&#65292;<span style="color:red">&#19978;&#20256;&#29992;&#25143;</span>&#21644;<span style="color:red">&#19978;&#20256;&#26102;&#38388;</span>&#36827;&#34892;&#25628;&#32034;&#12290;&#25991;&#26723;&#25628;&#32034;&#21516;&#26679;&#25903;&#25345;&#37096;&#20998;&#25628;&#32034;&#65292;&#24744;&#21482;&#38656;&#35201;&#36755;&#20837;&#19968;&#20010;&#20197;&#19978;&#20869;&#23481;&#21363;&#21487;&#25628;&#32034;&#25991;&#26723;&#12290;</span></li>
			  </ul>';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = '&#22914;&#20309;&#20351;&#29992;&#24555;&#36895;&#25628;&#32034;&#38142;&#25509;&#65311;';
	$l_a_3 = 'ProjNote &#30340;&#24555;&#36895;&#25628;&#32034;&#38142;&#25509;&#26159;&#19968;&#20123;&#24120;&#29992;&#30340;&#65292;&#20026;&#20102;&#26041;&#20415;&#29992;&#25143;&#20570;&#20986;&#24555;&#36895;&#25628;&#32034;&#30340;<span style="color:red">&#22266;&#23450;&#38142;&#25509;</span>&#12290;&#29992;&#25143;&#21482;&#26377;<span style="color:red">&#30331;&#24405;</span>&#24182;&#19988;<span style="color:red">&#36873;&#25321;&#19968;&#20010;&#39033;&#30446;</span>&#21518;&#24555;&#36895;&#25628;&#32034;&#25165;&#20250;&#26174;&#31034;&#22312;&#39029;&#38754;&#24038;&#20391;&#12290;&#65288;&#20363;&#22914;&#65306;"&#39033;&#30446;&#25104;&#21592;&#21015;&#34920;"&#23601;&#26159;&#19968;&#20010;&#24555;&#36895;&#25628;&#32034;&#38142;&#25509;&#65292;&#28857;&#20987;&#21518;&#25628;&#32034;&#32467;&#26524;&#26174;&#31034;&#29992;&#25143;&#25152;&#22312;&#39033;&#30446;&#30340;&#25104;&#21592;&#21015;&#34920;&#65289;&#12290;';
	$l_all[$l_q_3] = $l_a_3;

	$l_q_4 = '&#22914;&#20309;&#20351;&#29992; ProjNote &#30340;&#25628;&#32034;&#26465;&#65311;';
	$l_a_4 = '&#36890;&#36807;&#22312;&#25628;&#32034;&#26465;&#36755;&#20837;&#20851;&#38190;&#23383;&#36827;&#34892;&#25628;&#32034;&#65292;&#29992;&#25143;&#21487;&#20197;&#25628;&#32034;&#21040;&#20854;&#20182;<span style="color:red">&#29992;&#25143;</span>&#65292;&#33258;&#24049;&#25152;&#21442;&#21152;&#30340;<span style="color:red">&#39033;&#30446;</span>&#65292;&#22312;&#26377;&#39033;&#30446;&#36873;&#25321;&#30340;&#26102;&#20505;&#36824;&#20250;&#25628;&#32034;&#21040;&#35813;&#39033;&#30446;&#20013;&#21644;&#20851;&#38190;&#23383;&#26377;&#20851;&#30340;<span style="color:red">&#39033;&#30446;&#32452;</span>&#21644;<span style="color:red">&#24037;&#20316;&#39033;</span>&#12290;&#65288;&#27880;&#65306;&#36755;&#20837;&#30340;&#20851;&#38190;&#23383;&#39035;&#26159;&#25152;&#35201;&#25628;&#32034;&#20869;&#23481;&#30340;&#24320;&#22836;&#37096;&#20998;&#65292;&#22914;&#24744;&#35201;&#25628;&#32034;&#21517;&#31216;&#20026;"&#22823;&#22235;&#27605;&#19994;&#35774;&#35745;"&#30340;&#39033;&#30446;&#65292;&#20851;&#38190;&#23383;&#39035;&#26159;&#20174;"&#22823;"&#24320;&#22987;&#30340;&#19968;&#20010;&#25110;&#22810;&#20010;&#23376;&#65292;&#33509;&#36755;&#20837;&#25628;&#32034;&#20851;&#38190;&#23376;"&#22235;&#27605;&#19994;"&#65292;&#21017;&#25628;&#32034;&#19981;&#21040;&#35813;&#39033;&#30446;&#65289;&#12290;';
	$l_all[$l_q_4] = $l_a_4;
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
<a name="top"></a>
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
	<div class="help_head"><label class="help_header"><?php echo $l_page_title?></label>
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
