<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_up_showhide = ' Project Information';
	$l_up_title = 'Project Name : ';
	$l_up_create = 'Create on : ';
	$l_up_dir = 'Project Director : ';
	$l_up_pm = 'Project Manager : ';
	$l_up_status = 'Status : ';
	$l_up_deadline = 'Deadline : ';
	$l_up_descript = 'Description';
	$l_up_role = 'Your Role in this Project:';
	$l_up_submit = 'Update';
	$l_double_click = 'Double click a day to create a workitem';

	$l_suc_0 = '- Project has been saved successfully.';
	$l_err_1 = '- System is temporarily busy, please try again later.';
	$l_err_2 = '- Project deadline must be after today.';
	$l_err_3 = '- You do NOT have enough priviliage to update this project.';
	$l_err_4 = '- The project you are trying to change has been updated, please refresh and try again.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_up_showhide = ' 项目信息';
	$l_up_title = '项目名称：';
	$l_up_create = '&#21019;&#24314;&#20110;：';
	$l_up_dir = '&#39033;&#30446;&#24635;&#30417;：';
	$l_up_pm = '&#39033;&#30446;&#32463;&#29702;：';
	$l_up_status = '&#29366;&#24577;：';
	$l_up_deadline = '&#25130;&#27490;&#26085;&#26399;：';
	$l_up_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_up_role = '&#25105;&#30340;&#32844;&#20301;:';
	$l_up_submit = '&#26356;&#26032;';
	$l_double_click = '双击日期新建工作项';

	$l_suc_0 = '&#8212; &#39033;&#30446;&#25104;&#21151;&#26356;&#26032;&#12290;';
	$l_err_1 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_2 = '&#8212; &#39033;&#30446;&#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290;';
	$l_err_3 = '&#8212; &#24744;&#27809;&#26377;&#36275;&#22815;&#26435;&#38480;&#26356;&#26032;&#27492;&#39033;&#30446;&#12290;';
	$l_err_4 = '&#8212; &#39033;&#30446;&#24050;&#25913;&#21160;&#65292;&#35831;&#21047;&#26032;&#21518;&#20877;&#35797;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}
?>