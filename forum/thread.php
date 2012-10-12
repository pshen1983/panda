<?php
include_once ("../_obj/ForumSection.inc.php");
include_once ("../_obj/ForumThread.inc.php");
include_once ("../_obj/ForumMessage.inc.php");
include_once ("../common/Objects.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

include_once ("language/l_thread.inc.php");

if( !isset($_GET['thread']) || !ForumThread::threadExist($_GET['thread']) || 
	!isset($_GET['page']) || !is_numeric($_GET['page']) )
{
	header( 'Location: ../forum/index.php' );
	exit;
}

$thr = ForumThread::getThread($_GET['thread']);

$result = 0;
if( isset($_POST['bnsub']) && $_POST['bnsub']==1 )
{
	if( isset($_POST['reply']) && !empty($_POST['reply']) ) 
	{
		$repid = (isset($_POST['repid']) && !empty($_POST['repid'])) ? $_POST['repid'] : null;
		$reply = trim($_POST['reply']);
		$reply = str_replace("<", "&lt;", $reply);
		$reply = str_replace(">", "&gt;", $reply);
		if( ForumMessage::addMessage($thr->sid, $_GET['thread'], $repid, $reply) )
		{
			$thr->lrep = $_SESSION['_userId'];
			$thr->updateLastReply();
			header( 'Location: ../forum/thread.php?thread='.$_GET['thread'].'&page=1' );
			exit;
		}
	}
	else $result = 1;
}

if( !isset($_SESSION['thread'.$_GET['thread']]) )
{
	$_SESSION['thread'.$_GET['thread']] = 1;
	ForumThread::viewThread($_GET['thread']);
	$thr->vcount = $thr->vcount + 1;
}

$size = 10;
$index = ($_GET['page']-1)*$size;
$secname = ForumSection::getSectionName($thr->sid);
$messcont = ForumMessage::getThreadMessageCount($thr->getId())-1;
$messages = ForumMessage::getThreadMessages($thr->getId(), $index, $size);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/forum.css' />
<script type='text/javascript' src="../js/common.js"></script>
<script type='text/javascript' src="../js/jquery.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
$(".rlink").click(function(e) {
    e.preventDefault();
<?php if( isset($_SESSION['_userId']) ) {?>
    var name = $(this).attr('href');
    var rmsg = "<?php echo $l_rmsg?>";
	$("textarea#reply").focus().val(rmsg+name+":\n");
<?php } else { ?>
	var new_position = $('#repor').offset();
	window.scrollTo(new_position.left,new_position.top);
<?php } ?>
});
});
</script>
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
<div id="forumtitle"><h1><?php echo $l_thread?></h1></div>
<div id="flink">
<div class="repdiv"><?php echo CommonUtil::getPageLink(($messcont+1), $size, '../forum/thread.php?thread='.$_GET['thread'].'&page=', $_GET['page'])?></div>
<a class="f" href="../forum/index.php"><?php echo $l_fhome?></a><img class="imgsep" src="../image/link_sep.png" />
<a class="f" href="../forum/section.php?page=1&sid=<?php echo $thr->sid?>"><?php echo $secname?></a><img class="imgsep" src="../image/link_sep.png" />
<label><?php echo $thr->title?></label>
</div>
<table class="messagetable" cellpadding="0" cellspacing="1">
<thead>
<tr>
<th class="first"><?php echo $l_reply.'<span class="black">'.$messcont.'</span> | '.$l_view.'<span class="black">'.$thr->vcount.'</span>'?></th>
<th class="second"><?php echo '['.$secname.'] '.$thr->title?></th>
</tr>
</thead>
<tbody>
<?php foreach( $messages as $mess ) {
$uid = $mess->getCreator();
$user = DatabaseUtil::getUserObj($uid);
$name = ($_SESSION['_language']=='zh' ? $user->lastname.$user->firstname : $user->firstname.' '.$user->lastname);
$nlnk = '<a href="../search/user_details.php?p1='.session_id().'&p2='.(3*$uid-1).'">'.$name.'</a>';
$ctm = strtotime("now") - strtotime($mess->getCtime());
if($ctm < 60) $ctm = $ctm.$l_unit_sec;
else if($ctm < 3600) $ctm = (($ctm - $ctm%60)/60).$l_unit_min;
else if($ctm < 86400) $ctm = (($ctm - $ctm%3600)/3600).$l_unit_hur;
else $ctm = (($ctm - $ctm%86400)/86400).$l_unit_day;
?>
<tr>
<td class="first"><div class="tdbody">
<img class="proimg" src="<?php echo $user->pic?>" />
<div class="tdinfo"><?php echo $nlnk;?></div>
</div></td>
<td class="second"><div class="tdbody">
<div class="messhead">
<div class="repdiv">
<label>#<?php echo ++$index;?></label>
<a class="rlink" href="<?php echo $name.'(#'.$index.')'?>"><?php echo $l_rep_link?></a>
<!-- a class="qlink"><?php echo $l_quo_link?></a-->
</div>
<label><?php echo $l_post.$ctm?></label></div>
<div class="messbody"><pre><?php echo $mess->body?></pre></div>
</div></td>
</tr>
<tr></tr>
<?php } ?>
</tbody>
</table>
<div id="flink"><div class="repdiv">
<?php echo CommonUtil::getPageLink(($messcont+1), $size, '../forum/thread.php?thread='.$_GET['thread'].'&page=', $_GET['page'])?>
</div></div><div style="height:50px;"></div>
<a id="repor"></a>
<?php if ( isset($_SESSION['_userId']) ) {?>
<table class="messagetable" cellpadding="0" cellspacing="1">
<?php 
$user = $_SESSION['_loginUser'];
$name = ($_SESSION['_language']=='zh' ? $user->lastname.$user->firstname : $user->firstname.' '.$user->lastname);
?>
<tr>
<td class="first"><div class="tdbody">
<img class="proimg" src="<?php echo $user->pic?>" />
<div class="tdinfo"><?php echo $name;?></div>
</div></td>
<td class="second">
<form id="reply" method="post" enctype="multipart/form-data" action="../forum/thread.php?thread=<?php echo $_GET['thread']?>&page=1" accept-charset="UTF-8">
<div><textarea id="reply" name="reply"></textarea></div>
<input type="hidden" name="bnsub" value="1" />
<input type="hidden" id="repid" name="repid" value="" />
<div><input class="submitbn" type="submit" value="<?php echo $l_submit?>" /></div>
</form>
</td>
</tr>
</table>
<?php } else {?>
<a class="logrep" href="../default/login.php?page=<?php echo str_replace("&", "%%", $_SERVER['REQUEST_URI'])?>"><?php echo $l_log_rep?></a>
<?php } ?>
<div style="height:50px;"></div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>