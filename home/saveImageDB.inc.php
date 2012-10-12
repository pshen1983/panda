<?php
include_once ("../common/Objects.php");
include_once ("../utils/SessionUtil.php");
include_once ("../utils/SecurityUtil.php");
include_once ("../utils/DatabaseUtil.php");

session_start();
SecurityUtil::checkLogin($_SERVER['REQUEST_URI']);

if( isset($_SESSION['pro_image_tar']) && file_exists($_SESSION['pro_image_tar']) )
{
	$title = '../tmp/temp_profile_img.'.$_SESSION['_userId'];

	$fp = fopen($_SESSION['pro_image_tar'], 'r');
	$content = fread($fp, filesize($_SESSION['pro_image_tar']));
	$content = addslashes($content);
	fclose($fp);

	if( DatabaseUtil::updatePic($_SESSION['_userId'], $content) )
	{
		if(isset($_SESSION['pro_image_src']))
		{
			unlink($_SESSION['pro_image_src']);
			unset($_SESSION['pro_image_src']);
		}

		rename($title.'_tar.png', $title);
		unset($_SESSION['pro_image_tar']);
		$_SESSION['_loginUser']->pic = $title;

		header('Location: ../home/profile.php');
	}
	else header('Location: ../home/image_picker.php');;
}
else header('Location: ../home/profile.php');
?>