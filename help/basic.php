<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Basic Help | ProjNote';

	$l_page_title = 'Basic Help';
	$l_back_link = 'Back to Help Center';

	$l_all = array();

	$l_q_1 = 'What is ProjNote?';
	$l_a_1 = 'ProjNote is an open platform that assists you to manage your project and work. whether you are a student or works, 
			  myPorjnote will definitely assist you to design, arrange and manage your study and work projects. No matter you are working on your school project, customer project or research project,
			  ProjNote will be your best personal assistant to provide you better communicatoin, sharing and coopration with your team.';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = 'How does ProjNote assist you to manage your project and work?';
	$l_a_2 = 'ProjNote helps you to break down a big project into smaller component, a project department, a project phase and etc, to be managed more efficiently. 
			  ProjNote allows user to clearly define the objective, scope and deatils of a work and then assign it to a project memeber to clarify the responsibilities of each member.
			  For a better sharing and communication, ProjNote provides functionalities to share documents and leave quick notes among project members.
			  ProjNote also provides searching functions for a efficient information access; You could find the information you want, no matter a document, a work description or a project memeber, witnin one second.
			  Finally, for project manamgement, a real time understanding of, how healthy the project is, is provided by the project statistics of ProjNote.';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = 'How to use ProjNote to manage your project and work?';
	$l_a_3 = 'ProjNote allows you working on multiple projects concurrently, to work on a particular project, you need to select it first. After select, if you are the project manager, you could break the project into many <span style="color:red">Project Components</span>. 
			  Each individual work in ProjNote is called <span style="color:red">Workitem</span>; a Workitem could be a task, a risk, a defect or a note and etc.
			  ProjNote offers: <span style="color:#008">Project</span>, <span style="color:#008">Project Component</span> and <span style="color:#008">Workitem</span>, three different hierarchies to help you break down, plan and design your project and work.
			  (Note: only project director or manager could create Project Component, only project director, manager and team lead could create Workpackage).';
	$l_all[$l_q_3] = $l_a_3;
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#22522;&#26412;&#24110;&#21161; | ProjNote';

	$l_page_title = '&#22522;&#26412;&#24110;&#21161;';
	$l_back_link = '&#36820;&#22238;&#24110;&#21161;&#20013;&#24515;';

	$l_all = array();

	$l_q_1 = 'ProjNote &#26159;&#20160;&#20040;&#65311;';
	$l_a_1 = 'ProjNote &#26159;&#19968;&#20010;&#24320;&#25918;&#30340;&#32593;&#32476;&#24179;&#21488;&#24110;&#21161;&#24744;&#31649;&#29702;&#24744;&#30340;&#24037;&#20316;&#21644;&#39033;&#30446;&#12290;&#26080;&#35770;&#24744;&#26159;&#22312;&#26657;&#23398;&#20064;&#25110;&#24050;&#27493;&#20837;&#32844;&#22330;&#65292;
			  ProjNote &#37117;&#23558;&#24110;&#21161;&#24744;&#35745;&#21010;&#65292;&#35774;&#35745;&#65292;&#23433;&#25490;&#21644;&#31649;&#29702;&#24744;&#30340;&#23398;&#20064;&#21644;&#24037;&#20316;&#12290;&#26080;&#35770;&#24744;&#26159;&#22312;&#20570;&#27605;&#19994;&#35774;&#35745;&#65292;&#22312;&#20570;&#23458;&#25143;&#39033;&#30446;&#25110;&#26159;&#31185;&#23398;&#30740;&#31350;&#65292;
			  ProjNote &#37117;&#23558;&#25104;&#20026;&#24744;&#26368;&#22909;&#30340;&#31169;&#20154;&#21161;&#29702;&#65292;&#24110;&#21161;&#24744;&#26356;&#22909;&#30340;&#19982;&#22242;&#38431;&#20132;&#27969;&#65292;&#20998;&#20139;&#19982;&#21512;&#20316;&#12290;';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = 'ProjNote &#36890;&#36807;&#21738;&#20123;&#26041;&#24335;&#26469;&#24110;&#21161;&#24744;&#31649;&#29702;&#24744;&#30340;&#39033;&#30446;&#21644;&#24037;&#20316;&#65311;';
	$l_a_2 = 'ProjNote &#36890;&#36807;&#23558;<span style="color:red">&#39033;&#30446;&#32454;&#21270;</span>&#30340;&#26041;&#24335;&#24110;&#21161;&#24744;&#23558;&#19968;&#20010;&#22823;&#30340;&#39033;&#30446;&#21010;&#20998;&#25104;&#30456;&#20114;&#29420;&#31435;&#30340;&#37096;&#38376;&#25110;&#24615;&#36136;&#19981;&#21516;&#30340;&#38454;&#27573;&#12290;&#32454;&#21270;&#21518;&#27599;&#19968;&#20010;&#21010;&#20998;&#20986;&#30340;&#37096;&#20998;&#37117;&#26377;&#20855;&#20307;&#30340;&#20219;&#21153;&#21644;&#32844;&#36131;&#24182;&#26377;&#19987;&#20154;&#20027;&#31649;&#12290; 
			  ProjNote &#36890;&#36807;<span style="color:red">&#20219;&#21153;&#35760;&#24405;</span>&#30340;&#26041;&#24335;&#26126;&#30830;&#27599;&#20010;&#39033;&#30446;&#25104;&#21592;&#22312;&#20570;&#27599;&#39033;&#24037;&#20316;&#26102;&#30340;&#36131;&#20219;&#33539;&#30068;&#12290;&#26032;&#24314;&#27599;&#19968;&#20010;&#20219;&#21153;&#30340;&#26102;&#20505;&#37117;&#20889;&#28165;&#20219;&#21153;&#30340;&#32454;&#33410;&#65292;&#24182;&#25351;&#27966;&#32473;&#19968;&#20010;&#39033;&#30446;&#25104;&#21592;&#65292;&#36131;&#20219;&#26126;&#30830;&#65292;&#20219;&#21153;&#28165;&#26224;&#12290; 
			  ProjNote &#36890;&#36807;<span style="color:red">&#20849;&#20139;&#25991;&#26723;</span>&#21644;<span style="color:red">&#30041;&#35328;&#26495;</span>&#30340;&#26041;&#24335;&#22686;&#24378;&#22242;&#38431;&#30340;&#21327;&#20316;&#21644;&#39033;&#30446;&#20449;&#24687;&#30340;&#21450;&#26102;&#20256;&#36882;&#12290; 
			  ProjNote &#36890;&#36807;<span style="color:red">&#25628;&#32032;</span>&#26041;&#24335;&#24110;&#21161;&#24744;&#38543;&#26102;&#25214;&#21040;&#24744;&#39033;&#30446;&#20013;&#30340;&#27599;&#19968;&#20010;&#32454;&#33410;&#65292;&#26080;&#35770;&#26159;&#36807;&#21435;&#30340;&#19968;&#20010;&#20219;&#21153;&#20449;&#24687;&#25110;&#26159;&#20182;&#20154;&#19978;&#20256;&#30340;&#19968;&#20010;&#25991;&#26723;&#65292;&#24744;&#37117;&#21487;&#20197;&#22312;&#39532;&#19978;&#25214;&#21040;&#12290;&#26368;&#21518;&#65292; 
			  ProjNote &#36890;&#36807;<span style="color:red">&#39033;&#30446;&#32479;&#35745;</span>&#30340;&#26041;&#24335;&#24110;&#21161;&#24744;&#20102;&#35299;&#39033;&#30446;&#30340;&#24037;&#20316;&#37327;&#21644;&#23436;&#25104;&#36827;&#24230;&#12290;';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = '&#22914;&#20309;&#20351;&#29992; ProjNote &#26469;&#31649;&#29702;&#24744;&#30340;&#39033;&#30446;&#21644;&#24037;&#20316;&#65311;';
	$l_a_3 = 'ProjNote 可以帮助您同时参与多个项目，当您加入或创建一个项目后。如果您是项目总监或经理，您可以将项目细化成多个相互独立的部门或性质不同的阶段。
			  ProjNote 把细化出的项目部分称作<span style="color:red"> 项目组</span>。项目组将项目组成部分细节化。它可以是一个项目部门，一个项目里程碑或是一个项目的阶段，并由项目主管，经理或总监负责。 关于具体工作，
			  ProjNote 给每一个项目成员新建具体工作的权限。具体工作被称作 <span style="color:red">工作项</span>，一个工作项可以是一个任务，一个简介，一个错误，一个项目风险等等。
			  ProjNote 提供：<span style="color:#008">项目</span>，<span style="color:#008">项目组</span>，<span style="color:#008">工作项</span> 三个不同的层次帮助您细化，归类并计划管理您的项目和具体的项目工作。工作包和工作项可以在项目组层次下也可以直接在项目下。（注：只有项目主管，经理或总监可以新建工作包）。';
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
