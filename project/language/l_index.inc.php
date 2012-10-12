<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_title = 'Project | ProjNote';
	$l_set_default = '(set to default project)';
	$l_uns_default = '(unset default project)';
	$l_default_title = 'Set a project to be your default project, you will be direct to it after you login.';
	$l_goto = 'Got to Workitem';
	$l_done = 'Done Workitem';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_title = '&#39033;&#30446 | ProjNote';
	$l_set_default = '&#65288;&#35774;&#20026;&#40664;&#35748;&#39033;&#30446;&#65289;';
	$l_uns_default = '&#65288;&#21462;&#28040;&#40664;&#35748;&#39033;&#30446;&#65289;';
	$l_default_title = '&#23558;&#19968;&#20010;&#39033;&#30446;&#35774;&#20026;&#40664;&#35748;&#39033;&#30446;&#65292;&#30331;&#24405;&#21518;&#24744;&#23558;&#33258;&#21160;&#36827;&#20837;&#35813;&#39033;&#30446;&#12290;';
	$l_goto = '前往工作项';
	$l_done = '完成工作项';
}
?>