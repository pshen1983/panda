<?php
include_once ("../utils/configuration.inc.php");
include_once ("../utils/CommonUtil.php");
include_once ("../utils/SecurityUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

if (isset($_SESSION['_userId']) || SecurityUtil::cookieLogin())
{
	if($_SESSION['_loginUser']->proj_id != 0) {
			$proj = DatabaseUtil::getProj($_SESSION['_loginUser']->proj_id);
	    	header( 'Location: '.$HTTP_BASE.'/project/index.php?p_id='.$_SESSION['_loginUser']->proj_id.'&sid='.$proj['s_id'] ) ;
		}
	else header( 'Location: '.$HTTP_BASE.'/home/index.php' );

	exit;
}

$imageId = CommonUtil::genRandomString(8);
include_once ("language/l_index.inc.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="title" content="<?php echo $l_title?>">
<meta name="keywords" content="free, small team, project, project management, team collaboration, work management, document sharing, project statistics, open platform, 免费, 小团队, 项目, 项目管理, 团队协作, 工作管理, 文档共享, 项目统计, 公共平台" />
<meta name="description" content="a free work management based project management platform for team collabration, document sharing and workitem management,一个免费的以项目为基础的工作管理平台，提供项目细化，团队协作，文档共享和任务管理等功能。" />
<meta name="AUTHOR" content="Peng Shen">
<meta name="Copyright" content="Copyright <?php echo date('Y')?>, Peng Shen">
<meta name="owner" content="Peng Shen">
<meta name="GENERATOR" content="Peng Shen">
<meta name="robots" content="ALL">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link type="text/css" rel="stylesheet" href="../css/proj_layout.css" />
<link type="text/css" rel="stylesheet" href="css/index.css" />
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<div id="body">
<div id="top">
<div id="top_inner">
<a href="../default/index.php" id="home" title="ProjNote Beta">ProjNote<img style="width:30px;border:0 none;" src="../image/beta.gif"/></a>
<div id="log">
<form method="post" enctype="multipart/form-data" action="<?php echo $HTTPS_BASE?>/default/login.php" name="login_form" id="login_form" accept-charset="UTF-8">
<table id="log_table" cellspacing="0" border="0" style="margin-top:10px;">
<tr>
<td><label class="login"><?php echo $l_log_email?></label></td>
<td><label class="login"><?php echo $l_log_passwd?></label></td>
<td rowspan="3"><input type="hidden" value="buttonclick" name="hide" />
<input type="submit" value="<?php echo $l_log_submit?>" class="ind_sub" tabindex="3" /></td>
</tr>
<tr>
<td><input type="text" class="login round_border_4" name="loginemail" id="loginemail" maxlength="96" tabindex="1" /></td>
<td><input type="password" class="login round_border_4" name="loginpasswd" id="loginpasswd" maxlength="64" tabindex="2" /></td>
</tr>
<tr>
<td><input class="check" type="checkbox" checked="checked" name='keep_login' id='keep_login' title="<?php echo $l_log_keep_title?>" tabindex="4" /><label class="keep" for="keep_login" title="<?php echo $l_log_keep_title?>"><?php echo $l_log_keep?></label></td>
<td><a href="../default/forget_password.php" class="forget" tabindex="5" ><?php echo $l_log_forget?></a></td>
</tr>
</table>
</form>
</div>
</div></div>
<div id="bot">
<div id="bot_inner">
<div id="reg">
<div id="reg_title"><label class="signup"><?php echo $l_reg_title?><a id="reg_link" href="../default/register.php"><?php echo $l_reg_link?></a></label></div>
<div id="reg_sap"></div>
<form method="post" enctype="multipart/form-data" action="../default/register.php" name="reg_form" id="reg_form" accept-charset="UTF-8">
<table id="reg_table" cellspacing="2" border="0">
<tr>
<td class="first"><label class="regist"><?php echo $l_reg_lname?></label></td>
<td><input type="text" class="regist round_border_6" name="lastname" id="lastname" maxlength="96" /></td>
</tr>
<tr>
<td class="first"><label class="regist"><?php echo $l_reg_fname?></label></td>
<td><input type="text" class="regist round_border_6" name="firstname" id="firstname" maxlength="96" /></td>
</tr>
<tr>
<td class="first"><label class="regist"><?php echo $l_reg_email?></label></td>
<td><input type="text" class="regist round_border_6" name="email" id="email" maxlength="96" /></td>
</tr>
<tr>
<td class="first"><label class="regist"><?php echo $l_reg_remail?></label></td>
<td><input type="text" class="regist round_border_6" name="remail" id="remail" maxlength="96" /></td>
</tr>
<tr>
<td class="first"><label class="regist"><?php echo $l_reg_passwd?></label></td>
<td><input type="password" class="regist round_border_6" name="passwd" id="passwd" maxlength="64" /></td>
</tr>
<tr>
<td class="first"><label class="regist"><?php echo $l_reg_rpasswd?></label></td>
<td><input type="password" class="regist round_border_6" name="repasswd" id="repasswd" maxlength="64" /></td>
</tr>
<tr>
<td></td>
<td class="term"><input class="check" type="checkbox" name="terms" id="terms" checked="checked"/><label class="read" for="terms" id="terms_l"><?php echo $l_reg_terms?></label></td>
</tr>
<tr>
<td><input type="hidden" id="ind" name="ind" value="ind" /></td>
<td><input type="submit" class="submitbng" value="<?php echo $l_reg_sign_up?>"/></td>
</tr>
</table>
</form>
</div>
<div id="new">
<p id="new_title"><label><?php echo $l_new_feel?></label></p>
<p id="new_detail"><label><?php echo $l_new_detail?></label></p>
<div id="detail_fn">
<ul>
<li><h1><?php echo $l_new_d1?></h1></li>
<li><h1><?php echo $l_new_d2?></h1></li>
<li><h1><?php echo $l_new_d3?></h1></li>
<li><h1><?php echo $l_new_d4?></h1></li>
<li><h1><?php echo $l_new_d5?></h1></li>
<li><h1><?php echo $l_new_d6?></h1></li>
</ul>
<div style="margin-top:30px;font-size:.9em;color:#444;text-shadow: 0 1px 1px #fff;"><?php echo $l_suggest.$l_broswer.$l_brow?></div>
</div>
</div>
</div></div>
</div>
<?php include_once '../common/footer_2.inc.php';?>
</center>
</body>
</html>