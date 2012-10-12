<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Account Help | ProjNote';

	$l_page_title = 'Account Help';
	$l_back_link = 'Back to Help Center';

	$l_all = array();

	$l_q_1 = 'How to register?';
	$l_a_1 = 'Open <a href="../default/register.php">Sign Up</a> page, fill in your <span style="color:red">Email</span> as your account name, your <span style="color:red">last name</span> and <span style="color:red">first name</span>, your personal <span style="color:red">password</span> as well as <span style="color:red">check code</span> to register.
			  ProjNote will use your Email as the main contacting method, so please use the email account you use the most frequently to register. If there are errors during registration, messages will be displayed; otherwise, you will be directed to <a href="../default/login.php">Login</a> page after registeration.';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = 'What does ProjNote personal information contain?';
	$l_a_2 = 'Your Personal account information includes your <span style="color:red">Basic Information</span>, your <span style="color:red">Education History</span> and your <span style="color:red">Employeement History</span>.
			  <span style="color:red">Basic Information</span> includes your Email address, last name, first name, birth day, living city and interests.
			  <span style="color:red">Education History</span> includes the list of schools and institutions you attended. Detail information includes, the name of the school or institution, department you studied in, degree type and attending years.
			  <span style="color:red">Employeement History</span> includes the list of companies or firms you worked for. Detail information includes, the name of the company or firm, your role and years worked.
			  (Only your last name, first name and Email in Baisc Information are mandatory, all other information is voluntary)';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = 'How to invite friends to join ProjNote?';
	$l_a_3 = 'To invite freinds, you need to login first. After login, click on <a href="../message/invite_friend.php">Friend Invitation</a> link on the left side of the page. There are a couple ways to invite your friends. You could invite your friend by entering his/her email address, or you could invite all the contacts in your MSN account.
			  Simply enter your MSN account name and password to send invitations to all your MSN contacts. ProjNote will NOT save your MSN password. Also, you could change your MSN password before invite your friends and chagne back to the original password after sending the invitations to be extra safe.';
	$l_all[$l_q_3] = $l_a_3;
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#36134;&#25143;&#24110;&#21161; | ProjNote';

	$l_page_title = '&#36134;&#25143;&#24110;&#21161;';
	$l_back_link = '&#36820;&#22238;&#24110;&#21161;&#20013;&#24515;';

	$l_all = array();

	$l_q_1 = '&#22914;&#20309;&#27880;&#20876; ProjNote &#65311;';
	$l_a_1 = '&#25171;&#24320;<a href="../default/register.php">&#27880;&#20876;&#39029;</a>&#65292;&#22635;&#20889;&#24744;&#30340;&#30005;&#23376;&#37038;&#20214;&#65288;<span style="color:red">Email</span>&#65289;&#20316;&#20026;&#24080;&#25143;&#21517;&#65292;&#24744;&#30340;<span style="color:red">&#22995;&#27663;</span>&#21644;<span style="color:red">&#21517;&#31216;</span>&#65292;&#24744;&#30340;&#20010;&#20154;<span style="color:red">&#23494;&#30721;</span>&#20197;&#21450;&#31995;&#32479;<span style="color:red">&#39564;&#35777;&#30721;</span>&#21363;&#21487;&#27880;&#20876;&#12290;
			  ProjNote &#26159;&#20197;&#24744;&#30340;&#24080;&#25143;&#21517;&#65288;Email&#65289;&#20316;&#20026;&#20027;&#35201;&#32852;&#31995;&#26041;&#24335;&#30340;&#65292;&#25152;&#20197;&#35831;&#24744;&#29992;&#24120;&#29992;&#30340;&#30005;&#23376;&#37038;&#20214;&#27880;&#20876;&#12290;&#22914;&#36755;&#20837;&#30340;&#20449;&#24687;&#26377;&#35823;&#65292;&#31995;&#32479;&#20250;&#32473;&#24744;&#25552;&#31034;&#12290;&#33509;&#26080;&#35823;&#65292;&#27880;&#20876;&#25104;&#21151;&#21518;&#31995;&#32479;&#23558;&#25171;&#24320;<a href="../default/login.php">&#30331;&#24405;</a>&#39029;&#38754;&#12290;';
	$l_all[$l_q_1] = $l_a_1;

	$l_q_2 = 'ProjNote &#30340;&#20010;&#20154;&#24080;&#25143;&#20449;&#24687;&#21253;&#25324;&#20160;&#20040;&#65311;';
	$l_a_2 = '&#24744;&#30340;&#20010;&#20154;&#24080;&#25143;&#20449;&#24687;&#21253;&#25324;&#24744;&#30340;<span style="color:red">&#22522;&#26412;&#36164;&#26009;</span>&#65292;&#24744;&#30340;<span style="color:red">&#25945;&#32946;&#21382;&#21490;</span>&#65292;&#20197;&#21450;&#24744;&#30340;<span style="color:red">&#24037;&#20316;&#21382;&#21490;</span>&#12290;<span style="color:red">&#22522;&#26412;&#36164;&#26009;</span>&#21253;&#25324;&#24744;&#30340;&#30005;&#23376;&#37038;&#20214;&#65288;Email&#65289;&#65292;&#22995;&#21517;&#65292;&#29983;&#26085;&#65292;&#25152;&#22312;&#22478;&#24066;&#65292;&#20852;&#36259;&#29233;&#22909;&#12290;<span style="color:red">&#25945;&#32946;&#21382;&#21490;</span>&#21253;&#25324;&#24744;&#25152;&#23601;&#35835;&#30340;&#38498;&#26657;&#21015;&#34920;&#65292;&#20197;&#21450;&#27599;&#20010;&#38498;&#26657;&#30340;&#21517;&#31216;&#65292;&#23601;&#35835;&#31995;&#37096;&#65292;&#23398;&#20301;&#31181;&#31867;&#65292;&#20837;&#23398;&#21644;&#27605;&#19994;&#24180;&#20221;&#12290;<span style="color:red">&#24037;&#20316;&#21382;&#21490;</span>&#21253;&#25324;&#24744;&#24037;&#20316;&#36807;&#30340;&#20844;&#21496;&#21015;&#34920;&#65292;&#20197;&#21450;&#27599;&#20010;&#20844;&#21496;&#30340;&#21517;&#31216;&#65292;&#25152;&#22312;&#22478;&#24066;&#65292;&#24744;&#30340;&#32844;&#20301;&#65292;&#24320;&#22987;&#24037;&#20316;&#21644;&#31163;&#24320;&#30340;&#24180;&#20221;&#12290;&#65288;&#27880;&#65306;&#21482;&#26377;&#22522;&#26412;&#36164;&#26009;&#20013;&#30340;Email&#65292;&#22995;&#21517;&#26159;&#24517;&#39035;&#22635;&#20889;&#30340;&#20869;&#23481;&#65292;&#20854;&#20182;&#36164;&#26009;&#37117;&#26159;&#24744;&#33258;&#24895;&#22635;&#20889;&#30340;&#65289;&#12290;';
	$l_all[$l_q_2] = $l_a_2;

	$l_q_3 = '&#22914;&#20309;&#36992;&#35831;&#26379;&#21451;&#21152;&#20837; ProjNote &#65311;';
	$l_a_3 = '&#30331;&#24405;&#21518;&#65292;&#24744;&#21487;&#20197;&#28857;&#20987;<a href="../message/invite_friend.php">&#36992;&#35831;&#26379;&#21451;&#21152;&#20837;</a>&#38142;&#25509;&#36992;&#35831;&#22909;&#26377;&#12290;&#24744;&#21487;&#20197;&#36890;&#36807;&#36755;&#20837;&#26379;&#21451;&#30340;&#65288;Email&#65289;&#22320;&#22336;&#21457;&#36865;&#21333;&#20010;&#36992;&#35831;&#12290;&#20063;&#21487;&#20197;&#36755;&#20837;&#24744;&#30340; MSN &#30331;&#24405;&#20449;&#24687;&#24182;&#20174;&#24744; MSN &#26379;&#21451;&#21015;&#34920;&#20013;&#36873;&#25321;&#26379;&#21451;&#26469;&#21457;&#36865;&#32676;&#20307;&#36992;&#35831;&#12290;&#24744;&#30340; MSN &#23494;&#30721;&#19981;&#20250;&#34987;&#20648;&#23384;&#65292;&#24744;&#21487;&#20197;&#25918;&#24515;&#20351;&#29992;&#12290;&#24744;&#20063;&#21487;&#20197;&#20808;&#25913;&#23494;&#30721;&#65292;&#23548;&#20837;&#26379;&#21451;&#21015;&#34920;&#26377;&#20877;&#25913;&#22238;&#21407;&#22987;&#23494;&#30721;&#65292;&#30830;&#20445;&#23494;&#30721;&#23433;&#20840;&#12290;';
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
