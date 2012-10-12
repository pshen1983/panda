<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/DatabaseUtil.php");
	include_once ("../utils/SecurityUtil.php");
	include_once ("../utils/CommonUtil.php");
	
	//============================================= Language ==================================================
	
	if($_SESSION['_language'] == 'en') {
		$l_new_comm = 'New Comment';
		$l_add_comm = 'Add Comment';
	}
	else if($_SESSION['_language'] == 'zh') {
		$l_new_comm = '&#26032;&#30041;&#35328;';
		$l_add_comm = '&#28155;&#21152;';
	}
	
	//=========================================================================================================
	
	if(isset($_GET['type']) && isset($_GET['work_id']) && isset($_GET['sid']) && isset($_SESSION['_project']))
	{
		if($_GET['type'] == 'wp')
			$work = DatabaseUtil::getWorkPackage($_GET['work_id']);
		else
			$work = DatabaseUtil::getWorkItem($_GET['work_id']);
	
		$proj_id = $work['proj_id'];
	
		if($_SESSION['_project']->id == $proj_id)
		{
			$output =
				"";
	
			if($_GET['type'] == 'wp')
				$comments = DatabaseUtil::getWorkPackageComments($_GET['work_id']);
			else
				$comments = DatabaseUtil::getWorkItemComments($_GET['work_id']);
	
			while($comment = mysql_fetch_array($comments, MYSQL_ASSOC))
			{
				$user = DatabaseUtil::getUserObj($comment['creator_id']);
				$name = ($_SESSION['_language'] == 'zh') ? $user->lastname.$user->firstname : CommonUtil::truncate($user->firstname." ".$user->lastname,25);
				$output .= 
					"<div class='per_comment'>
					<div class='per_comment_top'>
					<img align='center' style='border:1px solid white;width:40px;height:40px;' src='".$user->pic."'/>
					<label class='per_comment_header'><span class='per_comment_header_user'>".$name."</span> (<span class='per_comment_header_time'>".$comment['modified']."</span>)</label>
					</div>
					<div class='per_comment_bottom'>
					<div class='per_comment_value'><label>".stripslashes($comment['content'])."</label></div>
					</div>
					</div>";
			}

			$output .=
				'<div class="per_comment">
				<form method="post" enctype="multipart/form-data" action="new_comment.php" name="add_comment_form" id="add_comment_form" accept-charset="UTF-8">
				<input type="hidden" name="comment_type" id="comment_type" value="'.$_GET["type"].'" />
				<input type="hidden" name="work_id" id="work_id" value="'.$_GET["work_id"].'" />
				<input type="hidden" name="work_sid" id="work_sid" value="'.$_GET["sid"].'" />
				<div class="per_comment_top">
				<label class="per_comment_header">'.$l_new_comm.'</label>
				</div>
				<textarea id="comm_content" name="content" class="add_comment_textarea" onkeyup="javascript:enableElement(\'comm_content\', \'add_comm_submit_button\')"></textarea><br>
				<input style="text-align:center;width:125px;" type="submit" value="'.$l_add_comm.'" id="add_comm_submit_button" disabled="true"  class=\'update_submit_button\' onmousedown=\'mousePress("add_comm_submit_button")\' onmouseup=\'mouseRelease("add_comm_submit_button")\' onmouseout=\'mouseRelease("add_comm_submit_button")\' />
				</form>
				</div>';
	
			echo $output;
		}
	}
}
else {
	echo 1;
}
?>