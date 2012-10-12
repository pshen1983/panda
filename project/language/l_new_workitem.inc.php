<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_title = 'Create New Workitem | ProjNote';

	$l_create = 'Create a new: ';
	$l_create_wi = 'Workitem';
	$l_req_field = '- Required fileds are labled with';
	$l_leave = 'If you leave this page, you will loss the unsaved data.';
	$l_info = 'In ProjNote，a Workitem is a single action or activity to achieve a goal (could be a Task, Defect, Plan and etc.). It could belong to a 
			   <span class="proj_info_obj" title="Helps to break down a project into detailed parts. e.g. it could be a project department group, a milestone, a project phase and etc.">Project Component</span> or directly to a 
			   <span class="proj_info_obj" title="Carefully plan, design and manage a set of work to achieve a particular aim.">Project</span>。';
	$l_nwi_name = 'Summary';
	$l_nwi_owner = 'Owner';
	$l_nwi_pc_blong = 'Project Component belongs to';
	$l_nwi_wp_blong = 'Workpackage belongs to';
	$l_nwi_type = 'Type';
	$l_nwi_priority = 'Priority';
	$l_nwi_follow = 'Add follower to this Workitem';
	$l_nwi_follow_btn = 'Add More Followers';
	$l_follow_note = 'A follower, who may be interested in this workitem, will receive a message when there is a update to this workitem (e.g. a new comment, a status change, a new attachment, and etc.).';
	$l_nwi_deadline = 'End Date';
	$l_nwi_descript = 'Description';
	$l_nwi_submit = 'Submit';

	$l_err_1 = '- End date must be after today.';
	$l_err_2 = '- System is temporarily busy, please try again later.';
	$l_err_3 = '- Please select a Project, Project Component or Work Package to create work item for.';
	$l_err_4 = '- You do NOT have enough privilige to create work item in this project.';
	$l_err_5 = '- All reuqired fields (*) must NOT be empty.';
	$l_err_6 = '- The <span class="error_message_italic">Owner</span> you specified for this Workitem does NOT exist.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_title = '新建工作项 | ProjNote';
	
	$l_create = '新建：';
	$l_create_wi = '工作项';
	$l_req_field = '&#8212; &#24517;&#39035;&#22635;&#20889;&#30340;&#20869;&#23481;';
	$l_leave = '离开此页您将丢失所填数据。';
	$l_info = '在ProjNote，工作项是一项单一的具体工作，可以是一个任务，一个缺陷，一个设计等等。它可以属于某个 
			   <span class="proj_info_obj" title="&#23558;&#39033;&#30446;&#32452;&#25104;&#37096;&#20998;&#32454;&#33410;&#21270;&#65292;&#21487;&#20197;&#26159;&#19968;&#20010;&#39033;&#30446;&#37096;&#38376;&#65292;&#19968;&#20010;&#39033;&#30446;&#37324;&#31243;&#30865;&#25110;&#26159;&#19968;&#20010;&#39033;&#30446;&#38454;&#27573;&#12290;">项目组</span> 或直接属于一个
			   <span class="proj_info_obj" title="&#36890;&#36807;&#35745;&#21010;&#65292;&#35774;&#35745;&#21644;&#31649;&#29702;&#19968;&#31995;&#21015;&#24037;&#20316;&#26469;&#36798;&#21040;&#19968;&#20010;&#29305;&#23450;&#30340;&#30446;&#30340;&#12290;">项目</span>&#12290;';
	$l_nwi_name = '&#31616;&#20171;';
	$l_nwi_owner = '&#25152;&#26377;&#32773;';
	$l_nwi_pc_blong = '&#25152;&#23646;&#39033;&#30446;&#32452;';
	$l_nwi_wp_blong = '&#25152;&#23646;&#24037;&#20316;&#21253;';
	$l_nwi_type = '&#31867;&#21035;';
	$l_nwi_priority = '&#20248;&#20808;&#24230;';
	$l_nwi_follow = '&#28155;&#21152;&#24037;&#20316;&#39033;&#20851;&#27880;&#32773;';
	$l_nwi_follow_btn = '&#28155;&#21152;&#26356;&#22810;&#20851;&#27880;&#32773;';
	$l_follow_note = '当一个工作项被更新时（如：一条新留言，一个新附件，状态变化等等），关注者将收到站内短信的提醒，帮助他们第一时间了解此工作项的更新。';
	$l_nwi_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_nwi_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_nwi_submit = '&#30830;&#23450;';

	$l_err_1 = '&#8212; &#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290;';
	$l_err_2 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_3 = '&#8212; &#35831;&#20808;&#36873;&#25321;&#19968;&#20010;&#39033;&#30446;&#65292;&#39033;&#30446;&#32452;&#25110;&#24037;&#20316;&#21253;&#20877;&#26032;&#24314;&#24037;&#20316;&#39033;&#12290;';
	$l_err_4 = '&#8212; &#24744;&#27809;&#26377;&#36275;&#22815;&#26435;&#38480;&#22312;&#26412;&#39033;&#30446;&#26032;&#24314;&#24037;&#20316;&#39033;&#12290;';
	$l_err_5 = '&#8212; &#25152;&#26377;( * )&#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_err_6 = '&#8212; &#24037;&#20316;&#39033;&#25152;&#26377;&#29992;&#25143;&#19981;&#23646;&#20110;&#26412;&#39033;&#30446;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}
?>