<?php
if($_SESSION['_language'] == 'en') {
//--------------------------------------------------------------------- English
	$l_title = 'Register | ProjNote';
	$l_sys_err = 'System temporarily unavailable, please try to Sign Up at a later time';
	$l_acc_exist = array();
	$l_acc_exist[0] = 'Email: <<span class="reg_message_color_red">';
	$l_acc_exist[1] = '</span>> exists, please <a href="../default/login.php">Login</a>';
	$l_err_occ = 'An error has occur when registering: <<span class="reg_message_color_red">';
	$l_acc_diff = 'Two <span class="reg_message_color_red">email addresses</span> entered are not the same';
	$l_email_format = 'Invalid <span class="reg_message_color_red">email format</span>, please try again';
	$l_check_err = 'Check code entered wrong';
	$l_pass_empty = '<span class="reg_message_color_red">Password</span> can NOT be empty';
	$l_pass_diff = 'Tow <span class="reg_message_color_red">passwords</span> entered are NOT the same';
	$l_read_terms = 'Please read <a target="_blank" class="terms_a" style="font-style:italic;" href="../terms/index.php">ProjNote User Agreement</a> and try again';

	$l_sign_up_reg = 'Sign Up';
	$l_reg_email = 'Email';
	$l_reg_reemail = 'Re-enter Email';
	$l_reg_f_name = 'First Name';
	$l_reg_l_name = 'Last Name';
	$l_reg_pass = 'Password';
	$l_reg_repass = 'Re-enter Password';
	$l_reg_check = 'Check Code';
	$l_reg_diff_check = 'Try a different check code';
	$l_reg_sign_up = 'Sign Up';
	$l_reg_terms = 'I have read and agree to the <a target="_blank" class="terms_a" style="font-style:italic;" href="../terms/index.php">ProjNote User Agreement</a>';
}
else if($_SESSION['_language'] == 'zh') {
//--------------------------------------------------------------------- 简体中文
	$l_title = '&#27880;&#20876; projnote';
	$l_sys_err = '&#31995;&#32479;&#26242;&#26102;&#26080;&#27861;&#27880;&#20876;&#65292;&#35831;&#31245;&#20505;&#20877;&#35797;';
	$l_acc_exist = array();
	$l_acc_exist[0] = '&#36134;&#25143;:<<span class="reg_message_color_red">';
	$l_acc_exist[1] = '</span>>&#24050;&#27880;&#20876;&#65292;&#35831;<a href="../default/index.php">&#30331;&#24405;</a>';
	$l_err_occ = '&#36134;&#25143;&#27880;&#20876;&#38169;&#35823;: <<span class="reg_message_color_red">';
	$l_acc_diff = '&#20004;&#27425;&#36755;&#20837;&#30340; <span class="reg_message_color_red">email</span> &#19981;&#21516;';
	$l_email_format = '&#36134;&#25143;(Email)<span class="reg_message_color_red">&#26684;&#24335;</span>&#38169;&#35823;&#65292;&#35831;&#37325;&#35797;';
	$l_check_err = '&#39564;&#35777;&#30721;&#38169;&#35823;&#65292;&#35831;&#37325;&#35797;';
	$l_pass_empty = '<span class="reg_message_color_red">&#23494;&#30721;</span>&#19981;&#33021;&#20026;&#31354;&#30333;';
	$l_pass_diff = '&#20004;&#27425;&#36755;&#20837;&#30340;<span class="reg_message_color_red">&#23494;&#30721;</span>&#19981;&#21516;&#65292;&#20026;&#31354;&#30333;&';
	$l_read_terms = '请阅读<a target="_blank" class="terms_a" href="../terms/index.php">《ProjNote 用户协议》</a>后重试';

	$l_sign_up_reg = '&#27880;&#20876;';
	$l_reg_email = '&#36134;&#25143;(Email)';
	$l_reg_reemail = '&#20877;&#27425;&#36755;&#20837;(Email)';
	$l_reg_f_name = '&#21517;';
	$l_reg_l_name = '&#22995;';
	$l_reg_pass = '&#23494;&#30721;';
	$l_reg_repass = '&#20877;&#27425;&#36755;&#20837;&#23494;&#30721;';
	$l_reg_check = '&#39564;&#35777;&#30721;';
	$l_reg_diff_check = '&#30475;&#19981;&#28165;&#65292;&#25442;&#19968;&#20010;&#39564;&#35777;&#30721;';
	$l_reg_sign_up = '&#31435;&#21051;&#27880;&#20876;';
	$l_reg_terms = '我已阅读并同意<a target="_blank" class="terms_a" href="../terms/index.php">《ProjNote 用户协议》</a>';
}
?>