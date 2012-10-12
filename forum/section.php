<?php
include_once ("../_obj/ForumSection.inc.php");
include_once ("../_obj/ForumThread.inc.php");
include_once ("../_obj/ForumMessage.inc.php");
include_once ("../common/Objects.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");

if( !isset($_GET['sid']) || !is_numeric($_GET['sid']) || 
	!isset($_GET['page']) || !is_numeric($_GET['page']) )
{
    header( 'Location: ../forum/index.php' ) ;
    exit;
}

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

include_once ("language/l_section.inc.php");

$sec = ForumSection::getSectionBySid($_GET['sid']);

$size = 20;
$index = ($_GET['page']-1)*$size;
$tcount = ForumThread::getSectionThreadCount($_GET['sid']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/proj_layout.css" />
<link rel="stylesheet" type="text/css" href="../css/forum.css" />
<script type="text/javascript" src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once isset($_SESSION['_userId']) ? '../common/header_2.inc.php' : '../common/header_1.inc.php';?>
<div id="page_body">
<?php if( isset($_SESSION['_userId']) ) { include_once '../common/path_nav.inc.php'; ?>
<div id="top_link_saperator"></div>
<?php }else {?>
<div style="height:1px;"></div>
<?php } ?>
<div id="forumtitle"><h1><?php echo $l_section?></h1></div>
<div id="flink">
<div style="margin-bottom:15px;text-align:right;"><a class="newthr" href="../forum/new.php?id=<?php echo $_GET['sid']."&sid=".session_id()?>"><?php echo $l_forum_new?></a></div>
<div class="repdiv"><?php echo CommonUtil::getPageLink(($tcount), $size, '../forum/section.php?sid='.$_GET['sid'].'&page=', $_GET['page'])?></div>
<a class="f" href="../forum/index.php"><?php echo $l_fhome?></a><img class="imgsep" src="../image/link_sep.png" />
<label><?php echo $sec->title?></label>
</div>
<table id="threadtable" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th class="zero"></th>
<th class="first"><?php echo $l_header?></th>
<th class="second"><?php echo $l_topic?></th>
<th class="third"><?php echo $l_posts?></th>
<th class="fourth"><?php echo $l_lpost?></th>
</tr>
</thead>
<tbody><?php 
$threads = ForumThread::getSectionThreads($sec->getSid(), $index, $size);
foreach( $threads as $thr ) { 
$tid = $thr->getId();
$vcount = $thr->vcount;
$mcount = ForumMessage::getThreadMessageCount($tid);
if ($mcount > 0) $mcount--;
$now = strtotime("now");
$utm = $now - strtotime($thr->ltime);
if($utm < 60) $utm = $utm.$l_unit_sec;
else if($utm < 3600) $utm = (($utm - $utm%60)/60).$l_unit_min;
else if($utm < 86400) $utm = (($utm - $utm%3600)/3600).$l_unit_hur;
else $utm = (($utm - $utm%86400)/86400).$l_unit_day;
$ctm = $now - strtotime($thr->ctime);
if($ctm < 60) $ctm = $ctm.$l_unit_sec;
else if($ctm < 3600) $ctm = (($ctm - $ctm%60)/60).$l_unit_min;
else if($ctm < 86400) $ctm = (($ctm - $ctm%3600)/3600).$l_unit_hur;
else $ctm = (($ctm - $ctm%86400)/86400).$l_unit_day;
if( $thr->ltime==$thr->ctime )
{
	$lposts = 'n/a';
}
else {
	$name = DatabaseUtil::getUserName($thr->lrep);
	$lposts = ( $_SESSION['_language']=='zh' ? $name['lastname'].$name['firstname'] : $name['firstname'].' '.$name['lastname']).'<br>'.$utm;
}
$name = DatabaseUtil::getUserName($thr->creator);
$create = ( $_SESSION['_language']=='zh' ? $name['lastname'].$name['firstname'] : $name['firstname'].' '.$name['lastname']).'<br>'.$ctm;
?>
<tr>
<td class="zero"><img src="../image/<?php echo ($thr->top=='Y' ? "info.png" : "thread.png")?>" /></td>
<td class="first"><a class="slink" href="../forum/thread.php?thread=<?php echo $thr->getId()?>&page=1"><?php echo $thr->title?></a></td>
<td class="second"><?php echo $mcount.'/'.$vcount?></td>
<td class="third"><?php echo $create?></td>
<td class="fourth"><?php echo $lposts?></td>
</tr>
<?php } ?></tbody>
</table>
<div id="flink">
<div class="repdiv"><?php echo CommonUtil::getPageLink(($tcount), $size, '../forum/section.php?sid='.$_GET['sid'].'&page=', $_GET['page'])?></div>
<a class="f" href="../forum/index.php"><?php echo $l_fhome?></a><img class="imgsep" src="../image/link_sep.png" />
<label><?php echo $sec->title?></label>
<div style="margin-top:15px;text-align:right;"><a class="newthr" href="../forum/new.php?id=<?php echo $_GET['sid']."&sid=".session_id()?>"><?php echo $l_forum_new?></a></div>
</div>
<div style="height:60px"></div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>