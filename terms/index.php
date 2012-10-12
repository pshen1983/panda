<?php
include_once ("../utils/CommonUtil.php");

session_start();
if(!isset($_SESSION['_language'])) CommonUtil::setSessionLanguage();

include_once ("language/terms.".$_SESSION['_language'].".inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../css/proj_layout.css" />
<link rel="stylesheet" type="text/css" href="css/terms.css" />
<style type="text/css">
body
{
background-color:#f6f6f6;
font-family:<?php echo ($_SESSION['_language']=='zh') ? "'微软雅黑'" : "font-family:tahoma";?>;
}
;</style>
<script type='text/javascript' src="../js/jquery.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
$("#ts").click(function(e) {
	$("#tscon").toggle("fast");
    e.preventDefault();
});
$("#pp").click(function(e) {
	$("#ppcon").toggle("fast");
    e.preventDefault();
});
});
</script>
<?php include('../utils/analytics.inc.php');?></head>
<body>
<center>
<?php include_once isset($_SESSION['_userId']) ? '../common/header_2.inc.php' : '../common/header_1.inc.php';?>
<div id="page_body">
<?php if( isset($_SESSION['_userId']) ) { include_once '../common/path_nav.inc.php'; ?>
<div id="top_link_saperator"></div>
<?php } else {?>
<div style="height:1px;"></div>
<?php } ?>
<div id="uagr">
<h1><?php echo $l_ptitle?></h1>
<div class="sepa"></div>
<div id="content">
<ul>
<li class="prim"><h2><a id="ts" href=""><?php echo $l_terms?></a></h2>
<div id="tscon">
<?php foreach( $l_term as $term ) { echo '<p>'.$term.'</p>'; } ?>
<h3><?php echo $l_t_acc?></h3>
<ol>
<?php foreach( $l_account as $account ) { echo '<li>'.$account.'</li>'; } ?>
</ol>
<h3><?php echo $l_t_copy?></h3>
<ol>
<?php foreach( $l_copy as $copy ) { echo '<li>'.$copy.'</li>'; } ?>
</ol>
<h3><?php echo $l_t_general?></h3>
<ol>
<?php foreach( $l_general as $general ) { echo '<li>'.$general.'</li>'; } ?>
</ol>
</div></li>
<li class="prim"><h2><a id="pp" href=""><?php echo $l_privacies?></a></h2>
<div id="ppcon">
<?php foreach( $l_privacy as $privacy ) { echo '<p>'.$privacy.'</p>'; } ?>
<ol>
<?php foreach( $l_exception as $exception ) { echo '<li>'.$exception.'</li>'; } ?>
</ol>
<h3><?php echo $l_t_info?></h3>
<ol>
<?php foreach( $l_info as $info ) { echo '<li>'.$info.'</li>'; } ?>
</ol>
<h3><?php echo $l_t_cookie?></h3>
<ol>
<?php foreach( $l_cookie as $cookie ) { echo '<li>'.$cookie.'</li>'; } ?>
</ol>
<h3><?php echo $l_t_data?></h3>
<ol>
<?php foreach( $l_data as $data ) { echo '<li>'.$data.'</li>'; } ?>
</ol>
<h3><?php echo $l_t_changes?></h3>
<ol>
<?php foreach( $l_changes as $changes ) { echo '<li>'.$changes.'</li>'; } ?>
</ol>
</div></li>
</ul>
</div>
</div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>