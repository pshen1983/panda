<style type="text/css">
html,body{margin:0}
a.header{padding:0 2px 0 2px;color:#FFFFFF;padding-right:10px;font-family:tahoma;height:100%;display:block;text-decoration:none;}
a.header:hover{background-color:#3567A8;}
li.topheader_link_elem{display:block;float:right;height:100%;list-style-type:none;}
span.topheader_link_label_span{font-weight:bold;position:relative;top:12px;left:4px;}
input#search_button{border:0 none;background-image:url(../image/button/search_background.png);height:22px;width:22px;#position:relative;#top:1px;}
input#seach_input{outline: none;border:0 none;height:22px;font-size:1em;vertical-align:middle;width:200px;background-color:#FEFEFE;#line-height:135%;vertical-align:middle;padding-left:4px;}
div#header{position:fixed;top:0px;width:100%;z-index:999;}
div#inhead{margin:auto;width:980px;height:40px;background-color:#184D94;-webkit-box-shadow:0 0 5px #333;-moz-box-shadow:0 0 5px #333;box-shadow:0 0 5px #333;}
</style>
<?php 
if($_SESSION['_language']=='en') {
	$l_home = 'Home';
	$l_project = "Forum";
	$l_profile = 'Profile';
	$l_logout = 'Logout';
}
else if($_SESSION['_language']=='zh') {
	$l_home = '&#20027;&#39029;';
	$l_project = '论坛';
	$l_profile = '&#20010;&#20154;&#36164;&#26009;';
	$l_logout = '&#36864;&#20986;';
}
?><script language="JavaScript" src="../js/common.js"></script>
<div id="header"><div id="inhead">
<div style="height:100%;font-size:14px;">
<a href="../default/index.php" style="font-family:'Microsoft YaHei',tahoma;color:#DDDDDD;font-weight:bold;text-decoration:none;float:left;margin:2px 0 0 15px;font-size:26px;" title="ProjNote Beta">ProjNote<img style="width:25px;border:0 none;" src="../image/beta.gif"/></a>
<div style="position:relative;top:8px;left:35%;float:left;">
<form method="post" enctype="multipart/form-data" action="../search/header_result.php" style="margin-right:40px;" accept-charset="UTF-8">
<table border=0 cellspacing='1' cellpadding='0'>
<tr>
<td style="height:22px;text-align:center;"><input id="seach_input" name="seach_input" type="text" border=0 value="<?php echo (isset($_SESSION['seach_input']) && !empty($_SESSION['seach_input']))?$_SESSION['seach_input']:'';?>"/></td>
<td style="height:22px;text-align:center;foreground:transparent;"><input id="search_button" onmousedown="mousePressHeaderSearch('search_button')" onmouseup="mouseReleaseHeaderSearch('search_button')" onmouseout="mouseReleaseHeaderSearch('search_button')" type="submit" value="" /></td>
</tr>
</table>
</form>
</div>
<div style="height:100%;display:block;float:right;margin-right:5px;">
<ul style="height:100%;display:inline;">
<li class="topheader_link_elem"><a href="../default/logout.php" class="header"><span class="topheader_link_label_span"><?php echo $l_logout?></span></a></li>
<li class="topheader_link_elem"><a href="../home/profile.php" class="header"><span class="topheader_link_label_span"><?php echo $l_profile?></span></a></li>
<li class="topheader_link_elem"><a href="../forum/index.php" class="header"><span class="topheader_link_label_span"><?php echo $l_project?></span></a></li>
<li class="topheader_link_elem"><a href="../home/index.php" class="header"><span class="topheader_link_label_span"><?php echo $l_home?></span></a></li>
</ul>
</div>
</div>
</div></div>