<?php
include_once ("../common/Objects.php");
include_once ("../utils/DatabaseUtil.php");
include_once ("../utils/SecurityUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

//============================================= Language ==================================================

if($_SESSION['_language'] == 'en') {
	$l_title = '';
	$l_back_prof = 'Back to My Profile';

	$l_chang_pic = 'Changing Your profile picture';
	$l_current_pic = 'Your current profile picture';
	$l_upload_image = 'Upload Image';
	
	$l_submit_botton = 'Submit';
	$l_cancel_botton = 'Cancel';
	
	$l_how_update = 'To update your profile picture';
	$l_how_1 = 'Upload an image (.jpg, .jpeg, .gif, .png).';
	$l_how_2 = 'Use Image Picker to pick your profile picture.';
	$l_how_3 = 'Resize Picker by moving the right and bottom edges.';
	$l_how_4 = 'Click Submit button to change your profile image.';
}
else if($_SESSION['_language'] == 'zh') {
	$l_title = '';
	$l_back_prof = '&#36820;&#22238;&#20010;&#20154;&#36164;&#26009;';
	
	$l_chang_pic = '&#26356;&#26032;&#25105;&#30340;&#22836;&#20687;';
	$l_current_pic = '&#25105;&#30446;&#21069;&#30340;&#22836;&#20687;&#29031;';
	$l_upload_image = '&#19978;&#20256;&#29031;&#29255;';
	
	$l_submit_botton = '&#30830;&#23450;';
	$l_cancel_botton = '&#21462;&#28040;';
	
	$l_how_update = '&#24590;&#26679;&#26356;&#26032;&#25105;&#30340;&#22836;&#20687;&#29031;';
	$l_how_1 = '&#19978;&#20256;&#19968;&#24352;&#29031;&#29255; (.jpg, .jpeg, .gif, .png)&#12290;';
	$l_how_2 = '&#36873;&#25321;&#29031;&#29255;&#30340;&#19968;&#37096;&#20998;&#20316;&#20026;&#22836;&#20687;&#12290;';
	$l_how_3 = '&#29031;&#29255;&#36873;&#25321;&#26694;&#30340;&#21491;&#36793;&#21644;&#19979;&#36793;&#21487;&#35843;&#25972;&#36873;&#25321;&#26694;&#30340;&#22823;&#23567;&#12290;';
	$l_how_4 = '&#36873;&#25321;&#21518;&#65292;&#28857;&#30830;&#23450;&#26356;&#24418;&#22836;&#20687;&#12290;';
}

//=========================================================================================================

$standard = 600;
$f_width = $standard;
$f_height = $standard;
$title = '../tmp/temp_profile_img.'.$_SESSION['_userId'];
$tmp = '';
$_SESSION['pro_image_src'] = '';
$_SESSION['pro_image_tar'] = null;

if( isset($_FILES["file"]) && $_FILES["file"]["size"]/1048576 < 2 )
{
	$fext = strtolower(substr(strrchr($_FILES["file"]["name"],"."),1));
	$fext = strtolower($fext);

	if($fext=="jpg" || $fext=="jpeg") {
		$image = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
	}
	else if ($fext=="gif") {
		$image = imagecreatefromgif($_FILES["file"]["tmp_name"]);
	}
	else if ($fext=="png") {
		$image = imagecreatefrompng($_FILES["file"]["tmp_name"]);
	}
	else {
		$image = null;
	}

	if (isset($image)) {
		list($width,$height)=getimagesize($_FILES["file"]["tmp_name"]);

		$ratio1 = $standard / $height;
		$ratio2 = $standard / $width;

		$ratio = ($ratio1 > $ratio2) ? $ratio2 : $ratio1;

		$f_height = $height*$ratio;
		$f_width = $width*$ratio;

		$tmp=imagecreatetruecolor($f_width, $f_height);
		imagecopyresampled($tmp,$image,0,0,0,0,$f_width,$f_height,$width,$height);

		$_SESSION['pro_image_src'] = $title.'.png';
		$_SESSION['pro_image_tar'] = $title.'_tar.png';

		imagepng($tmp, $_SESSION['pro_image_src'], 0);
	}
	else {
		$output='<div><label class="err_info">- Invalid image format (required format: gif, jpg, jpeg and png)</label></div>';
	}
}
else if (isset($_FILES["file"])) {
	$output='<div><label class="err_info">- Exceeding the maximun image fize 2Mb.</label></div>';
}

if(file_exists($_SESSION['pro_image_src'])) 
	list($f_width, $f_height) = getimagesize($_SESSION['pro_image_src']);

$change = isset($_FILES["file"]) && !isset($output) && file_exists($_SESSION['pro_image_src']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $l_title?></title><link rel="shortcut icon" href="../image/favicon.ico" />
<link rel='stylesheet' type='text/css' href='css/home_layout.css' />
<link rel='stylesheet' type='text/css' href='../css/proj_layout.css' />
<script type='text/javascript' src="../js/home.js"></script>
<script type='text/javascript' src="../js/common.js"></script>
<?php include('../utils/analytics.inc.php');?></head>
    <body onLoad="<?php echo $change ? 'javascript:pickSelectedImage()' : ''?>">
    <center>
<?php include_once '../common/header_2.inc.php';?>
	<div id="page_body">
<?php include_once '../common/path_nav.inc.php';?>
<div id="top_link_saperator"></div>
<div style="text-align:left;">
<div style="margin-left:20px;text-align:left;float:right;">
<form style="width:<?php echo $standard;?>px;#margin-top:10px;" action="image_picker.php" method="post" enctype="multipart/form-data" accept="image/gif,image/png,image/jpeg,image/pjpeg" accept-charset="UTF-8">
<?php echo isset($output) ? $output : " ";?>
<label class="info_label"><?php echo $l_upload_image?></label>
<input style="font-size:.8em;width:480px" type="file" name="file" id="file" onchange="this.form.submit()" />
<label style="font-size:.75em;font-weight:normal;">(&lt;2Mb)</label>
</form>
<div style="margin-top:10px;width:<?php echo $standard?>px;height:<?php echo $standard?>px;border: 1px solid black;">
<div style="position:relative;<?php 
if($f_width>$f_height)
	echo 'top:'.($standard-$f_height)/2;
else 
	echo 'left:'.($standard-$f_width)/2;
?>px;width:<?php echo $f_width?>px;height:<?php echo $f_height?>px;background-image:url('<?php print $_SESSION['pro_image_src'];?>')">
<div id="pic_holder" style="width:<?php echo $f_width?>px;height:<?php echo $f_height?>px;background-color:black;filter:alpha(opacity=50);opacity:0.5">
<?php if(file_exists($_SESSION['pro_image_src'])) { ?>
<div id="pic_select" style="position:relative;left:<?php echo $f_width/2-60?>px;top:<?php echo $f_height/2-60?>px;cursor:move;border-left:1px solid white;border-top:1px solid white;border-right:2px solid orange;border-bottom:2px solid orange;width:120px;height:120px;background-color:white;filter:alpha(opacity=40);opacity:0.60" onmousedown="javascript:down(event);" onmouseup="javascript:up();" onmousemove="javascript:over(event);"></div>
<?php }?>
</div></div></div>
</div>

<div style="margin-top:10px;margin-left:20px;width:330px;height:650px;text-align:left;">
<div><label style="color:blue">&laquo; <a class="back_profile" href="../home/profile.php"> <?php echo $l_back_prof?></a></label></div>
<div style="margin-left:80px;position:relative;top:100px;">
<label class="info_label"><?php echo $change ? $l_chang_pic : $l_current_pic?>:</label>
<form action="../home/saveImageDB.inc.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<img id="sel_result" src="<?php echo isset($_SESSION['pro_image_tar']) ? $_SESSION['pro_image_tar'] : $_SESSION['_loginUser']->pic?>" />
<input id="sel_result_input" type="hidden" value="<?php echo isset($_SESSION['pro_image_tar']) ? $_SESSION['pro_image_tar'] : ''?>" /> <br>
<div style="margin-top:20px;">
<input class="upload_doc_button_input" onmousedown="mousePress('upload_pic_button');" onmouseup="mouseRelease('upload_pic_button');" onmouseout="mouseRelease('upload_pic_button');" type="submit" value="<?php echo $l_submit_botton?>" id="upload_pic_button" style="margin-right:20px;"/>
<input class="upload_doc_button_input" onmousedown="mousePress('cancel_pic_button');" onmouseup="mouseRelease('cancel_pic_button');" onmouseout="mouseRelease('cancel_pic_button');" type="button" value="<?php echo $l_cancel_botton?>" id="cancel_pic_button" onClick="window.location.href='../home/profile.php'" />
</div>
</form>
</div>
<div style="position:relative;top:200px;font-size:.8em;color:#184D94;background-color:#F7DE9E;border:1px solid orange">
<div style="margin-left:10px;padding-top:10px;padding-bottom:10px">
<b><?php echo $l_how_update?>:</b>
<ol>
<li><?php echo $l_how_1?></li>
<li><?php echo $l_how_2?></li>
<li><?php echo $l_how_3?></li>
<li><?php echo $l_how_4?></li>
</ol>
</div>
</div></div>
</div>
</div>
<?php include_once '../common/footer_1.inc.php';?>
</center>
</body>
</html>