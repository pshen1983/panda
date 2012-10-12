<style type="text/css">
	a.footer{color:#00c;font-family:tahoma;font-size:12px;text-decoration:none;}
	a.footer:hover{text-decoration:underline;}
	a.icp{color:#AAA;font-family:tahoma;font-size:12px;text-decoration:none;margin-left:10px;}
	a.icp:hover{color:#333;text-decoration:underline;}
	label.footer{padding-left:1px;padding-right:1px;color:#AAAAAA;font-size:14px;}
	a.highlight{color:#DB0050;}

	div#lang_list{visibility:hidden;position:absolute;background-color:#F8F8F8;padding:0px 3px 0px 3px;border-right:1px solid #DDD;border-bottom:1px solid #DDD;}
</style>
<script language="JavaScript" src="../js/common.js"></script>
<?php 
	if($_SESSION['_language']=='en') {
		$l_pengshen = 'Peng Shen Product';
		$l_about = 'About';
		$l_contact = 'Contact';
		$l_help = 'Help';
		$l_forum = 'Forum';
		$l_feedback = 'Feedback';
		$l_follow = 'Follow';
		$l_language = '&#36873;&#25321;&#35821;&#35328;';
		
	}
	else if($_SESSION['_language']=='zh') {
		$l_pengshen = '申芃作品';
		$l_about = '&#20851;&#20110;';
		$l_contact = '&#32852;&#31995;&#25105;&#20204;';
		$l_help = '&#24110;&#21161;';
		$l_forum = '进入论坛';
		$l_feedback = '&#24847;&#35265;&#21453;&#39304;';
		$l_follow = '&#20851;&#27880;&#25105;&#20204;';
		$l_language = 'Choose Language';
	}
?>
<div style="width:980px;height:50px;">
<label style="margin-top:5px;font-size:12px;color:#AAAAAA;float:left;padding-left:2.5%;">&copy; <?php echo date('Y')?> ProjNote<!-- a class="icp" href="mailto:pshen1983@gmail.com" target="_blank"><?php echo $l_pengshen?></a --></label>
<div style="float:right;padding-right:40px;" >
<a id="lang_link" href="javascript:getLangList()" class="footer"><?php echo $l_language?> <span id="lang_arrow">&#9660;</span></a>
<label class="footer">|</label>
<a href="../about/index.php" class="footer"><?php echo $l_about?></a>
<label class="footer">|</label>
<a href="../help/index.php" class="footer"><?php echo $l_help?></a>
<label class="footer">|</label>
<a href="../forum/index.php" class="footer highlight"><?php echo $l_forum?></a>
<label class="footer">|</label>
<a href="../about/feedback.php" class="footer"><?php echo $l_feedback?></a>
<label class="footer">|</label>
<a href="../about/contact.php" class="footer"><?php echo $l_contact?></a>
</div>
<div id="lang_list">
<?php include_once 'language.inc.php';?>
</div>
</div>