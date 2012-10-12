<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_summary = 'Summary';
	$l_owner = 'Owner';
	$l_status = 'Status';
	$l_type = 'Type';
	$l_priority = 'Priority';
	$l_wp = 'Workpackage';
	$l_comp = 'Component';
	$l_proj = 'Project';
	$l_deadline = 'Deadline';

	$l_header = 'List of workpackage or workitem last modified by you:';
	$l_empty = '(empty)';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_summary = '&#31616;&#20171;';
	$l_owner = '&#25152;&#26377;&#32773;';
	$l_status = '&#29366;&#24577;';
	$l_type = '&#31867;&#21035;';
	$l_priority = '&#20248;&#20808;&#24230;';
	$l_wp = '&#25152;&#23646;&#24037;&#20316;&#21253;';
	$l_comp = '&#39033;&#30446;&#32452;';
	$l_proj = '&#39033;&#30446;';
	$l_deadline = '&#25130;&#27490;&#26085;&#26399;';

	$l_header = '我最后更改的工作：';
	$l_empty = '&#65288;&#31354;&#65289;';
}
?>