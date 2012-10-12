<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_inva_form = 'Invalid date formate.';
	$l_from = 'From';
	$l_to = 'To';
	$l_update = 'Update List';
	$l_list = 'List of my workitems ';
	$l_all = '';
	$l_project = 'in project - ';
	$l_component = 'in component - ';
	$l_0_due = 'You have 0 work due ';

	$l_yesterday = 'Yesterday';
	$l_today = 'Today';
	$l_tomorrow = 'Tomorrow';
	$l_rclick_hint = 'Right click to see more actions';

	$l_type = 'Type';
	$l_proj = 'Project';
	$l_obje = 'Summary';
	$l_stat = 'Status';
	$l_prio = 'Priority';
	$l_dead = 'Deadline';

	$l_item = 'Item :';
	$l_package = 'Package :';	
	$l_calendar = 'Click the calendar icon on the right to pick a date';

}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_inva_form = '&#26684;&#24335;&#38169;&#35823;&#12290;';
	$l_from = '&#20174;';
	$l_to = '&#33267;';
	$l_update = '&#26356;&#26032;&#21015;&#34920;';
	$l_list = '我的工作项列表';
	$l_all = '';
	$l_project = '&#39033;&#30446; &#8212; ';
	$l_component = '&#39033;&#30446;&#32452; &#8212; ';
	$l_0_due = ' &#24744;&#27809;&#26377;&#24037;&#20316;&#25130;&#27490;&#12290;';

	$l_yesterday = '昨天';
	$l_today = '今天';
	$l_tomorrow = '明天';
	$l_rclick_hint = '点击右键展示更多功能';

	$l_type = '&#31181;&#31867;';
	$l_proj = '&#39033;&#30446;';
	$l_obje = '&#27010;&#35201;';
	$l_stat = '&#29366;&#24577;';
	$l_prio = '&#20248;&#20808;&#24230;';
	$l_dead = '&#25130;&#27490;&#26085;&#26399;';

	$l_item = '&#24037;&#20316;&#39033;:';
	$l_package = '&#24037;&#20316;&#21253;:';	
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}
?>