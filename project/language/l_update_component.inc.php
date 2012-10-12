<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_uc_showhide = ' Information';
	$l_uc_title = 'Component Name : ';
	$l_uc_owner = 'Component Owner : ';
	$l_uc_status = 'Status : ';
	$l_uc_deadline = 'Deadline : ';
	$l_uc_milestone = 'Is a Project Milestone : ';
	$l_uc_yes = 'Yes';
	$l_uc_no = 'No';
	$l_uc_descript = 'Description';
	$l_uc_submit = 'Update';
	$l_double_click = 'Double click a day to create a workitem';

	$l_suc_0 = '- Project component has been saved successfully.';
	$l_err_1 = '- System is temporarily busy, please try again later.';
	$l_err_2 = '- Project Component deadline must be after today.';
	$l_err_3 = '- You do NOT have enough priviliage to update this component.';
	$l_err_4 = '- The owner you specified is NOT a member of this project.';
	$l_err_5 = '- The project component you are trying to change has been updated, please refres and try again.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_uc_showhide = ' 信息';
	$l_uc_title = '项目组名称：';
	$l_uc_owner = '&#39033;&#30446;&#32452;&#25152;&#26377;&#32773;：';
	$l_uc_status = '&#31867;&#21035;：';
	$l_uc_deadline = '&#25130;&#27490;&#26085;&#26399;：';
	$l_uc_milestone = '&#39033;&#30446;&#37324;&#31243;&#30865;：';
	$l_uc_yes = '&#26159;';
	$l_uc_no = '&#19981;&#26159;';
	$l_uc_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_uc_submit = '&#26356;&#26032;';
	$l_double_click = '双击日期新建工作项';
	
	$l_suc_0 = '&#8212; &#39033;&#30446;&#32452;&#25104;&#21151;&#26356;&#26032;&#12290;';
	$l_err_1 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_2 = '&#8212; &#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290;';
	$l_err_3 = '&#8212; &#24744;&#27809;&#26377;&#36275;&#22815;&#26435;&#38480;&#26356;&#25913;&#27492;&#39033;&#30446;&#32452;&#12290;';
	$l_err_4 = '&#8212; &#39033;&#30446;&#32452;&#25152;&#26377;&#32773;&#19981;&#26159;&#26412;&#39033;&#30446;&#25104;&#21592;&#12290;';
	$l_err_5 = '&#8212; &#39033;&#30446;&#32452;&#24050;&#34987;&#26356;&#25913;&#65292;&#35831;&#21047;&#26032;&#21518;&#20877;&#35797;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}
?>