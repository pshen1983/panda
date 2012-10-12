<?php
include_once ("../_obj/ForumSection.inc.php");
include_once ("../_obj/ForumThread.inc.php");
include_once ("../_obj/ForumMessage.inc.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( !isset($_GET['id']) || !is_numeric($_GET['id']) ) {
	header( 'Location: ../forum/index.php' );
	exit;
}
else if( !isset($_GET['sid']) || $_GET['sid']!=session_id() ) {
	header( 'Location: ../forum/section.php?page=1&sid='.$_GET['id'] );
	exit;
}

$result = 0;
if( isset($_POST['bnsub']) && $_POST['bnsub']==1 )
{
	if( isset($_POST['subj']) && !empty($_POST['subj']) &&
		isset($_POST['cont']) && !empty($_POST['cont']) ) 
	{
		$subj = trim($_POST['subj']);
		$subj = str_replace("<", "&lt;", $subj);
		$subj = str_replace(">", "&gt;", $subj);

		if( strlen($subj)<=40 )
		{
			$cont = trim($_POST['cont']);
			$cont = str_replace("<", "&lt;", $cont);
			$cont = str_replace(">", "&gt;", $cont);
	
			$tid = ForumThread::addThread($_GET['id'], $subj );
			if( $tid != -1 )
			{
				if( !ForumMessage::addMessage($_GET['id'], $tid, null, $cont) )
				{
					$result = 3;
					ForumThread::deleteThread($tid);
				}
				else {
					header( 'Location: ../forum/section.php?page=1&sid='.$_GET['id'] );
					exit;
				}
			}
			else $result = 2;
		}
		else $result = 3;
	}
	else $result = 1;
}

$sec = ForumSection::getSectionBySid($_GET['id']);

include_once ("language/l_new.inc.php");
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
$("#canbn").click(function(e){ 
	window.location = '../forum/section.php?page=1&sid=<?php echo $_GET['id'];?>'; 
});
$('#subj').each(function(){
	$(this).keydown(function(){	if($(this).val().length>40) $(this).val($(this).val().substring(0, 40)); $('#wcount').text(40-$(this).val().length); });
	$(this).keyup(function(){ if($(this).val().length>40) $(this).val($(this).val().substring(0, 40)); $('#wcount').text(40-$(this).val().length); });
	$(this).blur(function(){ if($(this).val().length>40) $(this).val($(this).val().substring(0, 40)); $('#wcount').text(40-$(this).val().length); });
});
});
</script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div id="forumtitle"><h1><?php echo $l_top_new?></h1></div>
<div id="flink">
<a class="f" href="../forum/index.php"><?php echo $l_fhome?></a><img class="imgsep" src="../image/link_sep.png" />
<a class="f" href="../forum/section.php?page=1&sid=<?php echo $_GET['id']?>"><?php echo $sec->title?></a><img class="imgsep" src="../image/link_sep.png" />
<?php echo $l_top_new?>
</div>
<form method="post" enctype="multipart/form-data" action="new.php?id=<?php echo $_GET['id']?>&sid=<?php echo session_id()?>" accept-charset="UTF-8" >
<table id="ntoptable" cellpadding="0" cellspacing="1">
<thead>
<tr><th class="first" colspan="2"><?php echo $l_top_new?></th></tr>
</thead>
<tbody>
<tr>
<td class="first right"><label <?php if(isset($_POST['subj'])&&empty($_POST['subj'])) echo 'class="empty"';?>><?php echo $l_topic?></label></td>
<td><input class="content" type="text" name="subj" id="subj" /><span id="wcount">40</span><?php echo $l_top_size?></td>
</tr>
<tr>
<td class="first right"><div class="contheight"><label <?php if(isset($_POST['cont'])&&empty($_POST['cont'])) echo 'class="empty"';?>><?php echo $l_content?></label></div></td>
<td><textarea class="content contheight" name="cont" id="cont"></textarea></td>
</tr>
<tr>
<td class="middle" colspan="2">
<input type="hidden" name="bnsub" value="1" />
<input class="submitbn margin1050" type="submit" value="<?php echo $l_submit?>" />
<input class="submitbn margin1050" type="button" value="<?php echo $l_cancel?>" id="canbn" />
</td>
</tr>
</tbody>
</table>
</form>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>