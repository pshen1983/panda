<?php
include_once ("../common/Objects.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = 'Document Broswer | ProjNote';
	
	$l_home_label = 'Home';
	$l_proj_label = 'project';

	$l_proj_title = 'List documents in Project - ';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '&#25991;&#26723;&#27983;&#35272;&#22120; | ProjNote';
	
	$l_home_label = '&#20027;&#39029;';
	$l_proj_label = '&#39033;&#30446;';

	$l_proj_title = '&#39033;&#30446;&#25991;&#26723;&#21015;&#34920; &#8212; ';
}

//=========================================================================================================

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/documents_display.css' />
<script type='text/javascript' src="../js/common.js"></script>
<script type='text/javascript' src="../js/document.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
	<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
	<?php include_once '../common/path_nav.inc.php';?>
	<div id="top_link_saperator"></div>
	<div id="doc_bro">
	<div id="doc_bro_value"></div>
	<div id="doc_bro_tree"><ul id="tree_list">
	<li><div><a href="javascript:hideShowDocBro('img_home', 'ul_projs')"><img id="img_home" class="collapse" src="../image/expand.png"/></a><b><?php echo $l_home_label?></b></div>
	<ul id="ul_projs" style="visibility:visible;">
<?php
	$projs = DatabaseUtil::getUserOpenProjList($_SESSION['_userId']);
	$output = '';
	$trunLen = 43;

	while ($proj = mysql_fetch_array($projs, MYSQL_ASSOC))
	{
		$project = DatabaseUtil::getProj($proj['id']);
		$output.= '<li style="padding-top:8px;"><a href="javascript:showHideDocBro(\'img_proj'.$proj['id'].'\', \'ul_proj'.$proj['id'].'\');javascript:getProjs(\''.$proj['id'].'\', \'ul_proj'.$proj['id'].'\')"><img id="img_proj'.$proj['id'].'" class="collapse" src="../image/collapse.png"/></a><a id="a_proj'.$proj['id'].'" href="javascript:getDocs(\''.$proj['id'].'\',\'\',\'\',\'\',\''.$project['s_id'].'\',\'doc_bro_value\',\'a_proj'.$proj['id'].'\')" title="'.$l_proj_title.'\''.str_replace('"', '&quot;', $proj['title']).'\'">'.CommonUtil::truncate($proj['title'], $trunLen).' (<span class="doc_bro_proj">'.$l_proj_label.'</span>)</a>
				  <ul id="ul_proj'.$proj['id'].'" style="visibility:hidden;"></ul>
				  </li>';
	}
	echo $output;
?>
	</ul>
	</li>
	</ul>
	<input type="hidden" value="img_home" id="hidden_id" />
	</div>
	</div>
	</div>
	<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>
