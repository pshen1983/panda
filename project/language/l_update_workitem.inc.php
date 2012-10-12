<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_uwi_summary = 'Summary';
	$l_uwi_owner = 'Workitem Owner';
	$l_uwi_comp = 'Project Component belongs to';
	$l_uwi_wp = 'Workpackage belongs to';
	$l_uwi_create = 'Created by';
	$l_uwi_last = 'Last Updated by';
	$l_uwi_status = 'Status';
	$l_uwi_type = 'Type';
	$l_uwi_priority = 'Priority';
	$l_uwi_deadline = 'Deadline';
	$l_uwi_descript = 'Description';
	$l_uwi_submit = 'Update';

	$l_suc_0 = '- Workitem has been saved successfully.';
	$l_err_1 = '- System is temporarily busy, please try again later.';
	$l_err_2 = '- Workitem summary cannot be empty.';
	$l_err_3 = '- You do NOT have enough privilliage. You can leave a comment to this workitem.';
	$l_err_4 = '- The owner you specified is NOT a member of this project.';
	$l_err_5 = '- The Workitem you are trying to change has been updated, please refres and try again.';
	$l_err_6 = '- Workitem owner cannot be empty. Please select an owner and try again.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_uwi_summary = '&#31616;&#20171;';
	$l_uwi_owner = '&#24037;&#20316;&#39033;&#25152;&#26377;&#32773;';
	$l_uwi_comp = '&#25152;&#23646;&#39033;&#30446;&#32452;';
	$l_uwi_wp = '&#25152;&#23646;&#24037;&#20316;&#21253;';
	$l_uwi_create = '&#26032;&#24314;&#29992;&#25143;';
	$l_uwi_last = '&#26368;&#21518;&#20462;&#25913;&#29992;&#25143;';
	$l_uwi_status = '&#29366;&#24577;';
	$l_uwi_type = '&#31867;&#21035;';
	$l_uwi_priority = '&#20248;&#20808;&#24230;';
	$l_uwi_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_uwi_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_uwi_submit = '更新';

	$l_suc_0 = '&#8212; &#24037;&#20316;&#39033;&#25104;&#21151;&#26356;&#26032;&#12290;';
	$l_err_1 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_2 = '&#8212; &#24037;&#20316;&#39033;&#31616;&#20171;&#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_err_3 = '— 没有足够权限 更改此工作项，你可以在此工作项留言。';
	$l_err_4 = '&#8212; &#24037;&#20316;&#39033;&#25152;&#26377;&#32773;&#19981;&#26159;&#26412;&#39033;&#30446;&#25104;&#21592;&#12290;';
	$l_err_5 = '&#8212; &#24037;&#20316;&#39033;&#24050;&#34987;&#26356;&#25913;&#65292;&#35831;&#21047;&#26032;&#21518;&#20877;&#35797;&#12290;';
	$l_err_6 = '&#8212; &#24037;&#20316;&#39033;&#25152;&#26377;&#32773;&#19981;&#33021;&#20026;&#31354;&#65292;&#35831;&#37325;&#35797;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}
?>