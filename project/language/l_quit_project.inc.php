<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_err_2 = 'This is not a valid request';
	$l_err_3 = 'Cannot find the project you specified';
	$l_err_4 = 'You cannot quit as the owner. Please assign the ownership to others and try again.';
	$l_err_5 = 'You are not a member of this project';
	$l_err_6 = 'This action is temporarily not available, Please try again later.';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_err_2 = '请求的格式有误';
	$l_err_3 = '找不到您指定的项目';
	$l_err_4 = '您是项目总监，不能退出。请将他人指定为总监后重试。';
	$l_err_5 = '您不是该项目的成员';
	$l_err_6 = '系统暂时无法完成此操作，请稍候再试。';
}
?>