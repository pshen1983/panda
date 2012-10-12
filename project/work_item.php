<?php
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SessionUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if ( (isset($_GET['wi_id']) && isset($_GET['sid'])) || isset($_SESSION['_workitem']) )
{
	if(!isset($_SESSION['_workitem']))
	{
		SessionUtil::selectWorkItem( $_SESSION['_userId'], $_GET['wi_id'], $_GET['sid'] );
	}
	else 
	{
		if(isset($_GET['wi_id']) && isset($_GET['sid']))
		{
			$workitem = $_SESSION['_workitem'];
			if ($workitem->id != $_GET['wi_id'] || $workitem->s_id != $_GET['sid'])
			{
				SessionUtil::selectWorkItem( $_SESSION['_userId'], $_GET['wi_id'], $_GET['sid'] );
			}
			else
			{
				$wi_date = DatabaseUtil::getWorkItemDate($workitem->id);
				if ($wi_date != $workitem->lastupdated_time)
				{
					SessionUtil::selectWorkItem( $_SESSION['_userId'], $workitem->id, $workitem->s_id );
				}
			}
		}
		else
		{
			$workitem = $_SESSION['_workitem'];
			$wi_date = DatabaseUtil::getWorkItemDate($workitem->id);
			if ($wi_date != $workitem->lastupdated_time)
			{
				SessionUtil::selectWorkItem( $_SESSION['_userId'], $workitem->id, $workitem->s_id );
			}
		}
	}

	$wi = $_SESSION['_workitem'];
	$userC = DatabaseUtil::getUser($wi->creator_id);
	$userW = DatabaseUtil::getUser($wi->owner_id);
}
else {
	header( 'Location: ../home/index.php' );
	exit;
}

include_once ("language/l_work_item.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" href="../css/AutoComplete.css" media="screen" type="text/css" /> 
<link rel="stylesheet" href="../css/calendar.css" type="text/css" />
<link rel="stylesheet" href="../css/table.css" type="text/css" />
<link rel='stylesheet' type='text/css' href='css/work_comments.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='css/project_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/jquery.contextMenu.css' />
<style type="text/css">pre{margin-top:5px}</style>
<!-- link calendar files  -->
<script language="JavaScript" src="../js/calendar_us.js"></script>
<script language="JavaScript" src="../js/jquery.js"></script>
<script type='text/javascript' src="../js/jquery-ext.js"></script>
<script language="JavaScript" src="../js/common.js"></script>
<script language="JavaScript">
$(document).ready(function() {
$("#priority").change(function() { $("#img_priority").attr("src", "../image/priority/"+$(this).val()+".gif"); });
addProjectActionMenu();
adjustHeight();
setInterval( longpollLeftNav, 5000 );
});
</script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once '../common/header_2.inc.php';?>
<div id="page_body">
<div id="left_nav"><?php include_once '../common/left_nav.inc.php';?></div>
<div id="right_nav"><?php include_once '../common/right_nav.inc.php';?></div>
<div id="main_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div id="page_title"><?php echo $l_wi_label.' '.(str_pad($_SESSION['_workitem']->pw_id, 4, "0", STR_PAD_LEFT)); ?></div>
<div id="project_info">
<?php
	include_once 'update_workitem.inc.php';
?>
<div class="page_saperator" style="margin-top:10px;"></div>
<div class="work_comments">
<div class="list_of_comments_header"><a class="show_hide_comment" href="javascript:showHideDiv('comment_details', 'wi_comments')"><img id='comment_details' class='double_arrow' src='../image/common/double_arrow_up.png'></img><?php echo $l_list_comm?> <span style="position:relative;left:5px;color:#333;font-size:.8em;">(<?php echo DatabaseUtil::getWorkItemCommentCount($_SESSION['_workitem']->id);?>)</span></a></div>
<div id="wi_comments" class="comment_list">
<?php 
	$output ="";

	$comments = DatabaseUtil::getWorkItemComments($wi->id);

	while($comment = mysql_fetch_array($comments, MYSQL_ASSOC))
	{
		$user = DatabaseUtil::getUserObj($comment['creator_id']);
		$name = ($_SESSION['_language'] == 'zh') ? $user->lastname.$user->firstname : CommonUtil::truncate($user->firstname." ".$user->lastname,25);
		$output .= 
			"<div class='per_comment'>
			<div class='per_comment_top'>
			<img align='center' style='border:1px solid white;width:40px;height:40px;' src='".$user->pic."'/>
			<label class='per_comment_header'><span class='per_comment_header_user'>".$name."</span> ( <span class='per_comment_header_time'>".$comment['modified']."</span> )</label>
			</div>
			<div class='per_comment_bottom'>
			<div class='per_comment_value'>".stripslashes($comment['content'])."</div>
			</div>
			</div>";
	}

	$output .=
		'<div class="new_comment">
		<form method="post" enctype="multipart/form-data" action="new_comment.php" name="add_comment_form" id="add_comment_form" accept-charset="UTF-8">
		<input type="hidden" name="comment_type" id="comment_type" value="wi" />
		<input type="hidden" name="work_id" id="work_id" value="'.$wi->id.'" />
		<input type="hidden" name="work_sid" id="work_sid" value="'.$wi->s_id.'" />
		<div class="new_comment_top">
		<label class="per_comment_header">'.$l_new_comm.'</label>
		</div>
		<textarea id="comm_content" name="content" class="add_comment_textarea" onkeyup="javascript:enableElement(\'comm_content\', \'add_comm_submit_button\')"></textarea><br>
		<input style="text-align:center;width:125px;" type="submit" value="'.$l_add_comm.'" id="add_comm_submit_button" disabled="true"  class=\'update_submit_button\' onmousedown=\'mousePress("add_comm_submit_button")\' onmouseup=\'mouseRelease("add_comm_submit_button")\' onmouseout=\'mouseRelease("add_comm_submit_button")\' />
		</form>
		</div>';

	echo $output;
?>
</div>
</div>
</div>
<?php include_once '../project/project_document.inc.php';?>	
</div></div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>