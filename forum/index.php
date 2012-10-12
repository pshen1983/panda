<?php
include_once ("../_obj/ForumSection.inc.php");
include_once ("../_obj/ForumThread.inc.php");
include_once ("../_obj/ForumMessage.inc.php");
include_once ("../common/Objects.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

include_once ("language/l_index.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/forum.css' />
<script type='text/javascript' src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once isset($_SESSION['_userId']) ? '../common/header_2.inc.php' : '../common/header_1.inc.php';?>
<div id="page_body">
<?php if( isset($_SESSION['_userId']) ) { include_once '../common/path_nav.inc.php'; ?>
<div id="top_link_saperator"></div>
<?php } else {?>
<div style="height:1px;"></div>
<?php } ?>
<div id="forumtitle"><h1><?php echo $l_forum?></h1></div>
<table id="forumtable" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th class="first"><?php echo $l_header?></th>
<th class="second"><?php echo $l_topic?></th>
<th class="third"><?php echo $l_posts?></th>
<th class="fourth"><?php echo $l_lpost?></th>
</tr>
</thead>
<tbody><?php 
$sections = ForumSection::getSections();
foreach( $sections as $sec ) { 
$sid = $sec->getSid();
$tcount = ForumThread::getSectionThreadCount($sid);
$mcount = ForumMessage::getSectionMessageCount($sid);
$mcount -= $tcount;
$lthred = ForumThread::getSectionLastThread($sid);
$lposts = 'n/a';
if( isset($lthred) && isset($lthred->creator) ) {
	$ltm = strtotime("now") - strtotime($lthred->ctime);
	if($ltm < 60) $ltm = $ltm.$l_unit_sec;
	else if($ltm < 3600) $ltm = (($ltm - $ltm%60)/60).$l_unit_min;
	else if($ltm < 86400) $ltm = (($ltm - $ltm%3600)/3600).$l_unit_hur;
	else $ltm = (($ltm - $ltm%86400)/86400).$l_unit_day;

	$name = DatabaseUtil::getUserName($lthred->creator);
	$lposts = ( $_SESSION['_language']=='zh' ? $name['lastname'].$name['firstname'] : $name['firstname'].' '.$name['lastname']).'<br>'.$ltm;
}
?>
<tr>
<td class="first"><a class="slink" href="../forum/section.php?sid=<?php echo $sec->getSid()?>&page=1"><?php echo $sec->title?></a><br />
<label><?php echo $sec->description?></label></td>
<td class="second"><?php echo $tcount?></td>
<td class="third"><?php echo $mcount?></td>
<td class="fourth"><?php echo $lposts?></td>
</tr>
<?php } ?></tbody>
</table>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>