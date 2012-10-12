<style type="text/css">
html,body{margin:0}
a.header{padding:0 2px 0 2px;color:#FFF;padding-right:10px;font-family:tahoma;height:100%;display:block;text-decoration:none;}
a.header:hover{background-color:#3567A8;}
li.topheader_link_elem{display:block;float:left;height:100%;list-style-type:none;}
span.topheader_link_label_span{font-weight:bold;position:relative;top:12px;left:4px;}
div#header{position:fixed;top:0px;width:100%;z-index:999;}
div#inhead{margin:auto;width:980px;height:40px;background-color:#184D94;-webkit-box-shadow:0 0 5px #333;-moz-box-shadow:0 0 5px #333;box-shadow:0 0 5px #333;}
</style>
<?php 
if($_SESSION['_language']=='en') {
	$l_sign_up = 'Sign Up';
	$l_login = 'Login';
	$l_feedback = 'Forum';
	$l_help = 'Help';
}
else if($_SESSION['_language']=='zh') {
	$l_sign_up = '&#27880;&#20876;';
	$l_login = '&#30331;&#24405;';
	$l_feedback = '论坛';
	$l_help = '&#24110;&#21161;';
}
?><div id="header"><div id="inhead">
<div style="height:100%;font-size:14px;">
<a href="../default/index.php" style="font-family:'Microsoft YaHei',tahoma;color:#DDDDDD;font-weight:bold;text-decoration:none;float:left;margin:2px 0 0 15px;font-size:26px;" title="ProjNote Beta">ProjNote<img style="width:25px;border:0 none;" src="../image/beta.gif"/></a>
<div style="height:100%;float:right;margin-right:-5px;text-align:right;">
<ul style="height:100%;display:inline;">
<li class="topheader_link_elem"><a href="../default/register.php" class="header"><span class="topheader_link_label_span"><?php echo $l_sign_up?></span></a></li>
<li class="topheader_link_elem"><a href="../default/login.php" class="header"><span class="topheader_link_label_span"><?php echo $l_login?></span></a></li>
<li class="topheader_link_elem"><a href="../forum/index.php" class="header"><span class="topheader_link_label_span"><?php echo $l_feedback?></span></a></li>
<li class="topheader_link_elem"><a href="../help/index.php" class="header"><span class="topheader_link_label_span"><?php echo $l_help?></span></a></li>
</ul>
</div>
</div></div>
</div>