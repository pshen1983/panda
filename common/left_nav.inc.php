<style type="text/css">
a.left_nav_name{color:#184D94;font-family:tahoma;font-weight:bold;}
a.left_nav_name:link{text-decoration:none;}
a.left_nav_name:hover{text-decoration:underline;}
a.profile{text-decoration:none;color:blue;}
a.profile:hover{text-decoration:underline;}
a.highlight{color:#DB0050;}
a.highlight:hover{color:#DB0050;text-shadow: 0 1px 1px #fff;}
a.normal{color:blue;}
label.wel{color:#184D94;font-size:.7em;margin-left:0px;font-weight:bold;}
img.lnavo{vertical-align:text-top;margin-right:3px;border:0 none;}
</style>
<script language="JavaScript" src="../js/common.js"></script>
<div style="text-align:left;margin-top:5px;margin-left:5px;height:80px;">
<img style="width:65px;height:65px;margin-right:5px;border-top:1px solid #DDD;border-left:1px solid #DDD;border-bottom:2px solid #DDD;border-right:2px solid #DDD;" src="<?php echo $_SESSION['_loginUser']->pic?>" align="left" /><br>
<?php 
include_once ("../common/Objects.php");

if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['_loginUser']))
{
	header( 'Location: ../default/login.php' );
	exit;
}

include_once ("language/l_left_nav.inc.php");

$invitations = DatabaseUtil::countUserInvitations($_SESSION['_loginUser']->login_email);
$messages = DatabaseUtil::countUnreadMessages($_SESSION['_userId']);
$notes = DatabaseUtil::countActiveNotes($_SESSION['_userId']);

$user = $_SESSION['_loginUser'];
$name = ($_SESSION['_language'] == 'zh') ? $user->lastname.$user->firstname : $user->firstname.' '.$user->lastname;
$welcome = "<label class='wel'>".$name."</label>";

echo $welcome;
?>
<div style="font-size:.7em;margin-top:2px;"><a class="profile" href="../home/profile.php"><?php echo $l_edit_prof?></a></div>
</div>
<div class="left_nav_item" style="margin-bottom:8px;"><a class="left_nav_list_outer" href="../message/invitation.php"><img class="lnavo" src="../image/invite.gif" /><?php echo $l_invitation;?><span id="invi_count" class="right_nav_count_bra"> <?php if($invitations>0){?><span id="icount" class="right_nav_count round_border_4"><?php echo $invitations?></span><?php }?></span></a></div>
<div class="left_nav_item"><a class="left_nav_list_outer" href="../message/index.php"><img class="lnavo" src="../image/message.gif" /><?php echo $l_message; ?><span id="mess_count" class="right_nav_count_bra"> <?php if($messages>0){?><span id="mcount" class="right_nav_count round_border_4"><?php echo $messages?></span><?php }?></span></a></div>
<div class="left_nav_item"><a class="left_nav_list_outer" href="../message/selfnote.php"><img class="lnavo" src="../image/note.gif" /><?php echo $l_self_note;?><span id="note_count" class="right_nav_count_bra"> <?php if($notes>0){?><span id="ncount" class="right_nav_count round_border_4"><?php echo $notes?></span><?php }?></span></a></div>
<?php if(SecurityUtil::canUpdateProjectInfo()) {?>
<div class="left_nav_item"><a class="left_nav_list_outer" href="../admin/index.php"><img class="lnavo" src="../image/statistics.png" /><?php echo $l_proj_admin?></a></div>
<?php }?>
<div class="left_nav_item" style="margin-top:8px;"><a class="left_nav_list_outer highlight" href="../message/invite_friend.php"><img class="lnavo" src="../image/invi_frd.gif" /><?php echo $l_site_invi?></a></div>
<div id="top_link_saperator" style="margin-top:10px"></div>
<div class="left_nav_item"><a id="left_nav_link_0" class="left_nav_list" href="javascript:hideShowNavCoEx('collapse_0', 'left_nav_listholder_0', 'left_nav_link_0')" style="background-color:#CCC;"><img id="collapse_0" class="collapse" src="../image/expand.png"/><?php echo $l_search?></a></div>
<div id="left_nav_listholder_0" class="left_nav_list_ul_show">
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/user.php"><?php echo $l_search_user?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/workitem.php"><?php echo $l_search_wi?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/document.php"><?php echo $l_search_doc?></a></div>
</div>
<div class="left_nav_item"><a id="left_nav_link_1" class="left_nav_list" href="javascript:hideShowNavCoEx('collapse_1', 'left_nav_listholder_1', 'left_nav_link_1')" style="background-color:#CCC;"><img id="collapse_1" class="collapse" src="../image/expand.png"/><?php echo $l_quick_search?></a></div>
<div id="left_nav_listholder_1" class="left_nav_list_ul_show">
<?php if (isset($_SESSION['_project'])) {?>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=proj_member"><?php echo $l_all_mem?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=work_owned_by_me"><?php echo $l_all_owned?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=work_created_by_me"><?php echo $l_all_created?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=work_closed_by_me"><?php echo $l_all_closed?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=my_subscriptions"><?php echo $l_all_my_sub?></a></div>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=last_modified_by_me"><?php echo $l_all_last?></a></div>
<?php }else{?>
<div class="left_nav_item"><a class="left_nav_list_inner" href="../search/basic.php?s=all_my_projects"><?php echo $l_all_my_proj?></a></div>
<?php }?>
</div>
<!-- div class="left_nav_item"><a id="left_nav_link_2" class="left_nav_list" href="javascript:showHideNavCoEx('collapse_2', 'left_nav_listholder_2', 'left_nav_link_2')"><img id="collapse_2" class="collapse" src="../image/collapse.png"/><?php echo $l_documents?></a></div>
<div id="left_nav_listholder_2" class="left_nav_list_ul_hide">
<div class="left_nav_item"><a class="left_nav_list_inner" href="../docs/index.php"><?php echo $l_doc_brow?></a></div>
</div -->