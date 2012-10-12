<?php
if($_SESSION['_language'] == 'en') {
//========================================================================================================= en
	$l_title = 'Login | ProjNote';
	$l_sys_err = 'System cannot log you in currently.<br>Please try again later.';
	$l_cannot_find = array();
	$l_cannot_find[0] = 'Cannot find <<span class="login_message_color_red">';
	$l_cannot_find[1] = '</span>><br>Please <a href="register.php" style="font-size:12;"><b>Sign Up</b></a> and log in again.';
	$l_worng_pass = 'The <span class="login_message_color_red">password</span> you entered is incorrect.<br>Please try again (make sure <span style="font-style:italic;">Cpas Lock</span> is off).';
	$l_email_empty = '<span class="login_message_color_red">Email</span> field cannot be <span class="login_message_color_red">empty</span>.<br>Please enter an valid email and try to login again.';
	$l_email_format = 'Email <span class="login_message_color_red">format</span> is not valid.<br>Please enter an valid email and try to login again.';
	$l_pass_empty = '<span class="login_message_color_red">Password</span> field cannot be <span class="login_message_color_red">empty</span>.<br>Please enter a password and try to login again.';

	$l_login = 'Login';
	$l_email = 'Email';
	$l_password = 'Password';
	$l_logged_in = 'Keep me logged in';
	$l_log_keep_title = 'Please uncheck if on a shared computer!';
	$l_or = 'or';
	$l_sign_up_login = 'Sign up for ProjNote';
	$l_forget_pass = 'Forget Password';
	$l_from_reg = 'Registeration successful, please Login now.';
}
else if($_SESSION['_language'] == 'zh') {
//========================================================================================================= zh
	$l_title = '&#30331;&#24405; ProjNote';
	$l_sys_err = '&#31995;&#32479;&#26242;&#26102;&#26080;&#27861;&#30331;&#38470;. &#35831;&#31245;&#20505;&#20877;&#35797;.';
	$l_cannot_find = array();
	$l_cannot_find[0] = '&#29992;&#25143;<<span class="login_message_color_red">';
	$l_cannot_find[1] = '</span>>&#19981;&#23384;&#22312;&#35831;<a href="register.php" style="font-size:12;"><b>&#27880;&#20876;</b></a>&#21518;&#20877;&#35797;.';
	$l_worng_pass = '<span class="login_message_color_red">&#24080;&#21495;&#25110;&#23494;&#30721;</span>&#38169;&#35823;. &#35831;&#37325;&#35797;(&#30830;&#35748;<span style="font-style:italic;">Cpas Lock</span>&#38190;&#20851;&#38381;).';
	$l_email_empty = '<span class="login_message_color_red">&#24080;&#21495;</span>&#19981;&#33021;&#20026;<span class="login_message_color_red">&#31354;&#30333;</span>. &#35831;&#36755;&#20837;&#24080;&#21495;&#21518;&#20877;&#35797;.';
	$l_email_format = '&#24080;&#21495;(Email)<span class="login_message_color_red">&#26684;&#24335;</span>&#38169;&#35823;. &#35831;&#37325;&#26032;&#36755;&#20837;&#21518;&#20877;&#35797;.';
	$l_pass_empty = '<span class="login_message_color_red">&#23494;&#30721;</span>&#19981;&#33021;&#20026;<span class="login_message_color_red">&#31354;&#30333;</span>. &#35831;&#36755;&#20837;&#23494;&#30721;&#21518;&#20877;&#35797;';

	$l_login = '&#30331;&#24405;';
	$l_email = '&#24080;&#21495;';
	$l_password = '&#23494;&#30721;';
	$l_logged_in = '&#19979;&#27425;&#33258;&#21160;&#30331;&#24405;';
	$l_log_keep_title = '请不要在共用的电脑上选此项！';
	$l_or = '&#25110;';
	$l_sign_up_login = '&#27880;&#20876; ProjNote';
	$l_forget_pass = '&#24536;&#35760;&#23494;&#30721;';
	$l_from_reg = '&#27880;&#20876;&#25104;&#21151;&#65292;&#35831;&#24744;&#29616;&#22312;&#30331;&#24405;&#12290;';
}
?>