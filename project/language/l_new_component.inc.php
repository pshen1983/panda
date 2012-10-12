<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_title = 'Create New Component | ProjNote';
	
	$l_create = 'Create a new';
	$l_create_comp = 'Project Component';
	$l_req_field = '- Required fileds are labled with';
	$l_info = 'Project Components help to break down a project into detailed parts. For example, a Project Components could be a project department group, a milestone, a project phase and etc.<br><br>
			   In ProjNote, a Project Component could contain many <span class="proj_info_obj" title="A single action or activity to achieve a goal.">Workitem</span> to serve its purpose.';
	$l_nc_name = 'Component Name';
	$l_nc_owner = 'Owner';
	$l_nc_deadline = 'End Date';
	$l_nc_milestone = 'Is a Project Milestone';
	$l_nc_descript = 'Description';
	$l_nc_submit = 'Submit';
	$l_select_yes = 'Yes';
	$l_select_no = 'No';

	$l_err_1 = '- Project Component already exist.';
	$l_err_2 = '- End date must be after today.';
	$l_err_3 = '- System is temporarily busy, please try again later.';
	$l_err_4 = '- You do NOT have enough privilige to create a Component in this project.';
	$l_err_5 = '- The <span class="error_message_italic">Owner</span> you for this Project Component is NOT a project leader.';
	$l_err_6 = '- The Component <span class="error_message_italic">Owner</span> field could NOT be empty.';
	$l_err_7 = '- The <span class="error_message_italic">Component Name</span> field could NOT be empty.';
	$l_calendar = 'Click the calendar icon on the right to pick a date';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_title = '&#26032;&#24314;&#39033;&#30446;&#32452; | ProjNote';

	$l_create = '&#26032;&#24314;';
	$l_create_comp = '&#39033;&#30446;&#32452;';
	$l_req_field = '&#8212; &#24517;&#39035;&#22635;&#20889;&#30340;&#20869;&#23481;';
	$l_info = '项目组将项目组成部分细节化。它可以是一个项目部门（如：设计部，研发部），一个项目里程碑（如：系统第一期交付）或是一个项目的阶段（如：研发第一期）。<br><br>在 ProjNote，一个项目组可以创建多个
			   <span class="proj_info_obj" title="可以是任务，缺陷，设计，提醒等">工作项</span> 来有效的完成项目组的任务。';
	$l_nc_name = '&#39033;&#30446;&#32452;&#21517;&#31216;';
	$l_nc_owner = '&#25152;&#26377;&#32773;';
	$l_nc_deadline = '&#25130;&#27490;&#26085;&#26399;';
	$l_nc_milestone = '&#39033;&#30446;&#37324;&#31243;&#30865;';
	$l_nc_descript = '&#32454;&#33410;&#35828;&#26126;';
	$l_nc_submit = '&#30830;&#23450;';
	$l_select_yes = '&#26159;';
	$l_select_no = '&#19981;&#26159;';

	$l_err_1 = '&#8212; &#39033;&#30446;&#32452;&#24050;&#23384;&#22312;&#12290;';
	$l_err_2 = '&#8212; &#25130;&#27490;&#26085;&#26399;&#24517;&#39035;&#22312;&#20170;&#22825;&#20043;&#21518;&#12290;';
	$l_err_3 = '&#8212; &#31995;&#32479;&#26242;&#26102;&#32321;&#24537;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;&#12290;';
	$l_err_4 = '&#8212; &#24744;&#27809;&#26377;&#36275;&#22815;&#26435;&#38480;&#22312;&#26412;&#39033;&#30446;&#26032;&#24314;&#39033;&#30446;&#32452;&#12290;';
	$l_err_5 = '&#8212; &#24744;&#36873;&#25321;&#30340;&#39033;&#30446;&#32452;<span class="error_message_italic">&#25152;&#26377;&#32773;</span>&#19981;&#26159;&#39033;&#30446;&#20027;&#31649;&#25110;&#26356;&#39640;&#12290;';
	$l_err_6 = '&#8212; &#39033;&#30446;&#32452;<span class="error_message_italic">&#25152;&#26377;&#32773;</span> &#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_err_7 = '&#8212; &#39033;&#30446;&#32452;<span class="error_message_italic">&#21517;&#31216;</span> &#19981;&#33021;&#20026;&#31354;&#12290;';
	$l_calendar = '&#28857;&#20987;&#21491;&#20391;&#26085;&#21382;&#22270;&#26631;&#36873;&#25321;&#26085;&#26399;';
}
?>