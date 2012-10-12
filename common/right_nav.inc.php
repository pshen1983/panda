<?php

include_once ("language/l_right_nav_inc.php");

$isManager = SecurityUtil::canUpdateProjectInfo();
if(!isset($_GET['right_nav_creat'])) {
	echo '<div style="height:21px"></div>';
	if(isset($_SESSION['_project'])) {
//		if(!isset($_SESSION['_workpackage']) && !isset($_SESSION['_workitem']) && DatabaseUtil::isProjectLeader($_SESSION['_userId'], $_SESSION['_project']->id))
//			echo '<div class="newobj" onClick="window.location=\'../project/new_workpackage.php\'">'.$l_new_wp.'</div>';
		if(!isset($_SESSION['_workitem']))
			echo '<div class="newobj" onClick="window.location=\'../project/new_workitem.php\'">'.$l_new_wi.'</div><div style="height:14px"></div>';
		if(isset($_SESSION['_workitem'])) {
			echo '<div class="right_nav_work_itme_link">';
			if(DatabaseUtil::isUserSubscribedToWorkitem($_SESSION['_workitem']->id, $_SESSION['_userId']))
				echo "<a id='sub_link' title='".$l_follow_msg."' class='right_nav_work_itme_link_a' href=\"javascript:removeUserSub('sub_link', '".(3*$_SESSION['_workitem']->id+7)."')\">".$l_un_follow."</a>";
			else 
				echo "<a id='sub_link' title='".$l_follow_msg."' class='right_nav_work_itme_link_a' href=\"javascript:addUserSub('sub_link', '".(3*$_SESSION['_workitem']->id+7)."')\">".$l_follow."</a>";
			echo '</div>';
		}
	}
}
else { echo '<div style="height:16px"></div>'; }
?>
<script type="text/javascript">function addProjectActionMenu(){addProjectRightMenu('<?php echo $l_pquit_confirm;?>');}</script>
<div id="right_hand_nav_incom_proj_sec" class="right_hand_nav_proj_sec">
<div class="rhand_sec_header"><a class="right_nav_proj_link" href="javascript:showHideDiv('double_arrow_incom', 'list_of_incom_proj')"><img id="double_arrow_incom" class="double_arrow" src="../image/common/double_arrow_up.png"></img> <?php echo $l_in_pro_proj?></a></div>
<div id="top_link_saperator"></div>
<div id="list_of_incom_proj">
<?php
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SessionUtil.php");

if(isset($_SESSION)) {
	$hasProj = false;

	if(!isset($_SESSION['_oProjList'])) SessionUtil::getUserOpenProjList();

	$ind = 0;
	foreach($_SESSION['_oProjList'] as $pid=>$proj)
	{
		if( !$hasProj ) $hasProj = true;
		if( isset($_SESSION['_project']) && $_SESSION['_project']->id==$proj['p_id'] ) echo '<img class="indicator" src="../image/collapse.png" />';
		echo "<div class='right_nav_item".($ind++%2!=0 ? ' rightnavalter':'')."'><a id='plink_".$proj['p_id']."_".$proj['s_id']."' class='right_hand_nav_proj_link projlink' href=../project/index.php?p_id=". $proj['p_id'] ."&sid=". $proj['s_id'] .' title="'.$l_prclick.'">'. CommonUtil::truncate($proj['title'], 16) ."</a></div>"; 
	}

	if (!$hasProj) echo "<div class='right_nav_item'>".$l_0_proj."</div>";
}
?>
</div>
</div>
<ul id="pMenu" class="contextMenu">
<li class="goto"><a href="#pgoto"><?php echo $l_goto_p?></a></li>
<li class="quit separator"><a href="#pquit"><?php echo $l_quit_p?></a></li>
</ul>
<?php if( !isset($_SESSION['_cProjExist']) ) $_SESSION['_cProjExist'] = DatabaseUtil::hasCompeleteProject($_SESSION['_userId']);
if ( $_SESSION['_cProjExist'] ) {?>
<div id="right_hand_nav_com_proj_sec" class="right_hand_nav_proj_sec">
<div class="rhand_sec_header"><a class="right_nav_proj_link" href="javascript:showHideComplete('double_arrow_com', 'list_of_com_proj', '../common/completeProjects.php')"><img id="double_arrow_com" class="double_arrow" src="../image/common/double_arrow_down.png"></img> <?php echo $l_comple_proj?></a></div>
<div id="top_link_saperator"></div>
<div id="list_of_com_proj" class="list_of_incomplete"></div>
</div>
<?php }
if(!isset($_SESSION['_project']))
	echo '<div class="newobj" style="margin-top:10px;" onClick="window.location=\'../project/new_project.php\'">'.$l_new_proj.'</div>';

if(isset($_SESSION['_project'])) {
if( !isset($_GET['right_nav_creat']) && !isset($_SESSION['_component']) && 
	!isset($_SESSION['_workpackage']) && !isset($_SESSION['_workitem']) && $isManager )
	echo '<div style="height:10px"></div><div class="newobj" onClick="window.location=\'../project/new_component.php\'">'.$l_new_comp.'</div>';
else echo '<div style="height:11px"></div>';

if( !isset($_SESSION['_compExist'][$_SESSION['_project']->id]) )
	$_SESSION['_compExist'][$_SESSION['_project']->id] = DatabaseUtil::hasComponent($_SESSION['_project']->id);
if( $isManager || $_SESSION['_compExist'][$_SESSION['_project']->id] ) {
?>
<div id="right_hand_nav_comp_sec" class="right_hand_nav_proj_sec">
<div class="rhand_sec_header"><a class="right_nav_proj_link" href="javascript:showHideDiv('double_arrow_comp', 'list_of_comp')"><img id="double_arrow_comp" class="double_arrow" src="../image/common/double_arrow_up.png"></img> <?php echo $l_comp_inproj?></a></div>
<div id="top_link_saperator"></div>
<div id="list_of_comp">
<?php
	if(isset($_SESSION)) {
		$hasComp = false;
		$components = DatabaseUtil::getNoneCompleteComponent($_SESSION['_project']->id);

		$ind=0;
		while($comp = mysql_fetch_array($components, MYSQL_ASSOC))
		{
			if (!$hasComp) $hasComp = true;
			if( isset($_SESSION['_component']) && $_SESSION['_component']->id==$comp['id'] ) echo '<img class="indicator" src="../image/collapse.png" />';
			echo "<div class='right_nav_item".($ind++%2!=0 ? ' rightnavalter':'')."'><a class='right_hand_nav_proj_link' href=../project/project_component.php?c_id=". $comp['id'] ."&sid=". $comp['s_id'] .' title="'.str_replace('"', '&quot;', $comp['title']).'">'. CommonUtil::truncate($comp['title'], 16) ."</a></div>"; 
		}

		if (!$hasComp) echo "<div class='right_nav_item'>".$l_0_comp."</div>";
	}
?>
</div>
</div>
<?php 
if( !isset($_SESSION['_cCompExist'][$_SESSION['_project']->id]) )
	$_SESSION['_cCompExist'][$_SESSION['_project']->id] = DatabaseUtil::hasCompeleteComponent($_SESSION['_project']->id);
if( $_SESSION['_cCompExist'][$_SESSION['_project']->id] ) {?>
<div id="right_hand_nav_com_comp_sec" class="right_hand_nav_proj_sec">
<div class="rhand_sec_header"><a class="right_nav_proj_link" href="javascript:showHideComplete('double_arrow_com2', 'list_of_com_comp', '../common/getCompleteComponent.inc.php?pid=<?php echo $_SESSION['_project']->id?>')"><img id="double_arrow_com2" class="double_arrow" src="../image/common/double_arrow_down.png"></img> <?php echo $l_comple_comp?></a></div>
<div id="top_link_saperator"></div>
<div id="list_of_com_comp" class="list_of_incomplete"></div>
</div>
<?php }?>
<?php } }?>