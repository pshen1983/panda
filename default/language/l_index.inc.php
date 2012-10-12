<?php 
if($_SESSION['_language'] == 'en') {
//========================================================================================================= (en)
	$l_title = 'ProjNote Home Page - Project Management, Work Management, Task Management, Document Sharing, Team Collabration, Open Platform, 项目管理, 工作管理, 任务管理, 文档共享, 团队协作, 开放平台';
	$l_log_email = 'Email';
	$l_log_passwd = 'Password';
	$l_log_keep = 'Keep me logged in';
	$l_log_keep_title = 'Please uncheck if on a shared computer!';
	$l_log_forget = 'Forget your password?';
	$l_log_submit = 'Log In';
	$l_reg_title = 'New to ProjNote?';
	$l_reg_link = 'Join today!';
	$l_reg_lname = 'Last Name:';
	$l_reg_fname = 'First Name:';
	$l_reg_email = 'Your Email:';
	$l_reg_remail = 'Re-enter Email:';
	$l_reg_passwd = 'Your Password:';
	$l_reg_rpasswd = 'Re-enter Password:';
	$l_reg_terms = 'I have read and agreed to the <br> <a target="_blank" class="reg_term" style="font-style:italic;" href="../terms/index.php">ProjNote User Agreement</a>';
	$l_reg_sign_up = 'Sign Up';
	$l_new_feel = 'Free Assistant for Your Project Work';
	$l_new_detail = 'Create your project, invite friends to join, clarify project tasks and speed up team work.';
	$l_new_d1 = 'Project break down and planning';
	$l_new_d2 = 'Task management';
	$l_new_d3 = 'Defect management';
	$l_new_d4 = 'Team collabration';
	$l_new_d5 = 'Document sharing';
	$l_new_d6 = 'Project statistics';
	$l_suggest = "Suggested Broswer: ";
	$l_broswer = "<a class='down' target='_blank' href='https://www.google.com/chrome?hl=en'>Chorme</a>, 
				  <a class='down' target='_blank' href='http://firefox.com/'>Firefox</a>, 
				  <a class='down' target='_blank' href='http://www.apple.com/safari/'>Safari</a>, 
				  <a class='down' target='_blank' href='http://www.opera.com/browser/download/'>Opera</a>,
				  <a class='down' target='_blank' href='http://info.msn.com.cn/ie9/'>IE9</a>";
	$l_brow = "";
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= (zh)
	$l_title = 'ProjNote 主页 - 项目管理, 工作管理, 任务管理, 文档共享, 团队协作, 开放平台, Project Management, Work Management, Task Management, Document Sharing, Team Collabration, Open Platform';
		$l_log_email = '邮件';
	$l_log_passwd = '密码';
	$l_log_keep = '下次自动登录';
	$l_log_keep_title = '请不要在共用的电脑上选此项！';
	$l_log_forget = '忘记密码？';
	$l_log_submit = '登录';
	$l_reg_title = '刚到 ProjNote？';
	$l_reg_link = '立刻注册！';
	$l_reg_lname = '姓：';
	$l_reg_fname = '名：';
	$l_reg_email = '邮件：';
	$l_reg_remail = '确认邮件：';
	$l_reg_passwd = '密码：';
	$l_reg_rpasswd = '确认密码：';
	$l_reg_terms = '我已阅读并同意<a target="_blank" class="reg_term" href="../terms/index.php">《ProjNote 用户协议》</a>';
	$l_reg_sign_up = '立刻注册';
	$l_new_feel = '永远免费，团队协作、个人管理永远在云端';
	$l_new_detail = '为 IT 自由职业者、小团队打造的个人管理、团队协作的开放平台。<br />条理任务、优化提醒，ProjNote 是您的智能项目助理。';
	$l_new_d1 = '项目细化与工作计划';
	$l_new_d2 = '任务管理';
	$l_new_d3 = '缺陷管理';
	$l_new_d4 = '团队合作与协同';
	$l_new_d5 = '文档分享';
	$l_new_d6 = '项目统计数据';
	$l_suggest = "建议使用：";
	$l_broswer = "<a class='down' target='_blank' href='http://www.google.cn/chrome/intl/zh-CN/landing_chrome.html'>Chorme</a>, 
				  <a class='down' target='_blank' href='http://firefox.com.cn/'>Firefox</a>, 
				  <a class='down' target='_blank' href='http://www.apple.com.cn/safari/'>Safari</a>, 
				  <a class='down' target='_blank' href='http://www.opera.com/browser/download/'>Opera</a>,
				  <a class='down' target='_blank' href='http://info.msn.com.cn/ie9/'>IE9</a>";
	$l_brow = " 浏览器";
}
?>