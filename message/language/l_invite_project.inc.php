<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_title = 'Project Invitation | ProjNote';
	$l_back_prof = 'Back to Invitations Page';
	$l_header = 'Invite friends to your project:';
	$l_select_proj = 'Select a Project';
	$l_user_email = 'Friend email: ';
	$l_more_btn = 'Invite More Friends';
	$l_message = 'Invitation Message';
	$l_none_proj = ' (You are NOT a manager or owner of any Non-complete project)';
	$l_submit = 'Submit';
	$l_suc_0 = 'Invitation has been sent';
	$l_err_1 = 'System is temporarily busy';
	$l_err_2 = 'Already a project member';
	$l_err_3_1 = 'Email not found, ';
	$l_err_3_2 = 'invite this friend';
	$l_err_4 = 'Incorrect email format.';
	$l_err_6 = 'Already invited this friend';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_title = '&#39033;&#30446;&#36992;&#35831; | myProjnot';
	$l_back_prof = '&#36820;&#22238;&#25910;&#21457;&#36992;&#35831;&#39029;';
	$l_header = '邀请朋友加入你的项目：';
	$l_select_proj = '&#36873;&#25321;&#19968;&#20010;&#39033;&#30446;';
	$l_user_email = '朋友 Email：';
	$l_more_btn = '邀请更多朋友';
	$l_message = '&#36992;&#35831;&#20869;&#23481;';
	$l_none_proj = ' &#65288;&#24744;&#27809;&#26377;&#25285;&#20219;&#24635;&#30417;&#25110;&#32463;&#29702;&#30340;&#26410;&#23436;&#25104;&#39033;&#30446;&#65289;';
	$l_submit = '&#30830;&#23450;';
	$l_suc_0 = '邀请成功发送';
	$l_err_1 = '系统忙碌，请稍候再试';
	$l_err_2 = '用户已经是这个项目的成员';
	$l_err_3_1 = '&#29992;&#25143;&#19981;&#23384;&#22312;&#65292;';
	$l_err_3_2 = '&#36992;&#35831;&#22909;&#21451;&#21152;&#20837;';
	$l_err_4 = '用户（Email）格式错误';
	$l_err_6 = '项目邀请已经发送';
}
?>