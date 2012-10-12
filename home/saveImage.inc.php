<?php
include_once ("../common/Objects.php");
if(!isset($_SESSION)) session_start();
if( isset($_SESSION['_userId']) )
{
	include_once ("../utils/SecurityUtil.php");
	
	if (isset($_SESSION['pro_image_src']) && !empty($_SESSION['pro_image_src']) &&
		isset($_SESSION['pro_image_tar']) && !empty($_SESSION['pro_image_tar']) &&
		isset($_GET['p1']) && is_numeric($_GET['p1']) &&
		isset($_GET['p2']) && is_numeric($_GET['p2']) &&
		isset($_GET['p3']) && is_numeric($_GET['p3']) &&
		isset($_GET['p4']) && is_numeric($_GET['p4']) )
	{
		$src = imagecreatefrompng($_SESSION['pro_image_src']);
		$dest = imagecreatetruecolor($_GET['p3'], $_GET['p4']);
	
		imagecopy($dest, $src, 0, 0, $_GET['p1'], $_GET['p2'], $_GET['p3'], $_GET['p4']);
	
		$width = $_GET['p3'];
		$height = $_GET['p4'];
	
		$standard = 100;
		$ratio1 = $standard / $height;
		$ratio2 = $standard / $width;
	
		$ratio = ($ratio1 > $ratio2) ? $ratio2 : $ratio1;
	
		$f_height = $height*$ratio;
		$f_width = $width*$ratio;
	
		$tmp=imagecreatetruecolor($f_width, $f_height);
		imagecopyresampled($tmp,$dest,0,0,0,0,$f_width,$f_height,$width,$height);
	
		imagepng($tmp, $_SESSION['pro_image_tar'], 0);
	
		imagedestroy($dest);
		imagedestroy($tmp);
		imagedestroy($src);
	}
}
else {
	echo 1;
}
?>