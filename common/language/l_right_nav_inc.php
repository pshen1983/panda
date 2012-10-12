<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_new_proj = 'New Project';
	$l_new_comp = 'New Component';
	$l_new_wp = 'New Workpackage';
	$l_new_wi = 'New Workitem';
	$l_link_wp = 'Link to a Workpackage';

	$l_un_follow = 'Unfollow Workitem';
	$l_follow = 'Follow Workitem';
	$l_prclick = 'Right click to view more options';
	$l_pquit_confirm = 'Are you sure you want to quit this project?';
	$l_follow_msg = 'If you follow this workitem, you will receive a message when there is an update';

	$l_in_pro_proj = 'My Open Projects';
	$l_goto_p = 'Go to Project';
	$l_quit_p = 'Quit Project';
	$l_comple_proj = 'Complete Projects';
	$l_comp_inproj = 'Open Components';
	$l_comple_comp = 'Closed Components';

	$l_0_proj = '<div class="none_found">0 Project found</div>';
	$l_0_comp = '<div class="none_found">0 Component found</div>';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_new_proj = '新建项目';
	$l_new_comp = '&#26032;&#39033;&#30446;&#32452;';
	$l_new_wp = '&#26032;&#24314;&#24037;&#20316;&#21253;';
	$l_new_wi = '&#26032;&#24037;&#20316;&#39033;';
	$l_link_wp = '&#38142;&#25509;&#21040;&#19968;&#20010;&#24037;&#20316;&#21253;';

	$l_un_follow = '&#19981;&#20877;&#20851;&#27880;&#27492;&#24037;&#20316;&#39033;';
	$l_follow = '&#20851;&#27880;&#27492;&#24037;&#20316;&#39033;';
	$l_prclick = '点击右键展示更多选项';
	$l_pquit_confirm = '确定退出此项目？';
	$l_follow_msg = '如果你关注此工作项，当其被更新时你将收到站内信提醒';

	$l_in_pro_proj = '我的项目';
	$l_goto_p = '前往项目';
	$l_quit_p = '退出项目';
	$l_comple_proj = '完成的项目';
	$l_comp_inproj = '项目组';
	$l_comple_comp = '完成的项目组';
	
	$l_0_proj = '<div class="none_found">&#27809;&#26377;&#39033;&#30446;</div>';
	$l_0_comp = '<div class="none_found">&#27809;&#26377;&#39033;&#30446;&#32452;</div>';
}
?>